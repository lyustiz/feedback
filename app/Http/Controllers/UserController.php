<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Table;
use App\Models\Agency;
use App\Models\GoalType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\UserTrait;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use App\Http\Controllers\Traits\AmolatinaDataTrait as Amolatina;

class UserController extends Controller
{
    use UserTrait, Amolatina;
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with([])
                    ->get();
    }

    public function show(Request $request, User $user)
    {
       return $user->load([ 'group', 'profile', 'role', 'table', 'table.manager', 'coordinator', 'tableTurn.turn' ])
                   ->loadSum(['presenceDay', 'presenceMonth' ], 'profit')
                   ->loadSum(['presenceDay', 'presenceMonth' ], 'bonus')
                   ->loadSum(['presenceDay', 'presenceMonth' ], 'writeoff');
    }

    public function list(Request $request)
    {
        $roles = ($request->filled('role')) ? $request->role : [];
        
        return  User::with(['group', 'table.manager', 'profile', 'role', 'tableTurn.turn', 'penaltyMonth.penaltyType'])
                    ->withSum(['presenceDay', 'presenceMonth' ], 'profit')
                    ->withSum(['presenceDay', 'presenceMonth' ], 'bonus')
                    ->withSum(['presenceDay', 'presenceMonth' ], 'writeoff')
                    ->operator($request->boolean('operator'))
                    ->coordinator($request->boolean('coordinator'))
                    ->manager($request->boolean('manager'))
                    ->role($roles)
                    ->orderBy('role_id')
                    ->orderBy('name')
                    ->get(); 
    }

    public function listTable()
    {
        $coordinator = \Auth::user();
        
        return User::with('group', 'table.manager', 'table.coordinator', 'profile', 'role', 'turn:turn.id,name', 'penaltyMonth.penaltyType')
                    ->withSum(['presenceDay', 'presenceMonth' ], 'profit')
                    ->withSum(['presenceDay', 'presenceMonth' ], 'bonus')
                    ->withSum(['presenceDay', 'presenceMonth' ], 'writeoff')
                    ->operator(true)
                    ->where('table_turn_id', $coordinator->table_turn_id)
                    ->orderBy('name')
                    ->get(); 
    }

    public function statistics(Request $request, $tableId)
    {
        $validate = request()->validate([
			'start_at'          => 	'required|date',
			'end_at'            => 	'required|date',
        ]);

        $start_at = Carbon::parse($request->start_at)->startOfDay();
        $end_at   = Carbon::parse($request->end_at)->endOfDay();

        if($start_at->greaterThan($end_at))
        {
            $tmp      = $start_at;   
            $start_at = $end_at;
            $end_at   = $tmp;
        } 

        $users =  User::with([ 'role', 'turn:turn.id,name', 'profile',
                        'presence' => function($query) use ( $start_at, $end_at ) {
                            $query->whereBetween('start_at', [ $start_at, $end_at ]);
                        },
                        'profilePrecense' => function($query) use ( $start_at, $end_at ) {
                            $query->whereBetween('start_at', [ $start_at, $end_at ]);
                        },
                    ])
                    ->withSum([ 'presence' => function (Builder $query) use ( $start_at, $end_at ) {
                                    $query->whereBetween('start_at', [ $start_at, $end_at ]);
                                },
                              ], 'bonus')
                    ->withSum([ 'presence' => function (Builder $query) use ( $start_at, $end_at ) {
                                    $query->whereBetween('start_at', [ $start_at, $end_at ]);
                                },
                              ], 'writeoff')
                    ->role([3,4])
                    ->whereHas('tableTurn', function (Builder $query) use($tableId) {
                        $query->where('table_id', $tableId);
                    })
                    ->orderBy('name')
                    ->get()
                    ->toArray(); 

        foreach ($users as $keyu => $user ) {
            if(isset($user['profile_precense']))
            {
                foreach ($user['profile_precense'] AS $keyp => $profile)
                {
                    $profilePresence = $this->getProfilePresence($profile, $user['presence']);
                    $users[$keyu]['profile_precense'][$keyp]['presence'] = $profilePresence['presence'];
                    $users[$keyu]['profile_precense'][$keyp]['sumBonus'] = $profilePresence['sumBonus'];
                    $users[$keyu]['profile_precense'][$keyp]['countWriteoff'] = $profilePresence['countWriteoff'];
                }
            }
        }

        return $users;
    }

    public function getProfilePresence($profile, $presences)
    {
        $profilePresence = [];
        $sumBonus        = 0;
        $countWriteoff    = 0;
        foreach ($presences as $presence) {
            if($presence['profile_id'] == $profile['id'])
            {
                $profilePresence[] = $presence;
                $sumBonus      += $presence['bonus'];
                $countWriteoff += ($presence['writeoff'] > 0 ) ? 1: 0;
            }
        }
        return [ 'presence' => $profilePresence, 'sumBonus' => $sumBonus, 'countWriteoff' =>  $countWriteoff];
    }

    public function userWiths($request)
    {
        $withs = [];

        if ($request->filled('with')) {
            if(is_array($request->with))
            {
                foreach ($request->with as $input) {
                    $withs[] = $input;
                }
            } else {
                $withs[] = $request->with;
            }
        }
        return $withs;
    }

    /*************** NOMINA *******************/

    public function payOperators($date)
    {
       
        $startMonth =  Carbon::parse($date)->startOfMonth(); 
        $endMonth   =  Carbon::parse($date)->endOfMonth(); 
        $fortnight  =  Carbon::parse($date)->startOfMonth()->addDays(15);

        $from = $startMonth->toDateString();
        $to   = $endMonth->toDateString();
        $date = $startMonth->format('Y-m');

        $agencies = Agency::with([ 'goalType' ])->select('amolatina_id', 'token', 'status_id')->get();

        $totalAgencies = 0;

        foreach ($agencies as $agency) {
            $response = $this->getTotalsAgency($agency->token, $agency->amolatina_id, $from, $to, $date);
            if($response['ok'])
            {
                $values = $response['body']['items']['0'];
                $totalAgencies += $values['positive'];
            } 
        }

        $goalName    = 'feddback';
        $agencyBonus = 15;

        foreach ($agencies[0]->goalType as $goalType) {
            if($totalAgencies < $goalType->amount) break;
            $agencyBonus = $goalType->bonus;
            $goalName    = $goalType->name;
        }

        

        $operatos = \DB::select( \DB::raw("SELECT u1.name nombre, u1.surname apellido, ta.name mesa, tu.name turno, tu.id turn_id, u1.goal_month meta_mes, u1.in_house, u1.is_alternate, u1.work_time,
                                            (SELECT IFNULL(SUM(bonus), 0.00) 
                                               FROM user_presence 
                                              WHERE user_id = u1.id 
                                                AND start_at  >= '$startMonth' 
                                                AND end_at < '$fortnight') puntos_quincena,
                                            (SELECT IFNULL(SUM(bonus), 0.00) 
                                               FROM user_presence 
                                              WHERE user_id = u1.id 
                                                AND start_at  >= '$fortnight' 
                                                AND end_at < '$endMonth') puntos_ultimo,
                                            (SELECT IFNULL(SUM(bonus), 0.00) 
                                               FROM user_presence 
                                              WHERE user_id = u1.id 
                                                AND start_at  >= '$startMonth' 
                                                AND end_at <= '$endMonth') puntos_mes,
                                            (SELECT CASE 
                                                    WHEN SUM(bonus) <  750 THEN 0.02
                                                    WHEN SUM(bonus) >= 750 AND SUM(bonus) <= 3000 THEN 0.03
                                                    WHEN SUM(bonus) > 3000 THEN 0.04 END AS porc_bonus
                                                FROM user_presence 
                                               WHERE user_id = u1.id 
                                                 AND start_at  >= '$startMonth' 
                                                 AND end_at <= '$endMonth') bonus_puntos,
                                            '$goalName' tipo_meta,
                                            $agencyBonus  bonus_agencia,
                                        (SELECT COUNT(id) FROM penalty WHERE user_id = u1.id AND day  >= '2021-06-01' AND day < '2021-06-30') penalty
                                    FROM user u1
                                    JOIN table_turn tt on tt.id = u1.table_turn_id 
                                    JOIN `table` ta on ta.id = tt.table_id
                                    JOIN turn tu on tu.id = tt.turn_id
                                   WHERE role_id = 4
                                     AND u1.deleted_at IS NULL
                                     AND u1.id in (select user_id from user_presence)
                                ORDER BY ta.name, tu.name, u1.name"), []);

        foreach ($operatos as $key => $operator) {
            $operatos[$key]->salary_month = $this->getSalaryMonth($operator->turn_id, $operator->work_time,  $operator->is_alternate);
            $operatos[$key]->salary_fortnight = round($operatos[$key]->salary_month/2, 2);
            $operatos[$key]->total_bonus_puntos = round($operator->puntos_mes * $operator->bonus_puntos, 2);
            $operatos[$key]->bonus_in_house = $this->getBonusInHouse($operator->in_house, $operator->work_time);
            $operatos[$key]->bonus_total = round($operatos[$key]->salary_month + $operatos[$key]->total_bonus_puntos + $operatos[$key]->bonus_in_house + $operatos[$key]->bonus_agencia, 2);
        }        

        return  $operatos;

    }

    public function getSalaryMonth($turnId, $workTime, $isAlternate)
    {
        $salaryMonth = ($isAlternate == 1) ? 40 : 0;
        switch (true) {
            case $turnId == 1 and $workTime = 8:
                return $salaryMonth + 95;
            case $turnId == 1 and $workTime = 12:
                return $salaryMonth + 140;
            case $turnId == 2 and $workTime = 8:
                return $salaryMonth + 100;
            case $turnId == 3 and $workTime = 8:
                return $salaryMonth + 110;
            case $turnId == 3 and $workTime = 12:
                return $salaryMonth + 160;
            default:
                return $salaryMonth;
        }
    }

    public function payCoordinators($date)
    {
        $startMonth =  Carbon::parse($date)->startOfMonth(); 
        $endMonth   =  Carbon::parse($date)->endOfMonth(); 
        $fortnight  =  Carbon::parse($date)->startOfMonth()->addDays(15);

        $from = $startMonth->toDateString();
        $to   = $endMonth->toDateString();
        $date = $startMonth->format('Y-m');

        $agencies = Agency::with([ 'goalType' ])->select('amolatina_id', 'token', 'status_id')->get();

        $totalAgencies = 0;

        foreach ($agencies as $agency) {
            $response = $this->getTotalsAgency($agency->token, $agency->amolatina_id, $from, $to, $date);
            if($response['ok'])
            {
                $values = $response['body']['items']['0'];
                $totalAgencies += $values['positive'];
            } 
        }

        $goalName    = 'feddback';
        $agencyBonus = 15;

        foreach ($agencies[0]->goalType as $goalType) {
            if($totalAgencies < $goalType->amount) break;
            $agencyBonus = $goalType->bonus;
            $goalName    = $goalType->name;
        }

        $operatos = \DB::select( \DB::raw("SELECT u1.name nombre, u1.surname apellido, ta.name mesa, tu.name turno, tu.id turn_id, u1.goal_month meta_mes, u1.in_house, u1.is_alternate, u1.work_time,
                                                (SELECT SUM(bonus) 
                                                    FROM user_presence 
                                                WHERE start_at  >= '$startMonth' 
                                                    AND end_at <= '$endMonth'
                                                    AND user_id IN (SELECT u2.id 
                                                                      FROM user u2 
                                                                     WHERE u2.table_turn_id = u1.table_turn_id)) puntos_mes,
                                                    '$goalName' tipo_meta,
                                                    $agencyBonus  bonus_agencia,
                                                    (SELECT COUNT(id) FROM penalty WHERE user_id = u1.id AND day  >= '2021-06-01' AND day < '2021-06-30') penalty
                                            FROM user u1
                                            JOIN table_turn tt on tt.id = u1.table_turn_id 
                                            JOIN `table` ta on ta.id = tt.table_id
                                            JOIN turn tu on tu.id = tt.turn_id
                                           WHERE role_id = 3
                                             AND u1.deleted_at IS NULL
                                             AND u1.id in (SELECT user_id FROM user_presence)
                                        ORDER BY ta.name, tu.name"), []);

        foreach ($operatos as $key => $operator) {
            $operatos[$key]->salary_month = $this->getSalaryMonth($operator->turn_id, $operator->work_time,  $operator->is_alternate);
            $operatos[$key]->salary_fortnight = round($operatos[$key]->salary_month/2, 2);
            $operatos[$key]->bonus_puntos  = 0.04;
            $operatos[$key]->total_bonus_puntos = round($operator->puntos_mes * $operatos[$key]->bonus_puntos, 2);
            $operatos[$key]->bonus_in_house = $this->getBonusInHouse($operator->in_house, $operator->work_time);
            $operatos[$key]->bonus_total = round($operatos[$key]->salary_month + $operatos[$key]->total_bonus_puntos + $operatos[$key]->bonus_in_house + $operatos[$key]->bonus_agencia, 2);
        }        

        return  $operatos;

    }

    public function getBonusPoints($pointsMonths)
    {
        switch (true) {
            case $pointsMonths < 750:
                return 0.02;
            case $pointsMonths >= 750 and $pointsMonths <= 3000:
                return 0.03;
            case $pointsMonths > 3000:
                return 0.04;
            default:
                return 0;
        }
    }

    public function getBonusInHouse($inHouse, $workTime)
    {
        switch (true) {
            case ($inHouse == 1 and $workTime == 8) : 
                return 20;
            case ($inHouse == 1 and $workTime == 12):
                return 25;
            default:
                return 0;
        }
    }

    public function getTotalsAgency($token, $amolatinaId, $from, $to, $date)
    {       
        $setup          = Amolatina::getSetup('total-agency');
        $url            = $setup->url . '/' . $amolatinaId;
        $params         = $setup->params;
        $params['date'] = $date;
        $params['from'] = $from;
        $params['to']   = $to;
        return   Amolatina::getDataUrl( $token, $url, $params, []);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = request()->validate([
			'password'          => 	'required|string',
			'name'              => 	'nullable|string|max:50',
			'surname'           => 	'nullable|string|max:50',
			'role_id'           => 	'required|integer|max:999999999',
            'rolename'          => 	'required|string|max:30',
			'agency_id'         => 	'required|integer|max:999999999',
			'group_id'          => 	'required|integer|max:999999999',
            'table_id'          => 	'required|integer|max:999999999',
            'turn_id'           => 	'required|integer|max:999999999',
            'table_turn_id'     => 	'required|integer|max:999999999',
			'photo'             => 	'nullable|string',
			'email'             => 	'nullable|string|max:100',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $username  = UserTrait::makeUsername($request);

        $password  = Hash::make($request->password);

        $photoname =  $username . '.jpeg';

        if($this->storeImage($request->photo, $photoname, 'operator'))
        {
            $request-> merge (['username' => $username, 'password' => $password, 'photo' => $photoname ]);
            $user = User::create($request->all());

        } else {

            throw ValidationException::withMessages(['photoError' => "No se cargo la imagen"]);
        }

        if($user->role_id == 3)
        {
            $this->setTableCoordinator($user);
        }

        return [ 'msj' => "Usuario Agregado Correctamente", compact('user') ];
    }

    public function setTableCoordinator($user)
    {
        $coordinator = $user->coordinator;

        User::where('table_turn_id', $user->table_turn_id)->where('id', '<>',$user->id )->update(['role_id' => 4]);
        
        $user->tableTurn->update(['coordinator_id' => $user->id]);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
   
        $validate = request()->validate([
			'password'          => 	'nullable|string|min:6',
			'name'              => 	'nullable|string|max:50',
			'surname'           => 	'nullable|string|max:50',
			'role_id'           => 	'required|integer|max:999999999',
            'rolename'          => 	'required|string|max:30',
			'group_id'          => 	'required|integer|max:999999999',
            'group_id'          => 	'required|integer|max:999999999',
            'table_id'          => 	'required|integer|max:999999999',
            'turn_id'           => 	'required|integer|max:999999999',
            'table_turn_id'     => 	'required|integer|max:999999999',
			'photo'             => 	'nullable|string',
			'email'             => 	'nullable|string|max:100',
			'comments'          => 	'nullable|string|max:100',
			'user_id'           => 	'required|integer|max:999999999',
        ]);
        
        if($user->id == 1)
        {
            throw ValidationException::withMessages(['adminedit' => "No es posible actualizar al Administrador"]);
        }

        if($user->role_id == 2)
        {
            throw ValidationException::withMessages(['manageredit' => "No es posible actualizar al Gerente"]);
        }
        


        if ($request->filled('password')) {
            $password  = Hash::make($request->password);
            $request->merge(['password' => $password]);
        } else {
            $request->merge(['password' => $user->password]);
        }

        if ($request->filled('photo')) {
            
            if(strpos($request->photo, 'base64,'))
            {
                $photoname =  $user->username . '.jpeg';
                
                if($this->storeImage($request->photo, $photoname, 'operator'))
                {
                    $request-> merge(['photo' => $photoname]);
                    
                } else {

                    throw ValidationException::withMessages(['photoError' => "No se crago la imagen"]);
                }
            }
        }

        if($request->role_id == 3 and $user->role_id != 3)
        {
            $this->setTableCoordinator($user);
        }

        $update = $user->update($request->all());

        return [ 'msj' => "Usuario Actualizado Correctamente", compact('update') ];
    }

    public function goals(Request $request, User $user)
    {
        $validate = request()->validate([
			'goal_day'   => 'required|integer|max:999999999',
            'goal_month' => 'required|integer|max:999999999',
			'user_id'    => 'required|integer|max:999999999',
        ]);

        $user = $user->update($request->all());

        return [ 'msj' => "Metas Actualizadas Correctamente", compact('user') ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user = $user->delete();
 
        return [ 'msj' => 'Usuario Eliminado' , compact('user')];
    }

    public function storeImage($imgSource, $imgName, $type)
	{
        $imgSource = substr($imgSource, strpos($imgSource, 'base64,') + 7);
    
        $imgSource = base64_decode($imgSource);

        return Storage::disk( 'photo_'. $type )->put(  $imgName, $imgSource );
    }

  

}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Table;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\UserTrait;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;


class UserController extends Controller
{
    use UserTrait;
   
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
        
        return User::with('group', 'table.manager', 'table.coordinator', 'profile', 'role', 'turn:id,name', 'penaltyMonth.penaltyType')
                    ->withSum(['presenceDay', 'presenceMonth' ], 'profit')
                    ->withSum(['presenceDay', 'presenceMonth' ], 'bonus')
                    ->withSum(['presenceDay', 'presenceMonth' ], 'writeoff')
                    ->operator(true)
                    ->where('table_turn_id', $coordinator->table_turn_id)
                    ->orderBy('name')
                    ->get(); 
    }

    public function statistics($tableId)
    {
        return User::with( 'profile.presenceDay.comissionDay', 'role', 'turn:id,name', 'penaltyMonth.penaltyType', 'presenceDay')
                    ->withSum(['presenceDay', 'presenceMonth' ], 'profit')
                    ->withSum(['presenceDay', 'presenceMonth' ], 'bonus')
                    ->withSum(['presenceDay', 'presenceMonth' ], 'writeoff')
                    ->operator(true)
                    ->where('table_turn_id', $tableId)
                    ->orderBy('name')
                    ->get(); 
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

        return [ 'msj' => ucfirst($request->rolename) . " Agregado Correctamente", compact('user') ];
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

        return [ 'msj' => ucfirst($request->rolename)." Actualizado Correctamente", compact('update') ];
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

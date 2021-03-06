<?php

namespace App\Http\Controllers;

use App\Models\Comission;
use App\Models\Agency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\AmolatinaDataTrait as Amolatina;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class ComissionController extends Controller
{
    use Amolatina;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Comission::with(['profile:id,amolatina_id,name,photo,gender'])
                        ->orderBy('comission_at', 'desc')
                        ->cursorPaginate(50)
                        ->withPath('comission');  
    }

    public function comissionPresence($precenseId)
    {       
        return Comission::with(['client', 'hasService'])
                        ->join('user_presence', 'comission.profile_id', '=', 'user_presence.amolatina_id')
                        ->where('user_presence.id', $precenseId)
                        ->whereRaw('comission.comission_at >= user_presence.start_at' )
                        ->whereRaw('comission.comission_at <= IFNULL(user_presence.end_at, UTC_TIMESTAMP())' )
                        ->get();
    }

    public function list(Request $request)
    {
        $commision =  Comission::with([
                            'profile:id,amolatina_id,name,photo,gender', 
                            'client:id,amolatina_id,name,photo,gender,points,crown', 
                            'hasService'
                        ]);
                        
        if($request->filled('agency'))   
        {
            $commision->where('agency_id',$request->agency);
        }

        if($request->filled('start_at'))   
        {
            $start_at = Carbon::parse($request->start_at);
            $end_at   = Carbon::parse($request->end_at);

            if($start_at->greaterThan($end_at))
            {
                $pivot    = $start_at;   
                $start_at = $end_at;
                $end_at   = $pivot;
            } 

            $start_at = $start_at->startOfDay();
            $end_at   = $end_at ->endOfDay();

            $commision->whereBetween('comission_at', [ $start_at, $end_at ]);
        }

        
        
        if($request->filled('positive'))   
        {
            $commision->where('positive', $request->positive);
        } 
        
        if($request->filled('service'))   
        {
            $commision->whereIn('service', $request->service);
        } 

        if($request->filled('profile'))   
        {
            $commision->where('profile_id', $request->profile);
        } 

        $total =  ($request->positive == 1) ? $commision->sum('points') : $commision->count('points');

        return [ 'total' => $total, 
                 'paginate' => $commision->orderBy('comission_at', 'desc')->cursorPaginate(50)->withPath('comission/list')];
    }

    public function comissionDetail()
    {
        set_time_limit ( 330 );
        ini_set('memory_limit', '-1');
        
        $currents = Comission::with(['agency:id,amolatina_id,name,token'])
                             ->groupBy('agency_id', 'positive')
                             ->get(['agency_id', 'positive',  \DB::raw('MAX(comission_at) as comission_at'),  \DB::raw('MAX(comission_id) as comission_id') ]); 
                
        $stored = []; 
        foreach ($currents  as $current) {

            $token        = $current->agency->token;
            $amolatina_id = $current->agency->amolatina_id;
            $start_at     = Carbon::parse($current->comission_at)->toDateTimeLocalString('millisecond');
            $end_at       = Carbon::now('UTC')->toDateTimeLocalString('millisecond');
            $response     = $this->getDetailCommisions($token, $amolatina_id, $start_at, $end_at, $current->positive );
            if($response['ok']) {
                $commisions = $response['body'];
                $stored[$start_at.'-'.$end_at.'-'.$amolatina_id] = count($this->storeCommision($commisions, $current->positive, $current->comission_id)) * 500;
            } else {
                $stored[$start_at . '-' . $end_at . '-' . $current->positive] = $response;
            }
        }
        return $stored;
    }

    public function fillComissionDetail($agencyID, $positive)
    {
        set_time_limit ( 1900 );
        
        $agency = Agency::find($agencyID);

        $commision = Comission::where(['agency_id' => $agency->amolatina_id, 'positive' => $positive ])->exists();

        if ($commision) {
            throw ValidationException::withMessages(['existRegisters' => "La agencia Posee Comisiones"]);
        }
        
        $token        = $agency->token;
        $amolatina_id = $agency->amolatina_id;
        $day          = Carbon::parse($agency->register_at);
        $days         = $day->diffInDays(Carbon::now()) + 1;

        $stored = [];

        for ($i = 1; $i <= $days ; $i++) { 
            
            $start_at = $day->startOfDay()->toISOString();

            $end_at   = $day->endOfDay()->toISOString();

            $response = $this->getDetailCommisions($token, $amolatina_id, $start_at, $end_at, $positive );
            
            if($response['ok'])
            {
                $commisions = $response['body'];
                $stored[$start_at.'-'.$end_at .'-'. $positive] = count($this->storeCommision($commisions, $positive, 0 ) ) * 500;
            }
            else {
                $stored[$start_at.'-'.$end_at] = $response;
            }
            $day = $day->addDay();
        }

        return $stored;
    }

    public function fillComissionMonth()
    {
        set_time_limit ( 1900 );
        
        $startOfMonth = Carbon::now()->startOfMonth();
        $days         = $startOfMonth->diffInDays(Carbon::now()) + 1;  

        $delete       = Comission::whereDate('comission_at', '>' , $startOfMonth)->delete();

        $currents     = Comission::with(['agency:id,amolatina_id,name,token'])
                                 ->groupBy('agency_id', 'positive')
                                 ->get(['agency_id', 'positive',  \DB::raw('MAX(comission_id) as comission_id') ]);
     
        $stored = [];            

        foreach ($currents  as $current) {

            $token        = $current->agency->token;
            $amolatina_id = $current->agency->amolatina_id;
            $positive     = $current->positive;

            for ($i = 1; $i <= $days ; $i++) { 
            
                $start_at = $startOfMonth->startOfDay()->toISOString();
    
                $end_at   = $startOfMonth->endOfDay()->toISOString();
    
                $response = $this->getDetailCommisions($token, $amolatina_id, $start_at, $end_at, $positive );
                
                if($response['ok'])
                {
                    $commisions = $response['body'];
                    $stored[$amolatina_id.'-'.$start_at.'-'.$end_at .'-'. $positive] = count($this->storeCommision($commisions, $positive, 0 ) ) * 500;
                }
                else {
                    $stored[$amolatina_id.'-'.$start_at.'-'.$end_at] = $response;
                }
                $day = $startOfMonth->addDay();
            }

            $startOfMonth = Carbon::now()->startOfMonth();
        }
        return $stored;
    }

    public function getDetailCommisions($token, $amolatinaId, $startAt, $endAt, $positive = 1)
    {
        $setup          = Amolatina::getSetup('credits-detail');
        $url            = $setup->url . '/' . $amolatinaId;
        $params         = $setup->params;
        $params['from'] = Amolatina::formatDateTime($startAt);
        $params['to']   = Amolatina::formatDateTime($endAt);
        $params['select']   = 100000;
        $params['positive'] =  ($positive == 1) ? 'true' : 'false';

        return   Amolatina::getDataUrl( $token, $url, $params);
    }

    public function storeCommision($commisions, $positive = null, $commision_id)
    {
        $data = [];

        foreach ($commisions as $row) {

            if( $row['commission-id'] >  $commision_id )
            {
                $comission_at = new \DateTime($row['timestamp']);
                
                $data[$row['commission-id']] = [
                    'comission_id' => $row['commission-id'],
                    'agency_id'    => $row['agency-id'],
                    'positive'     => $positive,
                    'curator_id'   => isset($row['curator-id']) ? $row['curator-id'] : 0 ,
                    'profile_id'   => isset($row['user-id']) ? $row['user-id'] : 0, 
                    'user_id'      => isset($row['user-id']) ? $row['user-id'] : 0,
                    'client_id'    => isset($row['target-id']) ? $row['target-id'] : 0, 
                    'service'      => $row['service'],
                    'fact'         => $row['fact'],
                    'points'       => $row['points'],
                    'profit'       => $row['profit'],
                    'share'        => $row['share'],
                    'comission_at' => $comission_at,
                    'user_id_ed'   => 1,
                    'created_at'   => date('Y-m-d H:i:s')
                ];
            }
        }

        $data = collect($data); 

        $chunks = $data->chunk(500);

        $insert = [];

        foreach ($chunks as $chunk)
        {
            $insert[] = Comission::insert($chunk->toArray());
        }

        return $insert;
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
            'comission_id'      => 	'required|integer|max:999999999',
			'fact'              => 	'nullable|string|max:200',
			'service'           => 	'nullable|string|max:100',
			'points'            => 	'nullable|numeric|max:9',
			'profit'            => 	'nullable|numeric|max:9',
			'share'             => 	'nullable|integer|max:999999999',
			'agency_id'         => 	'required|string|max:',
			'curator_id'        => 	'required|string|max:',
			'profile_id'        => 	'required|string|max:',
			'user_id'           => 	'nullable|integer|max:999999999',
			'cllient_id'        => 	'required|string|max:',
			'comments'          => 	'nullable|string|max:100',
			'user_id_ed'        => 	'required|integer|max:999999999',
        ]);

        $comission = comission::create($request->all());

        return [ 'msj' => 'Comission Agregado Correctamente', compact('comission') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comission  $comission
     * @return \Illuminate\Http\Response
     */
    public function show(Comission $comission)
    {
        return $comission;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comission  $comission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comission $comission)
    {
        $validate = request()->validate([
            'comission_id'      => 	'required|integer|max:999999999',
			'fact'              => 	'nullable|string|max:200',
			'service'           => 	'nullable|string|max:100',
			'points'            => 	'nullable|numeric|max:9',
			'profit'            => 	'nullable|numeric|max:9',
			'share'             => 	'nullable|integer|max:999999999',
			'agency_id'         => 	'required|string|max:',
			'curator_id'        => 	'required|string|max:',
			'profile_id'        => 	'required|string|max:',
			'user_id'           => 	'nullable|integer|max:999999999',
			'cllient_id'        => 	'required|string|max:',
			'comments'          => 	'nullable|string|max:100',
			'user_id_ed'        => 	'required|integer|max:999999999',
        ]);

        $comission = $comission->update($request->all());

        return [ 'msj' => 'Comission Editado' , compact('comission')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comission  $comission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comission $comission)
    {
        $comission = $comission->delete();
 
        return [ 'msj' => 'Comission Eliminado' , compact('comission')];
    }
}

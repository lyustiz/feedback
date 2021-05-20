<?php

namespace App\Http\Controllers;

use App\Models\Comission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\AmolatinaDataTrait as Amolatina;
use Carbon\Carbon;

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
        ->paginate(21)->withPath('comission');  
    }


    public function comissionDetail()
    {
        set_time_limit ( 300 );
        
        $currentCommisions = Comission::groupBy('agency_id')
                           ->get(['agency_id', \DB::raw('MAX(comission_at) as comission_at')]);

        $stored = []; 

        foreach ($currentCommisions  as  $currentCommision) {

            $token  = '33568305-c77b-4719-a97e-331610a9b170';
            $amolatina_id = $currentCommision->agency_id;
            $start =  Carbon::parse($currentCommision->comission_at)->toDateTimeLocalString('millisecond'); // ->addSecond(1)
            $end_at = Carbon::now('UTC')->toDateTimeLocalString('millisecond');
            
            $response = $this->getDetailCommisions($token, $amolatina_id, $start, $end_at );
            
            if($response['ok'])
            {
                $commisions = $response['body'];
                $stored[$amolatina_id] = $this->storeCommision($commisions);
            }
        }

        return $stored;
    }

    public function getDetailCommisions($token, $amolatinaId, $startAt, $endAt)
    {
        $setup          = Amolatina::getSetup('credits-detail');
        $url            = $setup->url . '/' . $amolatinaId;
        $params         = $setup->params;
        $params['from'] = Amolatina::formatDateTime($startAt);
        $params['to']   = Amolatina::formatDateTime($endAt);
        $params['select']   = 10000;

        return   Amolatina::getDataUrl( $token, $url, $params);
    }

    public function storeCommision($commisions)
    {
        $data = [];
        foreach ($commisions as $row) {

            $comission_at = new \DateTime($row['timestamp']);
           
            $data[] = [
                'comission_id' => $row['commission-id'],
                'agency_id'    => $row['agency-id'],
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

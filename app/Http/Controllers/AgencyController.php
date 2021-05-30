<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Traits\AmolatinaDataTrait as Amolatina;

class AgencyController extends Controller
{
    use Amolatina;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Agency::with([])
                    ->get();
    }

    public function agencyClients()
    {
        return Agency::with([])
                    ->withCount(['clients', 'clientsContacted', 'clientsCaptured', 'clientsPending', 'clientsDay', 'clientsWeek', 'clientsMonth' ])
                    ->get();
    }

    public function agencyClientsTop()
    {
        return Agency::with([   'clientsCaptured' => function($query) {
                                    $query->select('id','amolatina_id','name','points','crown', 'agency_id','gender', 'age', 'photo')
                                          ->orderBy('points', 'desc')
                                          ->limit(50);
                                }
                            ])
                    ->get();
    }
   
    

    

    public function agencyTotals(Request $request)
    {
        $validate = request()->validate([
            'token'        => 	'required',
			'amolatina_id' => 	'required',
            'type'         => 	'required',
        ]);
        
        $token  = $request->token;
        $url    = Amolatina::getSetup('total-credits')->url . '/' . $request->amolatina_id;
        $range  = Amolatina::dateRange($request->type);
        $params = [ 'from' => $range->from, 'to' => $range->to ];
        $header = [ 'accept' => 'application/json+vnd.sdv.numeric' ];
        $response = Amolatina::getDataUrl( $request->token, $url,  $params, $header);
        
        return response( [ 'data' => $response['body'], 'detail' => $response['detail']  ] , $response['status']) ;
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
            'name'              => 	'required|string|max:60',
			'parent_id'         => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $agency = agency::create($request->all());

        return [ 'msj' => 'Agency Agregado Correctamente', compact('agency') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function show(Agency $agency)
    {
        return $agency;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agency $agency)
    {
        $validate = request()->validate([
            'name'              => 	'required|string|max:60',
			'parent_id'         => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $agency = $agency->update($request->all());

        return [ 'msj' => 'Agency Editado' , compact('agency')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agency $agency)
    {
        $agency = $agency->delete();
 
        return [ 'msj' => 'Agency Eliminado' , compact('agency')];
    }
}

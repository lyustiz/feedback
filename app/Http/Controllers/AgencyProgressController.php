<?php

namespace App\Http\Controllers;

use App\Models\AgencyProgress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgencyProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AgencyProgress::with([])
                    ->get();
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
            'agency_id'         => 	'required|integer|max:999999999',
			'day_positive'      => 	'required|numeric|max:9',
			'day_negative'      => 	'required|numeric|max:9',
			'month_positive'    => 	'required|numeric|max:9',
			'month_negative'    => 	'required|numeric|max:9',
			'total_positive'    => 	'required|numeric|max:9',
			'total_negative'    => 	'required|numeric|max:9',
			'task_mails'        => 	'required|integer|max:999999999',
			'task_photos'       => 	'required|integer|max:999999999',
			'task_videos'       => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $agencyProgress = agencyProgress::create($request->all());

        return [ 'msj' => 'AgencyProgress Agregado Correctamente', compact('agencyProgress') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AgencyProgress  $agencyProgress
     * @return \Illuminate\Http\Response
     */
    public function show(AgencyProgress $agencyProgress)
    {
        return $agencyProgress;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AgencyProgress  $agencyProgress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AgencyProgress $agencyProgress)
    {
        $validate = request()->validate([
            'agency_id'         => 	'required|integer|max:999999999',
			'day_positive'      => 	'required|numeric|max:9',
			'day_negative'      => 	'required|numeric|max:9',
			'month_positive'    => 	'required|numeric|max:9',
			'month_negative'    => 	'required|numeric|max:9',
			'total_positive'    => 	'required|numeric|max:9',
			'total_negative'    => 	'required|numeric|max:9',
			'task_mails'        => 	'required|integer|max:999999999',
			'task_photos'       => 	'required|integer|max:999999999',
			'task_videos'       => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $agencyProgress = $agencyProgress->update($request->all());

        return [ 'msj' => 'AgencyProgress Editado' , compact('agencyProgress')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AgencyProgress  $agencyProgress
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgencyProgress $agencyProgress)
    {
        $agencyProgress = $agencyProgress->delete();
 
        return [ 'msj' => 'AgencyProgress Eliminado' , compact('agencyProgress')];
    }
}

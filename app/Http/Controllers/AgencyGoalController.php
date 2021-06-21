<?php

namespace App\Http\Controllers;

use App\Models\AgencyGoal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgencyGoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AgencyGoal::with([])
                    ->get();
    }

    public function byAgency($agencyId)
    {
        return AgencyGoal::with(['goalType'])
                    ->where('agency_id', $agencyId)
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
			'goal_type_id'      => 	'required|integer|max:999999999',
			'value'             => 	'nullable|integer|max:999999999',
			'start'             => 	'nullable|integer|max:999999999',
			'end'               => 	'nullable|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $agencyGoal = agencyGoal::create($request->all());

        return [ 'msj' => 'AgencyGoal Agregado Correctamente', compact('agencyGoal') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AgencyGoal  $agencyGoal
     * @return \Illuminate\Http\Response
     */
    public function show(AgencyGoal $agencyGoal)
    {
        return $agencyGoal;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AgencyGoal  $agencyGoal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AgencyGoal $agencyGoal)
    {
        $validate = request()->validate([
			'value'             => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $agencyGoal = $agencyGoal->update($validate);

        return [ 'msj' => 'Metas Actualizadas' , compact('agencyGoal')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AgencyGoal  $agencyGoal
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgencyGoal $agencyGoal)
    {
        $agencyGoal = $agencyGoal->delete();
 
        return [ 'msj' => 'AgencyGoal Eliminado' , compact('agencyGoal')];
    }
}

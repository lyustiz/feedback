<?php

namespace App\Http\Controllers;

use App\Models\MissedDay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MissedDayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MissedDay::with([])
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
            'day'               => 	'required|string|max:0',
			'user_id'           => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id_ed'        => 	'required|integer|max:999999999',
        ]);

        $missedDay = missedDay::create($request->all());

        return [ 'msj' => 'MissedDay Agregado Correctamente', compact('missedDay') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MissedDay  $missedDay
     * @return \Illuminate\Http\Response
     */
    public function show(MissedDay $missedDay)
    {
        return $missedDay;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MissedDay  $missedDay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MissedDay $missedDay)
    {
        $validate = request()->validate([
            'day'               => 	'required|string|max:0',
			'user_id'           => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id_ed'        => 	'required|integer|max:999999999',
        ]);

        $missedDay = $missedDay->update($request->all());

        return [ 'msj' => 'MissedDay Editado' , compact('missedDay')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MissedDay  $missedDay
     * @return \Illuminate\Http\Response
     */
    public function destroy(MissedDay $missedDay)
    {
        $missedDay = $missedDay->delete();
 
        return [ 'msj' => 'MissedDay Eliminado' , compact('missedDay')];
    }
}

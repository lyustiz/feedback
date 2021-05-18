<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Absence::with([])
                    ->get();
    }

    public function absenceUser($userId)
    {
        return Absence::with(['absenceType'])
                    ->where( 'user_id', $userId)
                    ->orderBY('day', 'desc')
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
            'day'               => 	'required|date',
			'user_id'           => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id_ed'        => 	'required|integer|max:999999999',
        ]);

        $absence = absence::create($request->all());

        return [ 'msj' => 'Absence Agregado Correctamente', compact('absence') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function show(Absence $absence)
    {
        return $absence;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Absence $absence)
    {
        $validate = request()->validate([
            'day'               => 	'required|date',
			'user_id'           => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id_ed'        => 	'required|integer|max:999999999',
        ]);

        $absence = $absence->update($request->all());

        return [ 'msj' => 'Absence Editado' , compact('absence')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absence $absence)
    {
        $absence = $absence->delete();
 
        return [ 'msj' => 'Absence Eliminado' , compact('absence')];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AbsenceType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AbsenceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AbsenceType::with([])
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
            'name'              => 	'required|string|max:60',
			'amount'            => 	'required|numeric|max:9',
			'icon'              => 	'nullable|string|max:50',
			'color'             => 	'nullable|string|max:50',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $absenceType = absenceType::create($request->all());

        return [ 'msj' => 'AbsenceType Agregado Correctamente', compact('absenceType') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AbsenceType  $absenceType
     * @return \Illuminate\Http\Response
     */
    public function show(AbsenceType $absenceType)
    {
        return $absenceType;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AbsenceType  $absenceType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AbsenceType $absenceType)
    {
        $validate = request()->validate([
            'name'              => 	'required|string|max:60',
			'amount'            => 	'required|numeric|max:9',
			'icon'              => 	'nullable|string|max:50',
			'color'             => 	'nullable|string|max:50',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $absenceType = $absenceType->update($request->all());

        return [ 'msj' => 'AbsenceType Editado' , compact('absenceType')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AbsenceType  $absenceType
     * @return \Illuminate\Http\Response
     */
    public function destroy(AbsenceType $absenceType)
    {
        $absenceType = $absenceType->delete();
 
        return [ 'msj' => 'AbsenceType Eliminado' , compact('absenceType')];
    }
}

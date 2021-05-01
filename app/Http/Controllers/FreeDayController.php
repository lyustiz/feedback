<?php

namespace App\Http\Controllers;

use App\Models\FreeDay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FreeDayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FreeDay::with([])
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

        $freeDay = freeDay::create($request->all());

        return [ 'msj' => 'FreeDay Agregado Correctamente', compact('freeDay') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FreeDay  $freeDay
     * @return \Illuminate\Http\Response
     */
    public function show(FreeDay $freeDay)
    {
        return $freeDay;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FreeDay  $freeDay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FreeDay $freeDay)
    {
        $validate = request()->validate([
            'day'               => 	'required|string|max:0',
			'user_id'           => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id_ed'        => 	'required|integer|max:999999999',
        ]);

        $freeDay = $freeDay->update($request->all());

        return [ 'msj' => 'FreeDay Editado' , compact('freeDay')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FreeDay  $freeDay
     * @return \Illuminate\Http\Response
     */
    public function destroy(FreeDay $freeDay)
    {
        $freeDay = $freeDay->delete();
 
        return [ 'msj' => 'FreeDay Eliminado' , compact('freeDay')];
    }
}

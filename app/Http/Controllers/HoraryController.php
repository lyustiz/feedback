<?php

namespace App\Http\Controllers;

use App\Models\Horary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HoraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Horary::with([])
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
            'name'              => 	'required|string|max:80',
			'turn_id'           => 	'nullable|integer|max:999999999',
			'hours'             => 	'nullable|integer|max:999999999',
			'value'             => 	'nullable|numeric|max:9',
			'start_at'          => 	'nullable|string|max:0',
			'end_at'            => 	'nullable|string|max:0',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $horary = horary::create($request->all());

        return [ 'msj' => 'Horary Agregado Correctamente', compact('horary') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Horary  $horary
     * @return \Illuminate\Http\Response
     */
    public function show(Horary $horary)
    {
        return $horary;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Horary  $horary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Horary $horary)
    {
        $validate = request()->validate([
            'name'              => 	'required|string|max:80',
			'turn_id'           => 	'nullable|integer|max:999999999',
			'hours'             => 	'nullable|integer|max:999999999',
			'value'             => 	'nullable|numeric|max:9',
			'start_at'          => 	'nullable|string|max:0',
			'end_at'            => 	'nullable|string|max:0',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $horary = $horary->update($request->all());

        return [ 'msj' => 'Horary Editado' , compact('horary')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Horary  $horary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Horary $horary)
    {
        $horary = $horary->delete();
 
        return [ 'msj' => 'Horary Eliminado' , compact('horary')];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Present;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PresentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Present::with([])
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
			'type'              => 	'required|string|max:60',
			'value'             => 	'required|numeric|max:9',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $present = present::create($request->all());

        return [ 'msj' => 'Present Agregado Correctamente', compact('present') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Present  $present
     * @return \Illuminate\Http\Response
     */
    public function show(Present $present)
    {
        return $present;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Present  $present
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Present $present)
    {
        $validate = request()->validate([
            'name'              => 	'required|string|max:80',
			'type'              => 	'required|string|max:60',
			'value'             => 	'required|numeric|max:9',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $present = $present->update($request->all());

        return [ 'msj' => 'Present Editado' , compact('present')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Present  $present
     * @return \Illuminate\Http\Response
     */
    public function destroy(Present $present)
    {
        $present = $present->delete();
 
        return [ 'msj' => 'Present Eliminado' , compact('present')];
    }
}

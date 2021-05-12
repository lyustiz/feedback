<?php

namespace App\Http\Controllers;

use App\Models\Curator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CuratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Curator::with([])
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
			'amolatina_id'      => 	'required|integer|max:999999999',
			'value'             => 	'required|numeric|max:9',
			'percent'           => 	'required|numeric|max:3',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $curator = curator::create($request->all());

        return [ 'msj' => 'Curator Agregado Correctamente', compact('curator') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Curator  $curator
     * @return \Illuminate\Http\Response
     */
    public function show(Curator $curator)
    {
        return $curator;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Curator  $curator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Curator $curator)
    {
        $validate = request()->validate([
            'name'              => 	'required|string|max:80',
			'amolatina_id'      => 	'required|integer|max:999999999',
			'value'             => 	'required|numeric|max:9',
			'percent'           => 	'required|numeric|max:3',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $curator = $curator->update($request->all());

        return [ 'msj' => 'Curator Editado' , compact('curator')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Curator  $curator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curator $curator)
    {
        $curator = $curator->delete();
 
        return [ 'msj' => 'Curator Eliminado' , compact('curator')];
    }
}

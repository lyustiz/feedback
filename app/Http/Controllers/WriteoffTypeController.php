<?php

namespace App\Http\Controllers;

use App\Models\WriteoffType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WriteoffTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return WriteoffType::with([])
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
			'traslate'          => 	'required|string|max:60',
			'ammount'           => 	'required|numeric|max:9',
			'icon'              => 	'nullable|string|max:50',
			'color'             => 	'nullable|string|max:50',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $writeoffType = writeoffType::create($request->all());

        return [ 'msj' => 'WriteoffType Agregado Correctamente', compact('writeoffType') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WriteoffType  $writeoffType
     * @return \Illuminate\Http\Response
     */
    public function show(WriteoffType $writeoffType)
    {
        return $writeoffType;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WriteoffType  $writeoffType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WriteoffType $writeoffType)
    {
        $validate = request()->validate([
            'name'              => 	'required|string|max:60',
			'traslate'          => 	'required|string|max:60',
			'ammount'           => 	'required|numeric|max:9',
			'icon'              => 	'nullable|string|max:50',
			'color'             => 	'nullable|string|max:50',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $writeoffType = $writeoffType->update($request->all());

        return [ 'msj' => 'WriteoffType Editado' , compact('writeoffType')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WriteoffType  $writeoffType
     * @return \Illuminate\Http\Response
     */
    public function destroy(WriteoffType $writeoffType)
    {
        $writeoffType = $writeoffType->delete();
 
        return [ 'msj' => 'WriteoffType Eliminado' , compact('writeoffType')];
    }
}

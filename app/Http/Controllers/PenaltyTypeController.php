<?php

namespace App\Http\Controllers;

use App\Models\PenaltyType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PenaltyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PenaltyType::with([])
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

        $penaltyType = penaltyType::create($request->all());

        return [ 'msj' => 'PenaltyType Agregado Correctamente', compact('penaltyType') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PenaltyType  $penaltyType
     * @return \Illuminate\Http\Response
     */
    public function show(PenaltyType $penaltyType)
    {
        return $penaltyType;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PenaltyType  $penaltyType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PenaltyType $penaltyType)
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

        $penaltyType = $penaltyType->update($request->all());

        return [ 'msj' => 'PenaltyType Editado' , compact('penaltyType')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PenaltyType  $penaltyType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PenaltyType $penaltyType)
    {
        $penaltyType = $penaltyType->delete();
 
        return [ 'msj' => 'PenaltyType Eliminado' , compact('penaltyType')];
    }
}

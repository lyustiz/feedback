<?php

namespace App\Http\Controllers;

use App\Models\BonusType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BonusTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BonusType::with([])
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

        $bonusType = bonusType::create($request->all());

        return [ 'msj' => 'BonusType Agregado Correctamente', compact('bonusType') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BonusType  $bonusType
     * @return \Illuminate\Http\Response
     */
    public function show(BonusType $bonusType)
    {
        return $bonusType;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BonusType  $bonusType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BonusType $bonusType)
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

        $bonusType = $bonusType->update($request->all());

        return [ 'msj' => 'BonusType Editado' , compact('bonusType')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BonusType  $bonusType
     * @return \Illuminate\Http\Response
     */
    public function destroy(BonusType $bonusType)
    {
        $bonusType = $bonusType->delete();
 
        return [ 'msj' => 'BonusType Eliminado' , compact('bonusType')];
    }
}

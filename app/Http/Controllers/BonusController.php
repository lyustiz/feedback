<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BonusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Bonus::with([])
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
            'bonus_id'          => 	'required|integer|max:999999999',
			'service'           => 	'nullable|string|max:100',
			'fact'              => 	'nullable|string|max:200',
			'cllient_id'        => 	'required|integer|max:999999999',
			'profile_id'        => 	'required|integer|max:999999999',
			'points'            => 	'required|numeric|max:9',
			'profit'            => 	'required|numeric|max:9',
			'share'             => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $bonus = bonus::create($request->all());

        return [ 'msj' => 'Bonus Agregado Correctamente', compact('bonus') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bonus  $bonus
     * @return \Illuminate\Http\Response
     */
    public function show(Bonus $bonus)
    {
        return $bonus;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bonus  $bonus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bonus $bonus)
    {
        $validate = request()->validate([
            'bonus_id'          => 	'required|integer|max:999999999',
			'service'           => 	'nullable|string|max:100',
			'fact'              => 	'nullable|string|max:200',
			'cllient_id'        => 	'required|integer|max:999999999',
			'profile_id'        => 	'required|integer|max:999999999',
			'points'            => 	'required|numeric|max:9',
			'profit'            => 	'required|numeric|max:9',
			'share'             => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $bonus = $bonus->update($request->all());

        return [ 'msj' => 'Bonus Editado' , compact('bonus')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bonus  $bonus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bonus $bonus)
    {
        $bonus = $bonus->delete();
 
        return [ 'msj' => 'Bonus Eliminado' , compact('bonus')];
    }
}

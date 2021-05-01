<?php

namespace App\Http\Controllers;

use App\Models\Penalty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PenaltyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Penalty::with([])
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
			'penalty_type_id'   => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id_ed'        => 	'required|integer|max:999999999',
        ]);

        $penalty = penalty::create($request->all());

        return [ 'msj' => 'Penalty Agregado Correctamente', compact('penalty') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penalty  $penalty
     * @return \Illuminate\Http\Response
     */
    public function show(Penalty $penalty)
    {
        return $penalty;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penalty  $penalty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penalty $penalty)
    {
        $validate = request()->validate([
            'day'               => 	'required|string|max:0',
			'penalty_type_id'   => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id_ed'        => 	'required|integer|max:999999999',
        ]);

        $penalty = $penalty->update($request->all());

        return [ 'msj' => 'Penalty Editado' , compact('penalty')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penalty  $penalty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penalty $penalty)
    {
        $penalty = $penalty->delete();
 
        return [ 'msj' => 'Penalty Eliminado' , compact('penalty')];
    }
}

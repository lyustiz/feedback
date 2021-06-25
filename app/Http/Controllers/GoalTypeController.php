<?php

namespace App\Http\Controllers;

use App\Models\GoalType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoalTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GoalType::with([])
                    ->get();
    }

    public function goalTypeUser($userId)
    {
        return GoalType::where('user_id', $userId)->get();
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
			'group'             => 	'nullable|string|max:30',
			'amount'            => 	'required|numeric|max:9',
			'icon'              => 	'nullable|string|max:50',
			'color'             => 	'nullable|string|max:50',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $goalType = goalType::create($request->all());

        return [ 'msj' => 'GoalType Agregado Correctamente', compact('goalType') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GoalType  $goalType
     * @return \Illuminate\Http\Response
     */
    public function show(GoalType $goalType)
    {
        return $goalType;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GoalType  $goalType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GoalType $goalType)
    {
        $validate = request()->validate([
			'amount'            => 	'required|numeric|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $goalType = $goalType->update($validate);

        return [ 'msj' => 'Meta Editada' , compact('goalType')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GoalType  $goalType
     * @return \Illuminate\Http\Response
     */
    public function destroy(GoalType $goalType)
    {
        $goalType = $goalType->delete();
 
        return [ 'msj' => 'GoalType Eliminado' , compact('goalType')];
    }
}

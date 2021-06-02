<?php

namespace App\Http\Controllers;

use App\Models\TableTurn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TableTurnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TableTurn::with([])
                    ->get();
    }

    public function combo($tableId)
    {
        return TableTurn::select('table_turn.id as id', 'turn.name as name')
                    ->join('turn', 'turn.id', '=', 'table_turn.turn_id')
                    ->where('table_turn.table_id', $tableId)
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
            'table_id'          => 	'required|integer|max:999999999',
			'turn_id'           => 	'required|integer|max:999999999',
			'coordinator_id'    => 	'required|integer|max:999999999',
			'value'             => 	'nullable|integer|max:999999999',
			'color'             => 	'nullable|string|max:50',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $tableTurn = tableTurn::create($request->all());

        return [ 'msj' => 'TableTurn Agregado Correctamente', compact('tableTurn') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TableTurn  $tableTurn
     * @return \Illuminate\Http\Response
     */
    public function show(TableTurn $tableTurn)
    {
        return $tableTurn;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TableTurn  $tableTurn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TableTurn $tableTurn)
    {
        $validate = request()->validate([
            'table_id'          => 	'required|integer|max:999999999',
			'turn_id'           => 	'required|integer|max:999999999',
			'coordinator_id'    => 	'required|integer|max:999999999',
			'value'             => 	'nullable|integer|max:999999999',
			'color'             => 	'nullable|string|max:50',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $tableTurn = $tableTurn->update($request->all());

        return [ 'msj' => 'TableTurn Editado' , compact('tableTurn')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TableTurn  $tableTurn
     * @return \Illuminate\Http\Response
     */
    public function destroy(TableTurn $tableTurn)
    {
        $tableTurn = $tableTurn->delete();
 
        return [ 'msj' => 'TableTurn Eliminado' , compact('tableTurn')];
    }
}

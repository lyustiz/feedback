<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Turn;
use App\Models\TableTurn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Table::with([ 'manager', 'turn:turn.id,turn.name', 'coordinator' ])
                    ->get();
    }

    public function list()
    {
        return Table::with([ 'manager', 'turn:turn.id,turn.name', 'coordinator' ])
                    ->active(true)
                    ->get();
    }

    public function listUser($userId)
    {
        $user    = \Auth::user();

        if($user->role_id == 1 ) // administrador
        {
            return Table::with([ 'manager', 'turn:turn.id,turn.name', 'coordinator' ])
                    ->active(true)
                    ->get();
        } else {               // coordinador

            return Table::with([ 'manager', 'turn:turn.id,turn.name', 'coordinator' ])
                    ->active(true)
                    ->whereHas('tableTurn', function (Builder $query) use($user) {
                        $query->where('id', $user->table_turn_id);
                    })
                    ->get();

        }
    }

    public function tablesDetails()
    {
        return Table::with(['manager', 'tableTurn.turn'  , 'tableTurn.coordinator', 'tableTurn.operator.profile' ])
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
            'name'           => 'required|string|max:80',
			'value'          => 'required|numeric|max:9',
            'turn_id'        => 'required|integer|max:999999999',
			'comments'       => 'nullable|string|max:100',
            'manager_id'     => 'nullable|integer|max:999999999',
            'coordinator_id' => 'nullable|integer|max:999999999',
			'status_id'      => 'required|integer|max:999999999',
			'user_id'        => 'required|integer|max:999999999',
        ]);

        $table = table::create($request->all());

        $this->assingTurns($table);

        return [ 'msj' => 'Mesa Agregada Correctamente', compact('table') ];
    }

    
    public function assingTurns($table)
    {
        $turns = Turn::where('status_id', 1)->get();
        $tableTurns = [];
        foreach ($turns as $turn) {
            $tableTurns[] = [ 
                                'table_id'   => $table->id, 
                                'turn_id'    => $turn->id, 
                                'user_id'    => $table->user_id, 
                                'status_id'  => 1, 
                                'created_at' => $table->created_at
            ];
        }
        return TableTurn::insert($tableTurns);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function show(Table $table)
    {
        return $table;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Table $table)
    {
        $validate = request()->validate([
            'name'           => 'required|string|max:80',
			'value'          => 'required|numeric|max:9',
            'turn_id'        => 'required|integer|max:999999999',
			'comments'       => 'nullable|string|max:100',
            'manager_id'     => 'nullable|integer|max:999999999',
            'coordinator_id' => 'nullable|integer|max:999999999',
			'status_id'      => 'required|integer|max:999999999',
			'user_id'        => 'required|integer|max:999999999',
        ]);

        $table = $table->update($request->all());

        return [ 'msj' => 'Mesa Editada' , compact('table')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
        $table = $table->delete();
 
        return [ 'msj' => 'Mesa Eliminada' , compact('table')];
    }
}

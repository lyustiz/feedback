<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Table::with([])
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
            'name'       => 'required|string|max:80',
			'value'      => 'required|numeric|max:9',
            'turn_id'    => 'required|integer|max:999999999',
			'comments'   => 'nullable|string|max:100',
            'manager_id' => 'required|integer|max:999999999',
			'status_id'  => 'required|integer|max:999999999',
			'user_id'    => 'required|integer|max:999999999',
        ]);

        $table = table::create($request->all());

        return [ 'msj' => 'Table Agregado Correctamente', compact('table') ];
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
            'name'              => 	'required|string|max:80',
			'value'             => 	'required|numeric|max:9',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $table = $table->update($request->all());

        return [ 'msj' => 'Table Editado' , compact('table')];
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
 
        return [ 'msj' => 'Table Eliminado' , compact('table')];
    }
}

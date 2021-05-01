<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Config::with([])
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
			'type'              => 	'required|string|max:60',
			'group'             => 	'nullable|string|max:20',
			'value'             => 	'required|string|max:200',
			'start_at'          => 	'nullable|string|max:100',
			'end_at'            => 	'nullable|string|max:100',
			'comments'          => 	'nullable|string|max:100',
			'active'            => 	'required|boolean',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $config = config::create($request->all());

        return [ 'msj' => 'Config Agregado Correctamente', compact('config') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Config  $config
     * @return \Illuminate\Http\Response
     */
    public function show(Config $config)
    {
        return $config;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Config  $config
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Config $config)
    {
        $validate = request()->validate([
            'name'              => 	'required|string|max:60',
			'type'              => 	'required|string|max:60',
			'group'             => 	'nullable|string|max:20',
			'value'             => 	'required|string|max:200',
			'start_at'          => 	'nullable|string|max:100',
			'end_at'            => 	'nullable|string|max:100',
			'comments'          => 	'nullable|string|max:100',
			'active'            => 	'required|boolean',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $config = $config->update($request->all());

        return [ 'msj' => 'Config Editado' , compact('config')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Config  $config
     * @return \Illuminate\Http\Response
     */
    public function destroy(Config $config)
    {
        $config = $config->delete();
 
        return [ 'msj' => 'Config Eliminado' , compact('config')];
    }
}

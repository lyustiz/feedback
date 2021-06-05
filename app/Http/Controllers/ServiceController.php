<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Service::with([])
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
			'value'             => 	'nullable|string|max:60',
			'type'              => 	'nullable|string|max:30',
			'positive'          => 	'nullable|boolean',
			'ammount'           => 	'nullable|numeric|max:9',
			'icon'              => 	'nullable|string|max:50',
			'color'             => 	'nullable|string|max:50',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $service = service::create($request->all());

        return [ 'msj' => 'Service Agregado Correctamente', compact('service') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return $service;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $validate = request()->validate([
            'name'              => 	'required|string|max:60',
			'traslate'          => 	'required|string|max:60',
			'value'             => 	'nullable|string|max:60',
			'type'              => 	'nullable|string|max:30',
			'positive'          => 	'nullable|boolean',
			'ammount'           => 	'nullable|numeric|max:9',
			'icon'              => 	'nullable|string|max:50',
			'color'             => 	'nullable|string|max:50',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $service = $service->update($request->all());

        return [ 'msj' => 'Service Editado' , compact('service')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service = $service->delete();
 
        return [ 'msj' => 'Service Eliminado' , compact('service')];
    }
}

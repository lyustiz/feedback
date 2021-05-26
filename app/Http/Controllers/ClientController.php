<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Client::with([])
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
            'amolatina_id'      => 	'required|string|max:',
			'name'              => 	'nullable|string|max:60',
			'birthday'          => 	'nullable|string|max:0',
			'age'               => 	'nullable|integer|max:999999999',
			'photo'             => 	'nullable|string|max:200',
			'gender'            => 	'nullable|string|max:3',
			'preference'        => 	'nullable|string|max:3',
			'country'           => 	'nullable|string|max:3',
			'city'              => 	'nullable|string|max:100',
			'profit'            => 	'nullable|numeric|max:11',
			'crown'             => 	'nullable|integer|max:999999999',
			'contacted_at'      => 	'nullable|date',
			'last_contact'      => 	'nullable|date',
			'comments'          => 	'nullable|string|max:800',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $client = client::create($request->all());

        return [ 'msj' => 'Client Agregado Correctamente', compact('client') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return $client;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $validate = request()->validate([
            'amolatina_id'      => 	'required|string|max:',
			'name'              => 	'nullable|string|max:60',
			'birthday'          => 	'nullable|string|max:0',
			'age'               => 	'nullable|integer|max:999999999',
			'photo'             => 	'nullable|string|max:200',
			'gender'            => 	'nullable|string|max:3',
			'preference'        => 	'nullable|string|max:3',
			'country'           => 	'nullable|string|max:3',
			'city'              => 	'nullable|string|max:100',
			'profit'            => 	'nullable|numeric|max:11',
			'crown'             => 	'nullable|integer|max:999999999',
			'contacted_at'      => 	'nullable|date',
			'last_contact'      => 	'nullable|date',
			'comments'          => 	'nullable|string|max:800',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $client = $client->update($request->all());

        return [ 'msj' => 'Client Editado' , compact('client')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client = $client->delete();
 
        return [ 'msj' => 'Client Eliminado' , compact('client')];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SedeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Sede::with(['foto'])
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
            'nb_sede'           => 	'required|string|max:40',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'        => 	'required|integer|max:999999999',
        ]);

        $sede = sede::create($request->all());

        return [ 'msj' => 'Sede Agregado Correctamente', compact('sede') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sede  $sede
     * @return \Illuminate\Http\Response
     */
    public function show(Sede $sede)
    {
        return $sede;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sede  $sede
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sede $sede)
    {
        $validate = request()->validate([
            'nb_sede'           => 	'required|string|max:40',
			'tx_ubicacion'      => 	'required|string|max:50',
			'tx_mapa'           => 	'nullable|string|max:400',
			'tx_transmision'    => 	'nullable|string|max:400',
			'tx_foto'           => 	'nullable|string|max:50',
			'tx_telefono'       => 	'required|string|max:30',
			'tx_whatsapp'       => 	'nullable|string|max:50',
			'tx_observaciones'  => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'        => 	'required|integer|max:999999999',
        ]);

        $sede = $sede->update($request->all());

        return [ 'msj' => 'Sede Editada' , compact('sede')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sede  $sede
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sede $sede)
    {
        $sede = $sede->delete();
 
        return [ 'msj' => 'Sede Eliminada' , compact('sede')];
    }
}

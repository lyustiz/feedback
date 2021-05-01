<?php

namespace App\Http\Controllers;

use App\Models\Suscripcion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuscripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$with =  ($request->boolean('combo') ) ? '' : '' 
        
        return Suscripcion::with(['suscriptor:id,nb_suscriptor,tx_documento,tx_telefono',
                                  'vendedor:id,nb_vendedor,tx_documento,tx_telefono',
                                  'tipoSuscripcion:id,nb_tipo_suscripcion,nu_dias,nu_monto,tx_icono,tx_color'])
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
            'id_suscriptor'     => 	'required|integer|max:999999999',
			'id_vendedor'       => 	'required|integer|max:999999999',
			'id_tipo_suscripcion'=> 'required|integer|max:999999999',
			'fe_suscripcion'    => 	'required|date|before:fe_vencimiento',
			'nu_dias'           => 	'required|integer|max:999999999',
			'nu_monto'          => 	'required|numeric|max:999999999',
			'fe_vencimiento'    => 	'required|date|after:fe_suscripcion',
			'tx_observaciones'  => 	'nullable|string|max:100',
			'id_status'         => 	'required|integer|max:999999999',
			'id_usuario'        => 	'required|integer|max:999999999',
        ]);

        $suscripcion = suscripcion::create($request->all());

        return [ 'msj' => 'Suscripcion Agregada Correctamente', compact('suscripcion') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Suscripcion  $suscripcion
     * @return \Illuminate\Http\Response
     */
    public function show(Suscripcion $suscripcion)
    {
        return $suscripcion;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Suscripcion  $suscripcion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Suscripcion $suscripcion)
    {
        $validate = request()->validate([
            'id_suscriptor'     => 	'required|integer|max:999999999',
			'id_vendedor'       => 	'required|integer|max:999999999',
			'id_tipo_suscripcion'=> 'required|integer|max:999999999',
			'fe_suscripcion'    => 	'required|date|before:fe_vencimiento',
			'nu_dias'           => 	'required|integer|max:999999999',
			'nu_monto'          => 	'required|numeric|max:999999999',
			'fe_vencimiento'    => 	'required|date|after:fe_suscripcion',
			'tx_observaciones'  => 	'nullable|string|max:100',
			'id_status'         => 	'required|integer|max:999999999',
			'id_usuario'        => 	'required|integer|max:999999999',
        ]);

        $suscripcion = $suscripcion->update($request->all());

        return [ 'msj' => 'Suscripcion Editada' , compact('suscripcion')];
    }

    public function updateObservaciones(Request $request, Suscripcion $suscripcion)
    {
        $validate = request()->validate([
			'tx_observaciones'  => 	'nullable|string|max:100',
			'id_usuario'        => 	'required|integer|max:999999999',
        ]);

        $suscripcion = $suscripcion->update($request->all());

        return [ 'msj' => 'Observacion Actualizada' , compact('suscripcion')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Suscripcion  $suscripcion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Suscripcion $suscripcion)
    {
        $suscripcion = $suscripcion->delete();
 
        return [ 'msj' => 'Suscripcion Eliminada' , compact('suscripcion')];
    }
}

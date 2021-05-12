<?php

namespace App\Http\Controllers;

use App\Models\TipoSuscripcion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class TipoSuscripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return TipoSuscripcion::activo( $request->boolean('activo') )
                    ->comboData( $request->boolean('combo') )
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
            'nb_tipo_suscripcion'=> 	'required|string|max:30',
			'nu_dias'           => 	'required|string|max:255',
			'nu_monto'          => 	'required|numeric|max:999999999',
			'tx_icono'          => 	'nullable|string|max:30',
			'tx_color'          => 	'nullable|string|max:30',
			'tx_observaciones'  => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'        => 	'required|integer|max:999999999',
        ]);

        $tipoSuscripcion = tipoSuscripcion::create($request->all());

        return [ 'msj' => 'TipoSuscripcion Agregado Correctamente', compact('tipoSuscripcion') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoSuscripcion  $tipoSuscripcion
     * @return \Illuminate\Http\Response
     */
    public function show(TipoSuscripcion $tipoSuscripcion)
    {
        return $tipoSuscripcion;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipoSuscripcion  $tipoSuscripcion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoSuscripcion $tipoSuscripcion)
    {
        $validate = request()->validate([
            'nb_tipo_suscripcion'=> 	'required|string|max:30',
			'nu_dias'           => 	'required|string|max:255',
			'nu_monto'          => 	'required|numeric|max:999999999',
			'tx_icono'          => 	'nullable|string|max:30',
			'tx_color'          => 	'nullable|string|max:30',
			'tx_observaciones'  => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'        => 	'required|integer|max:999999999',
        ]);

        $tipoSuscripcion = $tipoSuscripcion->update($request->all());

        return [ 'msj' => 'TipoSuscripcion Editado' , compact('tipoSuscripcion')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoSuscripcion  $tipoSuscripcion
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoSuscripcion $tipoSuscripcion)
    {
        if( count($tipoSuscripcion->suscripcion) > 0 )
        {
            throw ValidationException::withMessages(['poseeSuscripcion' => "Posee Suscripciones Asociadas"]);
        }
        
        $tipoSuscripcion = $tipoSuscripcion->delete();
 
        return [ 'msj' => 'TipoSuscripcion Eliminado' , compact('tipoSuscripcion')];
    }
}

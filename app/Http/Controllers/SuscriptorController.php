<?php

namespace App\Http\Controllers;

use App\Models\Suscriptor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class SuscriptorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Suscriptor::activo( $request->boolean('activo') )
                        ->comboData( $request->boolean('combo') )
                        ->orderBy('nb_suscriptor', 'asc')
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
            'nb_suscriptor'    => 	'required|string|max:80',
			'tx_documento'      => 	'required|integer|max:999999999',
			'tx_telefono'       => 	'required|string|max:100',
			'tx_telefono2'      => 	'nullable|string|max:255',
			'tx_direccion'      => 	'nullable|string|max:150',
			'tx_observaciones'  => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'        => 	'required|integer|max:999999999',
        ]);
        $request->nb_subscriptor = ucwords( strtolower($request->nb_subscriptor));
        $suscriptor = suscriptor::create($request->all());

        return [ 'msj' => 'Suscriptor Agregado Correctamente', 'suscriptor' =>  $suscriptor];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Suscriptor  $suscriptor
     * @return \Illuminate\Http\Response
     */
    public function show(Suscriptor $suscriptor)
    {
        return $suscriptor;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Suscriptor  $suscriptor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Suscriptor $suscriptor)
    {
        $validate = request()->validate([
            'nb_suscriptor'    => 	'required|string|max:80',
			'tx_documento'      => 	'required|integer|max:999999999',
			'tx_telefono'       => 	'required|string|max:100',
			'tx_telefono2'      => 	'nullable|string|max:255',
			'tx_direccion'      => 	'nullable|string|max:150',
			'tx_observaciones'  => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'        => 	'required|integer|max:999999999',
        ]);

        $request->merge(['nb_suscriptor' => ucwords($request->nb_suscriptor) ]);

        $suscriptor = $suscriptor->update($request->all());

        return [ 'msj' => 'Suscriptor Editado' , compact('suscriptor')];
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Suscriptor  $suscriptor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Suscriptor $suscriptor)
    {
        if( count($suscriptor->suscripcion) > 0 )
        {
            throw ValidationException::withMessages(['poseeSuscripcion' => "Posee Suscripciones Asociadas"]);
        }
        
        $suscriptor = $suscriptor->delete();
 
        return [ 'msj' => 'Suscriptor Eliminado' , compact('suscriptor')];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Vendedor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class VendedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Vendedor::activo( $request->boolean('activo') )
                        ->comboData( $request->boolean('combo') )
                        ->orderBy('nb_vendedor', 'asc')
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
            'nb_vendedor'       => 	'required|string|max:80',
			'tx_documento'      => 	'required|integer|max:999999999',
			'tx_telefono'       => 	'required|string|max:100',
			'tx_telefono2'      => 	'nullable|string|max:255',
			'tx_direccion'      => 	'nullable|string|max:150',
			'tx_observaciones'  => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'        => 	'required|integer|max:999999999',
        ]);

        $request->merge(['nb_vendedor' => ucwords($request->nb_vendedor) ]);

        $vendedor = vendedor::create($request->all());

        return [ 'msj' => 'Vendedor Agregado Correctamente', compact('vendedor') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendedor  $vendedor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendedor $vendedor)
    {
        return $vendedor;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendedor  $vendedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendedor $vendedor)
    {
        $validate = request()->validate([
            'nb_vendedor'       => 	'required|string|max:80',
			'tx_documento'      => 	'required|integer|max:999999999',
			'tx_telefono'       => 	'required|string|max:100',
			'tx_telefono2'      => 	'nullable|string|max:255',
			'tx_direccion'      => 	'nullable|string|max:150',
			'tx_observaciones'  => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'        => 	'required|integer|max:999999999',
        ]);

        $request->merge(['nb_vendedor' => ucwords($request->nb_vendedor) ]);

        $vendedor = $vendedor->update($request->all());

        return [ 'msj' => 'Vendedor Editado' , compact('vendedor')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendedor  $vendedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendedor $vendedor)
    {
        if( count($vendedor->suscripcion) > 0 )
        {
            throw ValidationException::withMessages(['poseeSuscripcion' => "Posee Suscripciones Asociadas"]);
        }
        
        $vendedor = $vendedor->delete();
 
        return [ 'msj' => 'Vendedor Eliminado' , compact('vendedor')];
    }
}

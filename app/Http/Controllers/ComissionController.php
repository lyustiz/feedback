<?php

namespace App\Http\Controllers;

use App\Models\Comission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ComissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Comission::with(['profile:id,amolatina_id,name,photo,gender'])
        ->orderBy('comission_at', 'desc')
        ->paginate(21)->withPath('comission');  
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
            'comission_id'      => 	'required|integer|max:999999999',
			'fact'              => 	'nullable|string|max:200',
			'service'           => 	'nullable|string|max:100',
			'points'            => 	'nullable|numeric|max:9',
			'profit'            => 	'nullable|numeric|max:9',
			'share'             => 	'nullable|integer|max:999999999',
			'agency_id'         => 	'required|string|max:',
			'curator_id'        => 	'required|string|max:',
			'profile_id'        => 	'required|string|max:',
			'user_id'           => 	'nullable|integer|max:999999999',
			'cllient_id'        => 	'required|string|max:',
			'comments'          => 	'nullable|string|max:100',
			'user_id_ed'        => 	'required|integer|max:999999999',
        ]);

        $comission = comission::create($request->all());

        return [ 'msj' => 'Comission Agregado Correctamente', compact('comission') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comission  $comission
     * @return \Illuminate\Http\Response
     */
    public function show(Comission $comission)
    {
        return $comission;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comission  $comission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comission $comission)
    {
        $validate = request()->validate([
            'comission_id'      => 	'required|integer|max:999999999',
			'fact'              => 	'nullable|string|max:200',
			'service'           => 	'nullable|string|max:100',
			'points'            => 	'nullable|numeric|max:9',
			'profit'            => 	'nullable|numeric|max:9',
			'share'             => 	'nullable|integer|max:999999999',
			'agency_id'         => 	'required|string|max:',
			'curator_id'        => 	'required|string|max:',
			'profile_id'        => 	'required|string|max:',
			'user_id'           => 	'nullable|integer|max:999999999',
			'cllient_id'        => 	'required|string|max:',
			'comments'          => 	'nullable|string|max:100',
			'user_id_ed'        => 	'required|integer|max:999999999',
        ]);

        $comission = $comission->update($request->all());

        return [ 'msj' => 'Comission Editado' , compact('comission')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comission  $comission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comission $comission)
    {
        $comission = $comission->delete();
 
        return [ 'msj' => 'Comission Eliminado' , compact('comission')];
    }
}

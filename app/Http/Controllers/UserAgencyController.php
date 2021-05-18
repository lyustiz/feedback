<?php

namespace App\Http\Controllers;

use App\Models\UserAgency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserAgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserAgency::with([])
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
            'user_id'           => 	'required|integer|max:999999999',
			'agency_id'         => 	'nullable|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id_ed'        => 	'required|integer|max:999999999',
        ]);

        $userAgency = userAgency::create($request->all());

        return [ 'msj' => 'UserAgency Agregado Correctamente', compact('userAgency') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserAgency  $userAgency
     * @return \Illuminate\Http\Response
     */
    public function show(UserAgency $userAgency)
    {
        return $userAgency;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserAgency  $userAgency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAgency $userAgency)
    {
        $validate = request()->validate([
            'user_id'           => 	'required|integer|max:999999999',
			'agency_id'         => 	'nullable|integer|max:999999999',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id_ed'        => 	'required|integer|max:999999999',
        ]);

        $userAgency = $userAgency->update($request->all());

        return [ 'msj' => 'UserAgency Editado' , compact('userAgency')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserAgency  $userAgency
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAgency $userAgency)
    {
        $userAgency = $userAgency->delete();
 
        return [ 'msj' => 'UserAgency Eliminado' , compact('userAgency')];
    }
}

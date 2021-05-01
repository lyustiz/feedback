<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with([])
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
            'username'          => 	'nullable|string|max:50',
			'password'          => 	'nullable|string|max:64',
			'name'              => 	'nullable|string|max:50',
			'surname'           => 	'nullable|string|max:50',
			'role_id'           => 	'required|integer|max:999999999',
			'agency_id'         => 	'required|integer|max:999999999',
			'group_id'          => 	'required|integer|max:999999999',
			'photo'             => 	'nullable|string|max:200',
			'email'             => 	'nullable|string|max:100',
			'verification'      => 	'nullable|string|max:64',
			'email_verified_at' => 	'required|date',
			'remember_token'    => 	'nullable|string|max:64',
			'api_token'         => 	'nullable|string|max:64',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $user = user::create($request->all());

        return [ 'msj' => 'User Agregado Correctamente', compact('user') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validate = request()->validate([
            'username'          => 	'nullable|string|max:50',
			'password'          => 	'nullable|string|max:64',
			'name'              => 	'nullable|string|max:50',
			'surname'           => 	'nullable|string|max:50',
			'role_id'           => 	'required|integer|max:999999999',
			'agency_id'         => 	'required|integer|max:999999999',
			'group_id'          => 	'required|integer|max:999999999',
			'photo'             => 	'nullable|string|max:200',
			'email'             => 	'nullable|string|max:100',
			'verification'      => 	'nullable|string|max:64',
			'email_verified_at' => 	'required|date',
			'remember_token'    => 	'nullable|string|max:64',
			'api_token'         => 	'nullable|string|max:64',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $user = $user->update($request->all());

        return [ 'msj' => 'User Editado' , compact('user')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user = $user->delete();
 
        return [ 'msj' => 'User Eliminado' , compact('user')];
    }
}

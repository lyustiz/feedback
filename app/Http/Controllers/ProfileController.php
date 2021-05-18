<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Profile::with([])
                    ->get();
    }

    public function profileUser($userId)
    {
        return Profile::with(['presence:id,start_at,user_id,profile_id', 'presence.user:id,name,surname', 'agency:agency.id,amolatina_id'])
                        ->whereHas('user', function (Builder $query) use($userId) {
                            $query->where('user.id', $userId);
                        })->get();
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
			'name'              => 	'required|string|max:60',
			'birthday'          => 	'required|string|max:0',
			'age'               => 	'required|integer|max:999999999',
			'photo'             => 	'required|string|max:200',
			'gender'            => 	'required|string|max:3',
			'preference'        => 	'required|string|max:3',
			'country'           => 	'required|string|max:3',
			'city'              => 	'required|string|max:100',
			'minage'            => 	'required|integer|max:999999999',
			'maxage'            => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:800',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $profile = profile::create($request->all());

        return [ 'msj' => 'Profile Agregado Correctamente', compact('profile') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        return $profile;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        $validate = request()->validate([
            'amolatina_id'      => 	'required|string|max:',
			'name'              => 	'required|string|max:60',
			'birthday'          => 	'required|string|max:0',
			'age'               => 	'required|integer|max:999999999',
			'photo'             => 	'required|string|max:200',
			'gender'            => 	'required|string|max:3',
			'preference'        => 	'required|string|max:3',
			'country'           => 	'required|string|max:3',
			'city'              => 	'required|string|max:100',
			'minage'            => 	'required|integer|max:999999999',
			'maxage'            => 	'required|integer|max:999999999',
			'comments'          => 	'nullable|string|max:800',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $profile = $profile->update($request->all());

        return [ 'msj' => 'Profile Editado' , compact('profile')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        $profile = $profile->delete();
 
        return [ 'msj' => 'Profile Eliminado' , compact('profile')];
    }
}

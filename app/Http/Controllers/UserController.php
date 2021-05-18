<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\UserTrait;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    use UserTrait;
   
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

    public function show(Request $request, User $user)
    {
       return $user->load( 'group', 'table.manager', 'table.coordinator', 'profile', 'role')
                   ->loadSum(['presenceDay', 'presenceMonth' ], 'profit')
                   ->loadSum(['presenceDay', 'presenceMonth' ], 'writeoff');
    }

    public function list(Request $request)
    {
        //$with = $this->userWiths($request);
        return User::with('group', 'table.manager', 'table.coordinator', 'profile', 'role', 'penaltyMonth.penaltyType')
                    ->withSum(['presenceDay', 'presenceMonth' ], 'profit')
                    ->withSum(['presenceDay', 'presenceMonth' ], 'writeoff')
                    ->operator($request->boolean('operator'))
                    ->get(); 
    }

    public function userWiths($request)
    {
        $withs = [];

        if ($request->filled('with')) {
            if(is_array($request->with))
            {
                foreach ($request->with as $input) {
                    $withs[] = $input;
                }
            } else {
                $withs[] = $request->with;
            }
        }
        return $withs;
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
			'password'          => 	'required|string',
			'name'              => 	'nullable|string|max:50',
			'surname'           => 	'nullable|string|max:50',
			'role_id'           => 	'required|integer|max:999999999',
            'rolename'          => 	'required|string|max:30',
			'agency_id'         => 	'required|integer|max:999999999',
			'group_id'          => 	'required|integer|max:999999999',
			'photo'             => 	'nullable|string',
			'email'             => 	'nullable|string|max:100',
			'comments'          => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $username  = UserTrait::makeUsername($request);

        $password  = Hash::make($request->password);

        $photoname =  $username . '.jpeg';

        if($this->storeImage($request->photo, $photoname, $request->rolename))
        {
            $request-> merge (['username' => $username, 'password' => $password, 'photo' => $photoname ]);
            $user = User::create($request->all());

        } else {

            throw ValidationException::withMessages(['photoError' => "No se cargo la imagen"]);
        }

        return [ 'msj' => "$request->rolename Agregado Correctamente", compact('user') ];
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
			'password'          => 	'nullable|string',
			'name'              => 	'nullable|string|max:50',
			'surname'           => 	'nullable|string|max:50',
			'role_id'           => 	'required|integer|max:999999999',
            'rolename'          => 	'required|string|max:30',
			'group_id'          => 	'required|integer|max:999999999',
			'photo'             => 	'nullable|string',
			'email'             => 	'nullable|string|max:100',
			'comments'          => 	'nullable|string|max:100',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        if ($request->filled('password')) {
            $password  = Hash::make($request->password);
            $request->merge(['password' => $password]);
        }

        if ($request->filled('photo')) {
            
            if(strpos($request->photo, 'base64,'))
            {
                $photoname =  $user->username . '.jpeg';
                
                if($this->storeImage($request->photo, $photoname, $request->rolename))
                {
                    $request-> merge(['photo' => $photoname]);
                    
                } else {

                    throw ValidationException::withMessages(['photoError' => "No se crago la imagen"]);
                }
            }
        }

        $user = $user->update($request->all());

        return [ 'msj' => "$request->rolename Actualizado Correctamente", compact('user') ];
    }

    public function goals(Request $request, User $user)
    {
        $validate = request()->validate([
			'goal_day'   => 'required|integer|max:999999999',
            'goal_month' => 'required|integer|max:999999999',
			'user_id'    => 'required|integer|max:999999999',
        ]);

        $user = $user->update($request->all());

        return [ 'msj' => "Metas Actualizadas Correctamente", compact('user') ];
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
 
        return [ 'msj' => 'Usuario Eliminado' , compact('user')];
    }

    public function storeImage($imgSource, $imgName, $type)
	{
        $imgSource = substr($imgSource, strpos($imgSource, 'base64,') + 7);
    
        $imgSource = base64_decode($imgSource);

        return Storage::disk( 'photo_'. $type )->put(  $imgName, $imgSource );
    }

  

}

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


/* Route::post('/login',            'Auth\LoginController@login')->name('login');; */

Route::post('/login', function(Request $request ){
    $request->validate([
        'email'    => 'required',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        
        
        $user    = Auth::user();

        if($user->status_id == 1) 
        {
            // $request->session()->regenerate();

            $user->load(['agency:id,name,amolatina_id,token' ]);
            $role  = $user->role; 
            $menu  = $role->menu; 

            return response()->json([ 
                'user' => $user,
                'role' => $role,
                'menu' => $menu
            ], 200 );

           /*  return ;  */
        }

        throw ValidationException::withMessages(['userInactive' => "Usuario Inactivo consulte con el Administrador"]);
    }

    return response('Usuario o Contraseña Invalida', 403) ;
});




Route::post('/logout',            'Auth\LoginController@logout');
/* Route::view('/', 'app'); */

/*     Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');
 */    Route::get('{path}', [App\Http\Controllers\HomeController::class, 'welcome'])->where('path', '(.*)');




//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



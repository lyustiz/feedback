<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;


    public function username()
    {
        return 'username';
    }

    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            
            $user    = Auth::user();

            if($user->status_id == 1) 
            {
                $request->session()->regenerate();

                $user->load(['agency:id,name,amolatina_id,token' ]);
                $role  = $user->role; 
                $menu  = $role->menu; 

                return [ 
                    'user' => $user,
                    'role' => $role,
                    'menu' => $menu
                ]; 
            }

            throw ValidationException::withMessages(['userInactive' => "Usuario Inactivo consulte con el Administrador"]);
        }

        return response('Usuario o Contraseña Invalida', 403) ;

    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
    }


}

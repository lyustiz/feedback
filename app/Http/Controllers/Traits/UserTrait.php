<?php

namespace App\Http\Controllers\Traits;
use App\Models\User;
use App\Models\TipoUsuario;
use App\Models\UsuarioPerfil;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

trait UserTrait
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    static public function store(array $data)
    {
        $password     =  '12345678';
        
        $verification = Str::random(8);
        
        $usuario = User::create([
            'nb_usuario'        => $data['nb_usuario'],
            'nb_nombres'        => $data['nb_nombres'],
            'id_colegio'        => $data['id_colegio'],
            'tx_email'          => $data['tx_email'],
            'password'          => Hash::make($password),
            'id_tipo_usuario'   => $data['id_tipo_usuario'],
            'id_origen'         => $data['id_origen'],
            'status_id'         => 1,
            'user_id'        => $data['user_id'],
            'verification'      => $verification
        ]);

        return $usuario;
    }

    static public function usuarioOrigenTipo($data, $idTipoUsuario)  
    {
        if($idTipoUsuario == 1) 
        {
            throw ValidationException::withMessages(['createAdministrador' => "No es posible crear usuario Administrador"]);
        }
                
        $tipoUsuario = User::find($idTipoUsuario);

        $idPerfil    = $tipoUsuario->id_perfil;

        $idColegio   = User::find($data->user_id)->id_colegio; 

        $nbUsuario   = UsuarioTrait::makeNbUsuario($data);

        $dataUsuario = [
            'nb_usuario'      => $nbUsuario,
            'nb_nombres'      => strtolower($data->nb_nombre) . ' ' . strtolower($data->nb_apellido),
            'id_colegio'      => $idColegio,
            'tx_email'        => $data->tx_email,
            'id_tipo_usuario' => $idTipoUsuario,
            'id_origen'       => $data->id,
            'user_id'      => $data->user_id
        ];

        $usuario = UsuarioTrait::store($dataUsuario);

        $perfil  = UsuarioPerfil::create([
                    'user_id'     => $usuario->id,
                    'id_perfil'      => $idPerfil,
                    'status_id'      => 1,
                    'user_id_ed'  => $data->user_id
                    ]);       

        return [ 'msj' => "Usuarios Creados", 'usuario' => $usuario];
    }

    static public function makeUsername($data)
    {
        $username  = null;

        $surname = strtolower($data->surname);

        $usernames = User::select('username')
                              ->where('username', 'like',"%$surname%")
                              ->get()
                              ->pluck('username')
                              ->toArray(); // ['lyustiz','ldyustiz','lyustiza','ldyustiza1' ...]
        
                              
        for ($attempt = 1; $attempt <= 20 ; $attempt++) 
        { 
           $username =  self::ruleUsername($data, $attempt);

           if(!in_array($username, $usernames))
           {
                break;
           }
        }

        return $username;
    
    }

    static public function ruleUsername($data, int $attempt)
    {
        switch ($attempt) {
            case 1: //lyustiz
                return   substr(strtolower($data->name), 0, 1) 
                       . strtolower($data->surname);
                break;
            
            default: //lyustiz1 - 20
                return  substr(strtolower($data->name), 0, 1) 
                        . strtolower($data->surname)
                        . ($attempt-1);
                break;
        }
    }

    static public function sendEmailLogin(Usuario $usuario )
    {
        //Enviar codigo de confirmacion
        \Mail::send('auth.mail.mail_created', $data, function($message) use ($data) {
            $message->to($usuario->tx_email, $usuario->nb_usario)->subject('"VirtuaLin.com", Usuario y contraseña de Ingreso');
        }); 
    }

    


}

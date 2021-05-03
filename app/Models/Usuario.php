<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable implements MustVerifyEmail
{
	use HasApiTokens, HasFactory, Notifiable;
	
	protected $table 	  = 'usuario';

    protected $fillable   = [
							'id',
							'id_colegio',
	 	 	 	 	 	 	'nb_nombres',
	 	 	 	 	 	 	'nb_usuario',
	 	 	 	 	 	 	'password',
	 	 	 	 	 	 	'tx_email',
	 	 	 	 	 	 	'tx_foto',
							'id_tipo_usuario',
							'id_origen',
	 	 	 	 	 	 	'tx_observaciones',
	 	 	 	 	 	 	'verification',
	 	 	 	 	 	 	'email_verified_at',
	 	 	 	 	 	 	'remember_token',
	 	 	 	 	 	 	'api_token',
	 	 	 	 	 	 	'status_id',
	 	 	 	 	 	 	'user_id',
	 	 	 	 	 	 	'created_at',
	 	 	 	 	 	 	'updated_at'
							]; 
							
	protected $hidden   = [ 
		'password', 
		'verification',
		'email_verified_at', 
		'remember_token', 
		'user_id', 
		'api_token', 
		'created_at', 
		'updated_at'];
           
	protected $casts = [
        'email_verified_at' => 'datetime',
	];
	
	public function scopeActivo($query)
    {
        return $query->where('status_id', 1);
	}

	public function scopeComboData($query)
    {
        return $query->addSelect('id', 'nb_usuario', 'nb_nombres', 'id_tipo_usuario', 'id_origen');
    }

	public function status()
	{
        return $this->belongsTo('App\Models\Status', 'status_id');
    }
                           
	public function user()
	{
        return $this->belongsTo('App\Models\User', 'user_id');
	}

	public function colegio()
	{
        return $this->belongsTo('App\Models\Colegio', 'id_colegio');
	}
	
	public function perfil()
	{
        return $this->belongsToMany('App\Models\Perfil', 'usuario_perfil', 'user_id', 'id_perfil');
	}
	
	public function foto()
    {
        return $this->hasOne('App\Models\Foto',  'id_origen', 'id')->where('id_tipo_foto', 4);
	}

	public function alumno()
    {
        return $this->belongsTo('App\Models\Alumno',  'id_origen');
	}

	public function docente()
    {
        return $this->belongsTo('App\Models\Docente',  'id_origen');
	}

	public function pariente()
    {
        return $this->belongsTo('App\Models\Pariente',  'id_origen');
	}

	public function empleado()
    {
        return $this->belongsTo('App\Models\Empleado',  'id_origen');
	}

	public function tipouser()
    {
        return $this->belongsTo('App\Models\TipoUsuario',  'id_tipo_usuario');
	}

	public function notificacion()
    {
        return $this->HasMany('App\Models\Notificacion',  'user_id', 'id_destinatario');
	}



	
}
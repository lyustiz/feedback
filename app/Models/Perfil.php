<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table 	  = 'perfil';

    protected $fillable   = [
                            'nb_perfil',
                            'tx_icono',
	 	 	 	 	 	 	'tx_observaciones',
	 	 	 	 	 	 	'status_id',
	 	 	 	 	 	 	'user_id'
                            ]; 
    
    protected $hidden     = [
                            'created_at',
	 	 	 	 	 	 	'updated_at'
                            ];

    public function scopeActivo($query)
    {
        return $query->where('status_id', 1);
	}

	public function scopeComboData($query)
    {
        return $query->addSelect('id', 'nb_perfil');
    }
    
    public function status()
    {
        return $this->BelongsTo('App\Models\Status', 'status_id')->where('co_grupo', 'GRAL');
    }
                           
    public function user()
    {
        return $this->BelongsTo('App\Models\User', 'user_id');
    }

    public function permiso()
    {
        return $this->hasMany('App\Models\Permiso', 'id_perfil');
    }

    
}

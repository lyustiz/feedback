<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioPerfil extends Model
{
    protected $table 	  = 'usuario_perfil';

    protected $fillable   = [
                            'user_id',
	 	 	 	 	 	 	'id_perfil',
	 	 	 	 	 	 	'tx_observaciones',
	 	 	 	 	 	 	'status_id',
	 	 	 	 	 	 	'user_id_ed'
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
        return $query->addSelect('id', 'nb_');
    }
    
    public function status()
    {
        return $this->BelongsTo('App\Models\Status', 'status_id')->where('co_grupo', 'GRAL');
    }
                           
    public function user()
    {
        return $this->BelongsTo('App\Models\User', 'user_id');
    }

    public function perfil()
    {
        return $this->BelongsTo('App\Models\Perfil', 'id_perfil');
    }


}

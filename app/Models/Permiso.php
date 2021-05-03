<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table 	  = 'permiso';

    protected $fillable   = [
                            'id_menu',
	 	 	 	 	 	 	'id_perfil',
	 	 	 	 	 	 	'bo_select',
	 	 	 	 	 	 	'bo_insert',
	 	 	 	 	 	 	'bo_update',
	 	 	 	 	 	 	'bo_delete',
	 	 	 	 	 	 	'bo_admin',
	 	 	 	 	 	 	'bo_default',
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

    public function menu()
    {
        return $this->BelongsTo('App\Models\Menu', 'id_menu');
    }
}

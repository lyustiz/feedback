<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    protected $table 	  = 'vendedor';

    protected $fillable   = [
                            'nb_vendedor',
	 	 	 	 	 	 	'tx_documento',
	 	 	 	 	 	 	'tx_telefono',
	 	 	 	 	 	 	'tx_telefono2',
	 	 	 	 	 	 	'tx_direccion',
	 	 	 	 	 	 	'tx_observaciones',
	 	 	 	 	 	 	'status_id',
	 	 	 	 	 	 	'user_id'
                            ]; 
    
    protected $hidden     = [
                            'created_at',
	 	 	 	 	 	 	'updated_at'
                            ];



    public function scopeActivo($query, $activo = true)
    {
        return  ($activo) ? $query->where('status_id', 1) : $query ;
    }

    public function scopeComboData($query, $combo = true)
    {
        return ($combo) ? $query->addSelect('id', 'nb_vendedor', 'tx_documento', 'tx_telefono') : $query ;
    }

    public function status()
    {
        return $this->BelongsTo('App\Models\Status', 'status_id');
    }
                           
    public function user()
    {
        return $this->BelongsTo('App\Models\User', 'user_id');
    }

    public function suscripcion()
    {
        return $this->HasMany('App\Models\Suscripcion', 'id_vendedor');
    }
}

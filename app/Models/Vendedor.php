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
	 	 	 	 	 	 	'id_status',
	 	 	 	 	 	 	'id_usuario'
                            ]; 
    
    protected $hidden     = [
                            'created_at',
	 	 	 	 	 	 	'updated_at'
                            ];



    public function scopeActivo($query, $activo = true)
    {
        return  ($activo) ? $query->where('id_status', 1) : $query ;
    }

    public function scopeComboData($query, $combo = true)
    {
        return ($combo) ? $query->addSelect('id', 'nb_vendedor', 'tx_documento', 'tx_telefono') : $query ;
    }

    public function status()
    {
        return $this->BelongsTo('App\Models\Status', 'id_status');
    }
                           
    public function usuario()
    {
        return $this->BelongsTo('App\Models\Usuario', 'id_usuario');
    }

    public function suscripcion()
    {
        return $this->HasMany('App\Models\Suscripcion', 'id_vendedor');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoSuscripcion extends Model
{
    protected $table 	  = 'tipo_suscripcion';

    protected $fillable   = [
                            'nb_tipo_suscripcion',
	 	 	 	 	 	 	'nu_dias',
	 	 	 	 	 	 	'nu_monto',
	 	 	 	 	 	 	'tx_icono',
	 	 	 	 	 	 	'tx_color',
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
        return ($combo) ? $query->addSelect('id', 'nb_tipo_suscripcion', 'nu_dias', 'nu_monto', 'tx_icono', 'tx_color') : $query ;
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
        return $this->HasMany('App\Models\Suscripcion', 'id_tipo_suscripcion');
    }
}

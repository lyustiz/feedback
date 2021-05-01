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
        return ($combo) ? $query->addSelect('id', 'nb_tipo_suscripcion', 'nu_dias', 'nu_monto', 'tx_icono', 'tx_color') : $query ;
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
        return $this->HasMany('App\Models\Suscripcion', 'id_tipo_suscripcion');
    }
}

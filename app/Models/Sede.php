<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $table 	  = 'sede';

    protected $fillable   = [
                            'nb_sede',
	 	 	 	 	 	 	'tx_ubicacion',
	 	 	 	 	 	 	'tx_mapa',
	 	 	 	 	 	 	'tx_transmision',
	 	 	 	 	 	 	'tx_foto',
	 	 	 	 	 	 	'tx_telefono',
	 	 	 	 	 	 	'tx_whatsapp',
	 	 	 	 	 	 	'tx_observaciones',
	 	 	 	 	 	 	'id_status',
	 	 	 	 	 	 	'id_usuario'
                            ]; 
    
    protected $hidden     = [
                            'created_at',
	 	 	 	 	 	 	'updated_at'
                            ];



    public function scopeActivo($query)
    {
        return $query->where('id_status', 1);
    }

    public function scopeComboData($query)
    {
        return $query->addSelect('id', 'nb_');
    }

    public function status()
    {
        return $this->BelongsTo('App\Models\Status', 'id_status');
    }
                           
    public function usuario()
    {
        return $this->BelongsTo('App\Models\Usuario', 'id_usuario');
    }

    public function foto()
    {
        return $this->hasOne('App\Models\Foto',  'id_origen', 'id')->where('id_tipo_foto', 2);
	}
}

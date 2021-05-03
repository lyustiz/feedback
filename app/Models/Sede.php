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
        return $query->addSelect('id', 'nb_');
    }

    public function status()
    {
        return $this->BelongsTo('App\Models\Status', 'status_id');
    }
                           
    public function user()
    {
        return $this->BelongsTo('App\Models\User', 'user_id');
    }

    public function foto()
    {
        return $this->hasOne('App\Models\Foto',  'id_origen', 'id')->where('id_tipo_foto', 2);
	}
}

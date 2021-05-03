<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enlace extends Model
{
    protected $table 	  = 'enlace';

    protected $fillable   = [
                            'nb_enlace',
                            'id_tipo_enlace',
                            'id_tema',
	 	 	 	 	 	 	'tx_descripcion',
	 	 	 	 	 	 	'tx_url',
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
        return $query->addSelect('id', 'nb_enlace');
    }

    public function status()
    {
        return $this->BelongsTo('App\Models\Status', 'status_id');
    }
                           
    public function user()
    {
        return $this->BelongsTo('App\Models\User', 'user_id');
    }

    public function tipoEnlace()
    {
        return $this->BelongsTo('App\Models\TipoEnlace', 'id_tipo_enlace');
    }

    public function tema()
    {
        return $this->BelongsTo('App\Models\Tema', 'id_tema');
    }

    public function asignacion()
    {
        return $this->morphMany('App\Asignacion', 'id_origen');
    }
}

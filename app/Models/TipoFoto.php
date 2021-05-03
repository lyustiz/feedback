<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoFoto extends Model
{
    protected $table 	  = 'tipo_foto';

    protected $fillable   = [
                            'nb_tipo_foto',
	 	 	 	 	 	 	'tx_origen',
	 	 	 	 	 	 	'tx_storage',
	 	 	 	 	 	 	'tx_base_path',
	 	 	 	 	 	 	'tx_grupo',
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
        return $query->addSelect('id', 'nb_tipo_foto');
    }
    
    public function status()
    {
        return $this->BelongsTo('App\Models\Status', 'status_id')->where('co_grupo', 'GRAL');
    }
                           
    public function user()
    {
        return $this->BelongsTo('App\Models\User', 'user_id');
    }
}

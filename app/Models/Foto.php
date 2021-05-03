<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $table 	  = 'foto';

    protected $fillable   = [
                            'nb_foto',
	 	 	 	 	 	 	'tx_src',
	 	 	 	 	 	 	'id_tipo_foto',
	 	 	 	 	 	 	'id_origen',
	 	 	 	 	 	 	'tx_observaciones',
	 	 	 	 	 	 	'status_id',
	 	 	 	 	 	 	'user_id'
                            ]; 
    
    protected $hidden     = [
                            'created_at',
	 	 	 	 	 	 	'updated_at'
                            ]; 

    protected $appends = ['full_url'];
    
    public function getFullUrlAttribute()
    {
        return "{$this->tipoFoto->tx_base_path}{$this->tx_src}";
    }

    public function scopeActivo($query)
    {
        return $query->where('status_id', 1);
	}

	public function scopeComboData($query)
    {
        return $query->addSelect('id', 'nb_foto');
    }
                           
    public function status()
    {
        return $this->BelongsTo('App\Models\Status', 'status_id')->where('co_grupo', 'GRAL');
    }
                           
    public function user()
    {
        return $this->BelongsTo('App\Models\User', 'user_id');
    }

    public function tipoFoto()
    {
        return $this->BelongsTo('App\Models\TipoFoto', 'id_tipo_foto');
    }

    public function sede()
    {
        return $this->BelongsTo('App\Models\Sede', 'id_origen', 'id');
    }

}

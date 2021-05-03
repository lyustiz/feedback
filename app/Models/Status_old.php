<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table 	  = 'status';

    protected $fillable   = [
                            'nb_status',
	 	 	 	 	 	 	'nb_secundario',
	 	 	 	 	 	 	'co_status',
                            'co_grupo',
                            'tx_icono',
                            'tx_color',
	 	 	 	 	 	 	'id_padre',
	 	 	 	 	 	 	'tx_observaciones',
	 	 	 	 	 	 	'bo_activo',
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
        return ($combo) ? $query->addSelect('id', 'nb_status', 'tx_icono', 'tx_color') : $query ;
    }
                        
    
    public function status()
    {
        return $this->BelongsTo('App\Models\Status', 'status_id')->where('co_grupo', 'GRAL');
    }
                           
    public function user()
    {
        return $this->BelongsTo('App\Models\User', 'user_id');
    }

                           
    //


}

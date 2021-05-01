<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FailedJobs extends Model
{
    protected $table 	  = 'failed_jobs';

    protected $fillable   = [
                            'uuid',
	 	 	 	 	 	 	'connection',
	 	 	 	 	 	 	'queue',
	 	 	 	 	 	 	'payload',
	 	 	 	 	 	 	'exception',
	 	 	 	 	 	 	'failed_at'
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
}

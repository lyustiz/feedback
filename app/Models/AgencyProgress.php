<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgencyProgress extends Model
{
    protected $table 	  = 'agency_progress';

    protected $fillable   = [
                            'agency_id',
	 	 	 	 	 	 	'day_positive',
	 	 	 	 	 	 	'day_negative',
	 	 	 	 	 	 	'month_positive',
	 	 	 	 	 	 	'month_negative',
	 	 	 	 	 	 	'total_positive',
	 	 	 	 	 	 	'total_negative',
	 	 	 	 	 	 	'task_mails',
	 	 	 	 	 	 	'task_photos',
	 	 	 	 	 	 	'task_videos',
	 	 	 	 	 	 	'comments',
	 	 	 	 	 	 	'status_id',
	 	 	 	 	 	 	'user_id'
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

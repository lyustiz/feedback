<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileProgress extends Model
{
    protected $table 	  = 'profile_progress';

    protected $fillable   = [
                            'profile_id',
	 	 	 	 	 	 	'progress_day',
	 	 	 	 	 	 	'progress_month',
	 	 	 	 	 	 	'progress_total',
	 	 	 	 	 	 	'progress_max_day',
	 	 	 	 	 	 	'progress_max_month',
	 	 	 	 	 	 	'crowns',
	 	 	 	 	 	 	'hearts',
	 	 	 	 	 	 	'milestone_day',
	 	 	 	 	 	 	'milestone_month',
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    protected $table 	  = 'user_progress';

    protected $fillable   = [
                            'user_id',
	 	 	 	 	 	 	'progress_day',
	 	 	 	 	 	 	'progress_month',
	 	 	 	 	 	 	'progress_total',
	 	 	 	 	 	 	'progress_max_day',
	 	 	 	 	 	 	'progress_max_month',
	 	 	 	 	 	 	'rank',
	 	 	 	 	 	 	'milestone_day',
	 	 	 	 	 	 	'milestone_month',
	 	 	 	 	 	 	'comments',
	 	 	 	 	 	 	'status_id',
	 	 	 	 	 	 	'user_id_ed'
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileProgress extends Model
{
    protected $table 	  = 'profile_progress';

    protected $fillable   = [
                            'profile_id',
                            'amolatina_id',
	 	 	 	 	 	 	'profit_day',
	 	 	 	 	 	 	'profit_month',
	 	 	 	 	 	 	'profit_total',
	 	 	 	 	 	 	'profit_max_day',
	 	 	 	 	 	 	'profit_max_month',
                            'points_day',
	 	 	 	 	 	 	'points_month',
	 	 	 	 	 	 	'points_total',
                            'writeoff_day',
	 	 	 	 	 	 	'writeoff_month',
	 	 	 	 	 	 	'writeoff_total',
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



    public function scopeActive($query, $active=false)
    {
        return ($active) ?  $query->where('status_id', 1) : $query;
    }

    public function scopeComboData($query)
    {
        return $query->addSelect('id', 'name');
    }

    public function status()
    {
        return $this->BelongsTo('App\Models\Status', 'status_id');
    }
                           
    public function user()
    {
        return $this->BelongsTo('App\Models\User', 'user_id');
    }
}

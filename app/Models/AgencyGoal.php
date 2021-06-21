<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgencyGoal extends Model
{
    protected $table 	  = 'agency_goal';

    protected $fillable   = [
                            'agency_id',
	 	 	 	 	 	 	'goal_type_id',
	 	 	 	 	 	 	'value',
	 	 	 	 	 	 	'start',
	 	 	 	 	 	 	'end',
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
        return $this->BelongsTo('App\Models\Status');
    }
                           
    public function user()
    {
        return $this->BelongsTo('App\Models\User');
    }

    public function goalType()
    {
        return $this->BelongsTo('App\Models\GoalType');
    }
}

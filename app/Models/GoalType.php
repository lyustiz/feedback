<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoalType extends Model
{
    protected $table 	  = 'goal_type';

    protected $fillable   = [
                            'name',
	 	 	 	 	 	 	'group',
	 	 	 	 	 	 	'amount',
	 	 	 	 	 	 	'icon',
	 	 	 	 	 	 	'color',
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

    public function agencyGoal()
    {
        return $this->hasMany('App\Models\AgencyGoal')->where('group', 'agency');
    }
}

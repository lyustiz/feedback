<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table 	  = 'config';

    protected $fillable   = [
                            'name',
	 	 	 	 	 	 	'type',
	 	 	 	 	 	 	'group',
	 	 	 	 	 	 	'value',
	 	 	 	 	 	 	'start_at',
	 	 	 	 	 	 	'end_at',
	 	 	 	 	 	 	'comments',
	 	 	 	 	 	 	'active',
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

    public function scopeGroup($query, $group=false)
    {
        return ($group) ? $query->where('group', $group) : $query; 
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

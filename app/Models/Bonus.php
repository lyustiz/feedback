<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    protected $table 	  = 'bonus';

    protected $fillable   = [
                            'bonus_id',
	 	 	 	 	 	 	'service',
	 	 	 	 	 	 	'fact',
	 	 	 	 	 	 	'cllient_id',
	 	 	 	 	 	 	'profile_id',
	 	 	 	 	 	 	'points',
	 	 	 	 	 	 	'profit',
	 	 	 	 	 	 	'share',
	 	 	 	 	 	 	'comments',
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

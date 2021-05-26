<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table 	  = 'client';

    protected $fillable   = [
                            'amolatina_id',
	 	 	 	 	 	 	'name',
	 	 	 	 	 	 	'birthday',
	 	 	 	 	 	 	'age',
	 	 	 	 	 	 	'photo',
	 	 	 	 	 	 	'gender',
	 	 	 	 	 	 	'preference',
	 	 	 	 	 	 	'country',
	 	 	 	 	 	 	'city',
	 	 	 	 	 	 	'profit',
	 	 	 	 	 	 	'crown',
	 	 	 	 	 	 	'contacted_at',
	 	 	 	 	 	 	'last_contact',
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
}

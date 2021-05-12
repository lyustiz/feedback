<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $table 	  = 'agency';

    protected $fillable   = [
                            'name',
                            'user',
	 	 	 	 	 	 	'password',
                            'token',
                            'token_at',
                            'token_active',
	 	 	 	 	 	 	'parent_id',
	 	 	 	 	 	 	'user',
	 	 	 	 	 	 	'password',
	 	 	 	 	 	 	'amolatina_id',
	 	 	 	 	 	 	'comments',
	 	 	 	 	 	 	'status_id',
	 	 	 	 	 	 	'user_id'
                            ]; 
    
    protected $hidden     = [
                            'created_at',
	 	 	 	 	 	 	'updated_at',
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

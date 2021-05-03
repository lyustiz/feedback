<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table 	  = 'user';

    protected $fillable   = [
                            'username',
	 	 	 	 	 	 	'password',
	 	 	 	 	 	 	'name',
	 	 	 	 	 	 	'surname',
	 	 	 	 	 	 	'role_id',
	 	 	 	 	 	 	'agency_id',
	 	 	 	 	 	 	'group_id',
	 	 	 	 	 	 	'photo',
	 	 	 	 	 	 	'email',
	 	 	 	 	 	 	'verification',
	 	 	 	 	 	 	'email_verified_at',
	 	 	 	 	 	 	'remember_token',
	 	 	 	 	 	 	'api_token',
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
        return $query->where('status_id', 1);
    }

    public function scopeComboData($query)
    {
        return $query->addSelect('id', 'nb_');
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

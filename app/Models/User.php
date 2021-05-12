<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;
    
    protected $table 	  = 'user';

    protected $fillable   = [
                            'username',
	 	 	 	 	 	 	'password',
	 	 	 	 	 	 	'name',
	 	 	 	 	 	 	'surname',
	 	 	 	 	 	 	'role_id',
	 	 	 	 	 	 	'agency_id',
	 	 	 	 	 	 	'group_id',
                            'table_id',
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
	 	 	 	 	 	 	'updated_at',
                            'password',
                            'verification',
	 	 	 	 	 	 	'email_verified_at',
	 	 	 	 	 	 	'remember_token',
	 	 	 	 	 	 	'api_token'
                            ];

    protected $appends = ['full_name'];
    
    public function getFullNameAttribute()
    {
        return trim(str_replace( '  ', ' ',  "{$this->name} {$this->surname}")) ;
    }

    public function scopeActive($query, $active=false)
    {
        return ($active) ?  $query->where('status_id', 1) : $query;
    }

    public function scopeOperator($query, $operator=false)
    {
        return ($operator) ?  $query->where('role_id', 4) : $query;
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

    public function role()
    {
        return $this->BelongsTo('App\Models\Role');
    }

    public function agency()
    {
        return $this->BelongsTo('App\Models\Agency');
    }

    public function group()
    {
        return $this->BelongsTo('App\Models\Group');
    }

    public function table()
    {
        return $this->BelongsTo('App\Models\Table');
    }


    public function userProfile()
    {
        return $this->BelongsTo('App\Models\Profile');
    }

    public function profile()
	{
		return $this->hasManyThrough(
			'App\Models\Profile', //final
            'App\Models\UserProfile', //intermedia
            'user_id', // fk en intermedia
            'id', // laocal en origen
            'id', // local en final
			'profile_id' // fk en intermedia
		);
	}

    
}

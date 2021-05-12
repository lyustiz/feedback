<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table 	  = 'profile';

    protected $fillable   = [
                            'agency_id',
                            'amolatina_id',
                            'user',
                            'password',
	 	 	 	 	 	 	'name',
	 	 	 	 	 	 	'birthday',
	 	 	 	 	 	 	'age',
	 	 	 	 	 	 	'photo',
	 	 	 	 	 	 	'gender',
	 	 	 	 	 	 	'preference',
	 	 	 	 	 	 	'country',
	 	 	 	 	 	 	'city',
	 	 	 	 	 	 	'minage',
	 	 	 	 	 	 	'maxage',
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
                           
    public function userEd()
    {
        return $this->BelongsTo('App\Models\User');
    }

    public function userProfile()
    {
        return $this->HasMany('App\Models\UserProfile');
    }

    public function user()
	{
		return $this->hasManyThrough(
			'App\Models\User', //final
            'App\Models\UserProfile', //intermedia
            'profile_id', // fk en intermedia
            'id', // laocal en origen
            'id', // local en final
            'user_id' // fk en intermedia
		);
	}


}

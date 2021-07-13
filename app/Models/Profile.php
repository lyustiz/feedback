<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
                            'goal_day',
                            'goal_month',
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

    public function userProfileAssigned()
    {
        return $this->HasOne('App\Models\UserProfile');
    }

    public function usersProfileAssigned()
    {
        return $this->HasMany('App\Models\UserProfile');
    }

    public function agency()
	{
		return $this->BelongsTo('App\Models\Agency');
	}

    public function presence()
    {
        return $this->HasOne('App\Models\UserPresence')->where('status_id', 3);
    }

    public function profileProgress()
    {
        return $this->HasOne('App\Models\ProfileProgress');
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

    public function userHasPresenceDay()
    {
        return $this->hasManyThrough(
			'App\Models\User', //final
            'App\Models\UserPresence', //intermedia
            'profile_id', // fk en intermedia
            'id', // laocal en origen
            'id', // local en final
            'user_id' // fk en intermedia
		)->whereBetween('user_presence.start_at', [
            Carbon::now()->startOfDay(), 
            Carbon::now()->endOfDay()
            ])
        ->distinct();
    }

    public function presenceDay()
    {
        return $this->HasMany('App\Models\UserPresence')->whereBetween('start_at', [
                                                                                     Carbon::now()->startOfDay(), 
                                                                                     Carbon::now()->endOfDay()
                                                                                     ]);
    }

    public function presenceMonth()
    {
        return $this->HasMany('App\Models\UserPresence')->whereBetween('start_at', [
                                                                                     Carbon::now()->startOfMonth(), 
                                                                                     Carbon::now()->endOfMonth()
                                                                                     ]);
    }

    


}

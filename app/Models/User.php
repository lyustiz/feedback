<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes ;
    
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
                            'goal_day',
                            'goal_month',
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
                            'deleted_at',
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

    public function penalty()
    {
        return $this->HasMany('App\Models\Penalty');
    }

    public function penaltyMonth()
    {
        return $this->HasMany('App\Models\Penalty')->whereBetween('day', [
                                                                            Carbon::now()->startOfMonth(), 
                                                                            Carbon::now()->endOfMonth()
                                                                        ]);;
    }

    public function absence()
    {
        return $this->HasMany('App\Models\Absence');
    }

    public function absenceMonth()
    {
        return $this->HasMany('App\Models\Absence')->whereBetween('day', [
                                                                            Carbon::now()->startOfMonth(), 
                                                                            Carbon::now()->endOfMonth()
                                                                            ]);;
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

    public function agency()
	{
		return $this->hasManyThrough(
			'App\Models\Agency', //final
            'App\Models\UserProfile', //intermedia
            'user_id', // fk en intermedia
            'id', // laocal en origen
            'id', // local en final
			'agency_id' // fk en intermedia
		)->distinct();

       // return $this->belongsToMany(Agency::class, 'user_profile', 'user_id', 'agency_id');
	}

    public function agencyManage()
	{
		return $this->hasManyThrough(
			'App\Models\Agency', //final
            'App\Models\UserAgency', //intermedia
            'user_id', // fk en intermedia
            'id', // laocal en origen
            'id', // local en final
			'agency_id' // fk en intermedia
		);
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

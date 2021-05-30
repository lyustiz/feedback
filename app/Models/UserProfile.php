<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use SoftDeletes;
    
    protected $table 	  = 'user_profile';

    protected $fillable   = [
                            'user_id',
	 	 	 	 	 	 	'profile_id',
                            'agency_id',
                            'goal',
	 	 	 	 	 	 	'comments',
	 	 	 	 	 	 	'status_id',
	 	 	 	 	 	 	'user_id_ed'
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
        return $this->BelongsTo('App\Models\User', 'user_id_ed');
    }

    public function user()
    {
        return $this->BelongsTo('App\Models\User');
    }

    public function profile()
    {
        return $this->BelongsTo('App\Models\Profile');
    }

    public function agency()
    {
        return $this->BelongsTo('App\Models\Agency');
    }
}

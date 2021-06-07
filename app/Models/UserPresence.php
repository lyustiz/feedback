<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserPresence extends Model
{
    protected $table 	  = 'user_presence';

    protected $fillable   = [
                            'user_id',
	 	 	 	 	 	 	'profile_id',
	 	 	 	 	 	 	'start_at',
	 	 	 	 	 	 	'end_at',
	 	 	 	 	 	 	'bonus',
	 	 	 	 	 	 	'writeoff',
	 	 	 	 	 	 	'shared',
	 	 	 	 	 	 	'profit',
	 	 	 	 	 	 	'comments',
	 	 	 	 	 	 	'active',
	 	 	 	 	 	 	'status_id',
	 	 	 	 	 	 	'user_id_ed'
                            ]; 
    
    protected $hidden     = [
                            'created_at',
	 	 	 	 	 	 	'updated_at'
                            ];

    public function scopeStarted($query, $active=false)
    {
        return ($active) ?  $query->where('status_id', 3) : $query;
    }

    public function scopeFinished($query, $finished=false)
    {
        return ($finished) ?  $query->where('status_id', 4) : $query;
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

    public function profile()
    {
        return $this->BelongsTo('App\Models\Profile');
    }

    public function userEd()
    {
        return $this->BelongsTo('App\Models\User', 'user_id_ed');
    }

    public function comission()
    {
        return $this->Hasmany('App\Models\Comission', 'profile_id', 'amolatina_id');
    }

    public function comissionDay()
    {
        return $this->Hasmany('App\Models\Comission', 'profile_id', 'amolatina_id')->whereBetween('comission_at', [
            Carbon::now()->startOfDay(), 
            Carbon::now()->endOfDay()
            ]);
    }

    public function comissionMonth()
    {
        return $this->Hasmany('App\Models\Comission', 'profile_id', 'amolatina_id')->whereBetween('comission_at', [
            Carbon::now()->startOfMonth(), 
            Carbon::now()->endOfMonth()
            ]);
    }

}

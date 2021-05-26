<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    
    
    protected $pending    = 5;
    protected $contacted  = 6;
    protected $captured   = 7;
    protected $discarted  = 8;


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

    public function clients()
    {
        return $this->hasMany('App\Models\Client');
    }

    public function clientsPending()
    {
        return $this->hasMany('App\Models\Client')->where('status_id', $this->pending);
    }

    public function clientsContacted()
    {
        return $this->hasMany('App\Models\Client')->where('status_id', $this->contacted);
    }

    public function clientsCaptured()
    {
        return $this->hasMany('App\Models\Client')->where('status_id', $this->captured);
    }

    public function clientsDay()
    {
        return $this->hasMany('App\Models\Client')->whereBetween('contacted_at', [
            Carbon::now()->startOfDay(), 
            Carbon::now()->endOfDay()
        ])->whereNotNull('contacted_at')->whereIn('status_id',[$this->contacted,$this->captured]);
    }

    public function clientsWeek()
    {
        return $this->hasMany('App\Models\Client')->whereBetween('contacted_at', [
            Carbon::now()->startOfWeek(Carbon::SUNDAY), 
            Carbon::now()->endOfWeek(Carbon::MONDAY)
        ])->whereNotNull('contacted_at')->whereIn('status_id',[$this->contacted,$this->captured]);
    }

    public function clientsMonth()
    {
        return $this->hasMany('App\Models\Client')->whereBetween('contacted_at', [
            Carbon::now()->startOfMonth(), 
            Carbon::now()->endOfMonth()
        ])->whereNotNull('contacted_at')->whereIn('status_id',[$this->contacted,$this->captured]);
    }

}

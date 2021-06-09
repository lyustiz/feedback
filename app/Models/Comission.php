<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comission extends Model
{
    protected $table 	  = 'comission';

    protected $fillable   = [
                            'comission_id',
	 	 	 	 	 	 	'fact',
	 	 	 	 	 	 	'service',
	 	 	 	 	 	 	'points',
	 	 	 	 	 	 	'profit',
	 	 	 	 	 	 	'share',
	 	 	 	 	 	 	'agency_id',
	 	 	 	 	 	 	'curator_id',
	 	 	 	 	 	 	'profile_id',
	 	 	 	 	 	 	'user_id',
	 	 	 	 	 	 	'cllient_id',
                            'comission_at',
	 	 	 	 	 	 	'comments',
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
        return $this->BelongsTo('App\Models\Status', 'status_id');
    }
                           
    public function user()
    {
        return $this->BelongsTo('App\Models\User');
    }

    public function profile()
    {
        return $this->BelongsTo('App\Models\Profile', 'profile_id', 'amolatina_id');
    }

    public function client()
    {
        return $this->BelongsTo('App\Models\Client', 'client_id', 'amolatina_id');
    }

    public function agency()
    {
        return $this->BelongsTo('App\Models\Agency', 'agency_id', 'amolatina_id');
    }

    public function hasService()
    {
        return $this->BelongsTo('App\Models\Service', 'service', 'value');
    }

    public function userPresence()
    {
        return $this->hasmanny('App\Models\Service', 'service', 'value');
    }


}

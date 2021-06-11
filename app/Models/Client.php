<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table 	  = 'client';

    protected $fillable   = [
                            'amolatina_id',
	 	 	 	 	 	 	'name',
	 	 	 	 	 	 	'birthday',
	 	 	 	 	 	 	'age',
	 	 	 	 	 	 	'photo',
	 	 	 	 	 	 	'gender',
	 	 	 	 	 	 	'preference',
	 	 	 	 	 	 	'country',
	 	 	 	 	 	 	'city',
                            'points',
	 	 	 	 	 	 	'profit',
	 	 	 	 	 	 	'crown',
	 	 	 	 	 	 	'contacted_at',
	 	 	 	 	 	 	'last_contact',
	 	 	 	 	 	 	'comments',
	 	 	 	 	 	 	'status_id',
	 	 	 	 	 	 	'user_id'
                            ]; 
    
    protected $hidden     = [
                            'created_at',
	 	 	 	 	 	 	'updated_at'
                            ];

    protected $pending    = 5;
    protected $contacted  = 6;
    protected $captured   = 7;
    protected $discarted  = 8;

    public function scopePending($query, $pending=false)
    {
        return ($pending) ?  $query->where('status_id', $this->pending) : $query;
    }

    public function scopeContacted($query, $contacted=false)
    {
        return ($contacted) ?  $query->where('status_id', $this->contacted) : $query;
    }

    public function scopeCaptured($query, $captured=false)
    {
        return ($captured) ?  $query->where('status_id', $this->captured) : $query;
    }

    public function scopeDiscarted($query, $discarted=false)
    {
        return ($discarted) ?  $query->where('status_id', $this->discarted) : $query;
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

    public function agency()
    {
        return $this->BelongsTo('App\Models\Agency');
    }

    public function comissionContacted()
    {
        return $this->HasOne('App\Models\Comission',  'client_id',  'amolatina_id');
    }
}

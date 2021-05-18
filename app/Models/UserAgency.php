<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAgency extends Model
{
    protected $table 	  = 'user_agency';

    protected $fillable   = [
                            'user_id',
	 	 	 	 	 	 	'agency_id',
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
                           
    public function user()
    {
        return $this->BelongsTo('App\Models\User');
    }

    public function agency()
    {
        return $this->BelongsTo('App\Models\Agency');
    }
}

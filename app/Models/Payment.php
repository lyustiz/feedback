<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table 	  = 'payment';

    protected $fillable   = [
                            'name',
	 	 	 	 	 	 	'grupo',
	 	 	 	 	 	 	'profile_id',
	 	 	 	 	 	 	'bonus_type_id',
	 	 	 	 	 	 	'start_at',
	 	 	 	 	 	 	'end_at',
	 	 	 	 	 	 	'payment_class_id',
	 	 	 	 	 	 	'ammount',
	 	 	 	 	 	 	'times',
	 	 	 	 	 	 	'comments',
	 	 	 	 	 	 	'status_id',
	 	 	 	 	 	 	'user_id'
                            ]; 
    
    protected $hidden     = [
                            'created_at',
	 	 	 	 	 	 	'updated_at'
                            ];



    public function scopeActivo($query)
    {
        return $query->where('status_id', 1);
    }

    public function scopeComboData($query)
    {
        return $query->addSelect('id', 'nb_');
    }

    public function status()
    {
        return $this->BelongsTo('App\Models\Status', 'status_id');
    }
                           
    public function user()
    {
        return $this->BelongsTo('App\Models\User', 'user_id');
    }
}

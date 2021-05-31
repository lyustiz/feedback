<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table 	  = 'table';

    protected $fillable   = [
                            'name',
	 	 	 	 	 	 	'value',
	 	 	 	 	 	 	'turn_id',
	 	 	 	 	 	 	'comments',
	 	 	 	 	 	 	'status_id',
	 	 	 	 	 	 	'coordinator_id',
                            'manager_id',
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
                           
    public function user()
    {
        return $this->BelongsTo('App\Models\User');
    }

    public function operator()
    {
        return $this->HasMany('App\Models\User')->where('role_id', 4);
    }

    public function turn()
    {
        return $this->BelongsTo('App\Models\Turn');
    }

    public function manager()
    {
        return $this->BelongsTo('App\Models\User', 'manager_id', 'id' );
    }

    public function coordinator()
    {
        return $this->BelongsTo('App\Models\User', 'coordinator_id', 'id' );
    }
}

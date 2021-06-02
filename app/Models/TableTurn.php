<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableTurn extends Model
{
    protected $table 	  = 'table_turn';

    protected $fillable   = [
                            'table_id',
	 	 	 	 	 	 	'turn_id',
	 	 	 	 	 	 	'coordinator_id',
	 	 	 	 	 	 	'value',
	 	 	 	 	 	 	'color',
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
                           
    public function user()
    {
        return $this->BelongsTo('App\Models\User');
    }

    public function turn()
    {
        return $this->BelongsTo('App\Models\Turn');
    }

    public function table()
    {
        return $this->BelongsTo('App\Models\Table');
    }

    public function coordinator()
    {
        return $this->BelongsTo('App\Models\User', 'coordinator_id', 'id')->where('role_id', 3);
    }

    public function operator()
	{
		return $this->hasMany('App\Models\User')->whereIn('role_id', [4, 3]);
	}
}

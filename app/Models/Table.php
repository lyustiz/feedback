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

    public static function boot() {
        parent::boot();

        static::deleting(function($table) { // before delete() method call this
                $table->tableTurn()->delete();
                // do the rest of the cleanup...
        });
    }

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

    public function tableTurn()
    {
        return $this->hasMany('App\Models\TableTurn');
    }


    public function turn()
	{
		return $this->hasManyThrough(
			'App\Models\Turn', //final
            'App\Models\TableTurn', //intermedia
            'table_id', // fk en intermedia
            'id', // laocal en origen
            'id', // local en final
            'turn_id' // fk en intermedia
		);
	}

    public function coordinator()
	{
		return $this->hasManyThrough(
			'App\Models\User', //final
            'App\Models\TableTurn', //intermedia
            'table_id', // fk en intermedia
            'id', // laocal en origen
            'id', // local en final
            'coordinator_id' // fk en intermedia
		);
	}


    public function manager()
    {
        return $this->BelongsTo('App\Models\User', 'manager_id', 'id' );
    }

}

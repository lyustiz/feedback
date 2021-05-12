<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table 	  = 'role';

    protected $fillable   = [
                            'name',
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
        return $this->BelongsTo('App\Models\Status', 'status_id');
    }
                           
    public function user()
    {
        return $this->BelongsTo('App\Models\User', 'user_id');
    }

    public function permission()
	{
		return $this->HasMany('App\Models\Permission', 'role_id');
	}

    public function menu()
	{
		return $this->hasManyThrough(
			
			'App\Models\Menu', //final
            'App\Models\Permission', //intermedia
            'role_id', // fk en intermedia
            'id', // laocal en origen
            'id', // local en final
			'menu_id' // fk en intermedia
		);
	}
}

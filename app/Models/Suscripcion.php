<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Suscripcion extends Model
{
    protected $table 	  = 'suscripcion';

    protected $fillable   = [
                            'id_suscriptor',
	 	 	 	 	 	 	'id_vendedor',
	 	 	 	 	 	 	'id_tipo_suscripcion',
	 	 	 	 	 	 	'fe_suscripcion',
	 	 	 	 	 	 	'nu_dias',
	 	 	 	 	 	 	'nu_monto',
	 	 	 	 	 	 	'fe_vencimiento',
	 	 	 	 	 	 	'tx_observaciones',
	 	 	 	 	 	 	'id_status',
	 	 	 	 	 	 	'id_usuario'
                            ]; 
    
    protected $hidden     = [
                            'created_at',
	 	 	 	 	 	 	'updated_at'
                            ];

    protected $appends = ['vencimiento'];

    public function getVencimientoAttribute()
    {
        
        $feVencimiento = Carbon::parse($this->fe_vencimiento)->setTime(0, 0, 0);
        $today          = Carbon::now()->setTime(0, 0, 0); //$dt->isSunday()$dt->isDayOfWeek(Carbon::SATURDAY);  $dt->addDays(29);
        $days          = $feVencimiento->diffInDays($today);

       /*  return $days = $feVencimiento->diffInDaysFiltered(function(Carbon $date) {
            return !$date->isSunday();
         }, $today); */
        
        if($feVencimiento->greaterThan($today) and $days > 0) return [ 'tx_vencido' => 'activo', 'bo_vencido' => false , 'tx_color' => 'success'];

        if($feVencimiento->greaterThanOrEqualTo($today) and $days == 0) return [ 'tx_vencido' => 'por vencer', 'bo_vencido' => false , 'tx_color' => 'warning'];

        if($feVencimiento->lessThan($today) and $days == 0) return [ 'tx_vencido' => 'por vencer', 'bo_vencido' => false , 'tx_color' => 'warning'];

        if($feVencimiento->lessThan($today) and $days > 0) return [ 'tx_vencido' => 'vencido', 'bo_vencido' => true , 'tx_color' => 'error'];
    }
                        
    
    public function scopeActivo($query, $activo = true)
    {
        return  ($activo) ? $query->where('id_status', 1) : $query ;
    }

    public function status()
    {
        return $this->BelongsTo('App\Models\Status', 'id_status');
    }
                           
    public function usuario()
    {
        return $this->BelongsTo('App\Models\Usuario', 'id_usuario');
    }

    public function suscriptor()
    {
        return $this->BelongsTo('App\Models\Suscriptor', 'id_suscriptor');
    }

    public function tipoSuscripcion()
    {
        return $this->BelongsTo('App\Models\TipoSuscripcion', 'id_tipo_suscripcion');
    }

    public function vendedor()
    {
        return $this->BelongsTo('App\Models\Vendedor', 'id_vendedor');
    }
}

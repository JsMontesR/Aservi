<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pago;
use App\Servicio;

class Afiliacion extends Model
{

    protected $table = 'afiliaciones';
    protected $fillable = ['id','fechaSiguientePago','cliente_id','servicio_id'];

    public function pagos(){
    	return $this->hasMany(Pago::class);
    }

    public function servicio(){
    	return $this->belongsTo(Servicio::class);
    }

}

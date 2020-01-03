<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pago;

class Servicio extends Model
{
    protected $table = 'servicios';
    protected $fillable = ['id','nombre','periodicidad'];

    public function pagos(){
    	return $this->belongsToMany(Pago::class,'pagos','id','servicio_id');
    }

}

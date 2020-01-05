<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Afiliacion;

class Servicio extends Model
{
    protected $table = 'servicios';
    protected $fillable = ['id','nombre','periodicidad'];

    public function afiliaciones(){
    	return $this->hasMany(Afiliacion::class);
    }

}

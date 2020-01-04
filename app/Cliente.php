<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Afiliacion;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = ['id','di','nombre','direccion','email','telefonocelular','telefonofijo'];

    public function afiliaciones(){
    	return $this->belongsToMany(Afiliacion::class,'afiliaciones','id','cliente_id');
    }
}

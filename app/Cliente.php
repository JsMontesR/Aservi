<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pago;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = ['id','di','nombre','direccion','email','telefonocelular','telefonofijo'];

    public function pagos(){
    	return $this->belongsToMany(Pago::class,'pagos','id','cliente_id');
    }
}

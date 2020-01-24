<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pago;
use App\Servicio;
use App\Cliente;

class Afiliacion extends Model
{

    protected $table = 'afiliaciones';
    protected $fillable = ['id','fechaSiguientePago','cliente_id','servicio_id'];

    public function pagos(){
    	return $this->hasMany(Pago::class);
    }

    public function cliente(){
    	return $this->belongsTo(Cliente::class);
    }

    public function servicio(){
    	return $this->belongsTo(Servicio::class);
    }

    public function empresa(){
    	return $this->belongsTo(Empresa::class);
    }

}

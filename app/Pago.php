<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Afiliacion;

class Pago extends Model
{
    protected $table = 'pagos';
    protected $fillable = ['id','monto','afiliacion_id'];

    public function afiliacion(){
    	return $this->belongsTo(Afiliacion::class);
    }
}

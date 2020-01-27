<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Afiliacion;
use App\User;

class Pago extends Model
{
    protected $table = 'pagos';
    protected $fillable = ['id',,'afiliacion_id'];

    public function afiliacion(){
    	return $this->belongsTo(Afiliacion::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }

}

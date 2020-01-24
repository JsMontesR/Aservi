<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';
    protected $fillable = ['id','nombre'];

    public function afiliaciones(){
    	return $this->hasMany(Afiliacion::class,'afiliaciones','id','empresa_id');
    }
}

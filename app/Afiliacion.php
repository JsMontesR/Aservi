<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Afiliacion extends Model
{
    protected $table = 'afiliaciones';
    protected $fillable = ['id','fechaSiguientePago','cliente_id','servicio_id'];
}

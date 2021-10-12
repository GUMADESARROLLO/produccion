<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tiempo_lavado extends Model
{
    protected $table = "tiempo_lavado";
    protected $fillable = ['id', 'numOrden','tiempoLavado','fecha','cant_dia', 'cant_noche'];
}

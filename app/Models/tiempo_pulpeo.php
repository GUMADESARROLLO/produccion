<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tiempo_pulpeo extends Model
{
    protected $table = "tiempo_pulpeo";
    protected $fillable = ['id', 'numOrden','tiempoPulpeo','fecha','cant_dia', 'cant_noche'];
}

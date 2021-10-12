<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mp_directa extends Model
{
    protected $table = "mp_directa";
    protected $fillable = ['id', 'idMaquina', 'idFibra', 'numOrden','cantidad'];
    public $timestamps = false;
}

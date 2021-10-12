<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class produccionModel extends Model
{
    protected $table = "orden_produccion";
    protected $fillable = ['idOrden','numeroOrden','producto','idTurno','fechaInicio','fechaFinal','horaInicio','horaFinal','estado'];
    protected $guarded = ['idOrden'];
    public $timestamps = false;
}

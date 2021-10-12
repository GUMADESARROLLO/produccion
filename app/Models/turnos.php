<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class turnos extends Model
{
    protected $table = "turnos";
    protected $fillable = ['idTurno', 'turno', 'horaInicio', 'horaFinal', 'descripcion', 'estado'];
    protected $guarded = ['idTurno'];
    public $timestamps = false;
}

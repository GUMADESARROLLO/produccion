<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jumboroll extends Model
{
    protected $table = "jumboroll";
    protected $fillable = [
        'id',
        'numOrden',
        'fechaInicio',
        'fechaFinal',
        'residuo_pulper',
        'lavadora_tetrapack',
        'merma_yankee_dry_1',
        'merma_yankee_dry_2',
        'idTurno',
        'idUsuario'
    ];
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orden_produccion extends Model
{
    protected $table = "orden_produccion";
    protected $fillable = ['idOrden', 'numOrden', 'producto','idUsuario','hrsTrabajadas','fechaInicio','fechaFinal','horaInicio','horaFinal','comentario','estado','horaJY1','horaJY2','horaLY1','horaLY2'];
    protected $guarded = ['idOrden'];
    public $timestamps = false;
}

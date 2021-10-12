<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orden_produccion extends Model
{
    protected $table = "orden_produccion";
    protected $fillable = ['idOrden', 'numOrden', 'producto','idUsuario','hrsTrabajadas','fechaInicio','fechaFinal','horaInicio','horaFinal','estado'];
    protected $guarded = ['idOrden'];
    public $timestamps = false;
}

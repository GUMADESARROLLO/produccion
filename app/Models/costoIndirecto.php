<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class costoIndirecto extends Model
{
    protected $table = "costos_indirectos";
    protected $fillable = ['idActividad','numOrden','dia','noche','hora'];
    public $timestamps = false;
}

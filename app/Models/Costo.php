<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Costo extends Model
{
    protected $table = "costo";
    protected $fillable = ['codigo','descripcion','unidad_medida','estado'];
    public $timestamps = false;
}

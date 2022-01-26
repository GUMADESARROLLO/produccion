<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class horas_efectivas extends Model
{
    protected $table = "horas_efectivas";
    protected $fillable = ['numOrden', 'fecha', 'y1_dia','y2_dia', 'y1_noche', 'y2_noche', 'estado' ];
    public $timestamps = false;

}

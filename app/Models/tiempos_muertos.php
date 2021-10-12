<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tiempos_muertos extends Model
{
    protected $table = "tiempos_muertos";
    protected $fillable = ['id', 'numOrden', 'fecha', 'y1_dia','y2_dia', 'y1_noche', 'y2_noche'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class consumo_agua extends Model
{
    protected $table = "consumo_agua";
    protected $fillable = ['id','inicial','final','numOrden'];
    public $timestamps = false;
}

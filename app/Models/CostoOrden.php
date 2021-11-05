<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostoOrden extends Model
{
    protected $table = "costo_orden";
    protected $fillable = ['numOrden', 'costo_id','cantidad','costo_unitario'];
    public $timestamps = false;
}

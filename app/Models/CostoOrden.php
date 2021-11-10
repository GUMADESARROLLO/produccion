<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostoOrden extends Model
{
    public $timestamps = false;
    protected $table = "costo_orden";
    protected $fillable = ['numOrden', 'costo_id', 'cantidad', 'costo_unitario'];
}

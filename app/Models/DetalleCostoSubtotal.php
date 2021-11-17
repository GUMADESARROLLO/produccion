<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCostoSubtotal extends Model
{
    public $timestamps = false;
    protected $table = "inn_costo_orden_subtotal";
   // protected $fillable = ['numOrden', 'costo_id', 'cantidad', 'costo_unitario'];
}
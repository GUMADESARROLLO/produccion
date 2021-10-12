<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inventario_solicitud extends Model
{
    protected $table = "inventario_solicitud";
    protected $fillable = ['id','idFibra','cantidad','numOrden'];
    public $timestamps = false;
}

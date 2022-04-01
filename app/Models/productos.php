<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class productos extends Model
{
    protected $table = "productos";
    protected $primaryKey = 'idProducto';
    protected $fillable = ['codigo', 'nombre', 'descripcion', 'unidad', 'estado'];
    //protected $guarded = ['idProducto'];
    public $timestamps = false;
}

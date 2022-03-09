<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class pc_productos_ordenes extends Model{

    protected $table = "pc_ordenes_produccion";
    protected $fillable = ['articulo','descripcion_corta','id_producto','tipo'];
    public    $timestamps = false;

}
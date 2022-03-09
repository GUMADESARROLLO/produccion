<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class pc_requisado_detalles extends Model{

    protected $table = "pc_requisado_detalles";
    protected $fillable = ['numOrden','id_articulos','cantidad','tipo'];
    public    $timestamps = false;

}
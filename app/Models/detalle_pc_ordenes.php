<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;


class detalle_pc_ordenes extends Model
{
    public $timestamps = false;
    protected $table = "view_proceso_seco_ordenes_produccion";

    public static function getOrdenes($from, $to){
        return detalle_pc_ordenes::whereBetween('fecha_hora_inicio', [$from, $to])->get();
    }
    


}

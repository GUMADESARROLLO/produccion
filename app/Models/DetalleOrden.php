<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DetalleOrden extends Model
{
    public $timestamps = false;
    protected $table = "inn_home_details_orden_prod";
   // protected $fillable = ['numOrden', 'costo_id', 'cantidad', 'costo_unitario'];

    public static function getOrdenes($from,$to){

    $items_productos = DB::table('inn_home_details_orden_prod')->whereBetween('fechaInicio', [$from, $to])->get();    
    $json = array();
    $i = 0;

    if( count($items_productos)>0 ){
        foreach ($items_productos as $key => $value) {

            $json[$i]['numOrden']           = $value->numOrden;
            $json[$i]['nombre']             = $value->nombre;
            $json[$i]['fechaInicio']        = $value->fechaInicio;
            $json[$i]['fechaFinal']         = $value->fechaFinal;
            $json[$i]['prod_real']          = $value->prod_real;
            $json[$i]['prod_total']         = $value->prod_total;
            $json[$i]['prod_real_ton']      = $value->prod_total /100;
            $json[$i]['costo_total']        = $value->costo_total;
            $json[$i]['tipo_cambio']        = $value->tipo_cambio;
            $json[$i]['costo_total_dolar']  = $value->costo_total_dolar;
            
            $i++;
        }
    }

    return $json;
}
}

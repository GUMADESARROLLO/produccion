<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostoOrden extends Model
{
    public $timestamps = false;
    protected $table = "costo_orden";
    protected $fillable = ['numOrden', 'costo_id', 'cantidad', 'costo_unitario'];

    public static function getCostoOrden()
    {
        $array = array();
        $i = 0;
        $ord_produccion = orden_produccion::where('estado', 1)->orderBy('numOrden', 'desc')->get();

        if (count($ord_produccion) > 0) {
            foreach ($ord_produccion as $key) {
                $array[$i]['idOrden'] = $key['idOrden'];
                $array[$i]['numOrden'] = $key['numOrden'];
                $fibra = productos::select('nombre')->where('idProducto', $key['producto'])->get()->first();
                $array[$i]['producto'] = $fibra->nombre;
                $array[$i]['fechaInicio'] = date('d/m/Y', strtotime($key['fechaInicio']));
                $array[$i]['fechaFinal'] = date('d/m/Y', strtotime($key['fechaFinal']));
                $array[$i]['estado'] = $key['estado'];
                $i++;
            }
        }
        // return view('User.CostoOrden.index', compact(['array']));
        return $array;
    }
}

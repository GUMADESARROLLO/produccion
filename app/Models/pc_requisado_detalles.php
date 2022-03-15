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

    public static function guardarRequisado(Request $request){
        if($request->ajax()){
            try {
                //dd($request);
                $requisado = new pc_requisado_detalles();
                $requisado->numOrden = $request->input('numOrden');
                $requisado->id_articulos = $request->input('id_elemento');
                $requisado->cantidad = $request->input('cantidad');
                $requisado->tipo = $request->input('tipo');
                $requisado->save();

            } catch (Exception $e) {
                $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";
                return response()->json($mensaje);
            }
        }
    }

}

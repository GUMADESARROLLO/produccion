<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Arr;

class pc_detalle_tiempos_paro extends Model
{
    protected $table        = "pc_detalle_tiempos_paro";
    protected $fillable     = ['id_tipo_tiempo_paro','num_orden', 'cantidad', 'numero_personas', 'id_turno','id_usuario'];
    public    $timestamps   = false;    
    
    public static function Insertar(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                
                $id_articulo    = $request->input('id_tipo_tiempo_paro');
                $num_orden      = $request->input('num_orden');
                $cantidad       = $request->input('cantidad');
                $idTurno        = $request->input('idturno');

                $id_usuario     = 1;

                $id_exist = DB::table('pc_detalle_tiempos_paro')
                    ->select('id')
                    ->where('num_orden',  $num_orden)
                    ->where('id_tipo_tiempo_paro', $id_articulo)
                    ->where('id_turno', $idTurno)
                    ->get()->first();
                    
                if (!is_null($id_exist)) {
                    $id = $id_exist->id;
                    $response =   pc_detalle_tiempos_paro::where('id',  $id)->update([
                        'cantidad' => $cantidad,
                    ]);
                    return response()->json(1);
                } else {
                    $requisado = new pc_detalle_tiempos_paro();
                    $requisado->id_tipo_tiempo_paro = $id_articulo;
                    $requisado->num_orden           = $num_orden;                
                    $requisado->cantidad            = $cantidad;
                    $requisado->id_turno            = $idTurno;
                    $requisado->id_usuario          = $id_usuario;
                    $requisado->save();

                    return response()->json($requisado);
                }
            });
        } catch (Exception $e) {
            $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";
            return response()->json($mensaje);
        }
    }
}
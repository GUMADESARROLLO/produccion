<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class pc_ordenes_produccion extends Model
{

    protected $table = "pc_ordenes_produccion";
    protected $fillable = ['num_orden', 'id_productor', 'id_jr', 'fecha_hora_inicio', 'fecha_hora_final', 'comentario', 'estado'];
    public    $timestamps = false;

    public static function guardar(Request $request)
    {
        $data = $request->input('data')[0];
        $orden = $request->input('num_orden');

        $ordenExist = pc_ordenes_produccion::where('num_orden', $orden)->where('estado', 'S')->first();

        if ($ordenExist) {
            return 1;
        }
        try {
            DB::transaction(function () use ($data) {
                
                $orden = new pc_ordenes_produccion();

                $dtInit = date('Y-m-d h:i:s', strtotime($data['fecha_hora_inicio']));        
                
                $orden->num_orden          =   $data['num_orden'];
                $orden->id_productor       =   $data['id_productor'];
                $orden->id_jr              =   $data['id_jr'];
                $orden->fecha_hora_inicio  =   $dtInit;
                $orden->fecha_hora_final   =   $dtInit;
                $orden->estado             =   'S';
                $orden->save();

                return response()->json($orden);
            });
        } catch (Exception $e) {
            $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";

            return response()->json($mensaje);
        }
    }

    public static function eliminar(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $id = $request->input('id');
                $ordenes =   pc_ordenes_produccion::where('id',  $id)->update([
                    'estado' => 'N',
                ]);
                return response()->json($ordenes);
            });
        } catch (Exception $e) {
            $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";

            return response()->json($mensaje);
        }
    }

    public static function updateFechafinal(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $num_orden = $request->input('num_orden');
                $fecha_final = $request->input('fecha_final');
                $hora_final = $request->input('hora_final');

                $fecha_hora_final = $fecha_final . ' ' . $hora_final . ':00';

                $ordenes =   pc_ordenes_produccion::where('num_orden',  $num_orden)
                    ->where('estado', 'S')->update([
                        'fecha_hora_final' => $fecha_hora_final,
                    ]);
                return response()->json($ordenes);
            });
        } catch (Exception $e) {
            $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";

            return response()->json($mensaje);
        }
    }

    public static function addComment(Request $request)
    {

        try {
            DB::transaction(function () use ($request) {
                $num_orden   = $request->input('num_orden');
                $comentario = $request->input('comentario');


                $ordenes =   pc_ordenes_produccion::where('num_orden',  $num_orden)
                    ->where('estado', 'S')->update([
                        'comentario' => $comentario,
                    ]);
                return response()->json($ordenes);
            });
        } catch (Exception $e) {
            $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";

            return response()->json($mensaje);
        }
    }


    public static function updateFechaInicial(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $num_orden   = $request->input('num_orden');
                $fecha_inicial = $request->input('fecha_inicial');
                $hora_inicial  = $request->input('hora_inicial');

                $fecha_hora_inicio = $fecha_inicial . ' ' . $hora_inicial . ':00';

                $ordenes =   pc_ordenes_produccion::where('num_orden',  $num_orden)
                    ->where('estado', 'S')->update([
                        'fecha_hora_inicio' => $fecha_hora_inicio,
                    ]);
                return response()->json($ordenes);
            });
        } catch (Exception $e) {
            $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";

            return response()->json($mensaje);
        }
    }

}

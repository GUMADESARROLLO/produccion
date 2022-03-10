<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class pc_ordenes_produccion extends Model
{

    protected $table = "pc_ordenes_produccion";
    protected $fillable = ['num_orden', 'id_productor', 'id_jr', 'fecha_hora_inicio', 'fecha_hora_final','estado'];
    public    $timestamps = false;

    public static function guardar($data, $orden)
    {
        $ordenExist = pc_ordenes_produccion::where('num_orden', $orden)->where('estado', 'S')->first();

        if ($ordenExist) {
            return 1;
        }
        try {
            DB::transaction(function () use ($data, $orden) {

                $array = array();
                $i = 0;
                $orden = new pc_ordenes_produccion();

                foreach ($data as $dataO) {
                    $orden->num_orden          =   $dataO['num_orden'];
                    $orden->id_productor       =   $dataO['id_productor'];
                    $orden->id_jr              =   $dataO['id_jr'];
                    $orden->fecha_hora_inicio  =   $dataO['fecha_hora_inicio'];
                    $orden->fecha_hora_final   =   $dataO['fecha_hora_final'];
                    $orden->estado             =   'S';
                    $orden->save();
                };
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
                $ordenes =   pc_ordenes_produccion::where('id',  $id )->update([
                    'estado' => 'N',
                ]);
                return response()->json($ordenes);
            });
        } catch (Exception $e) {
            $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";

            return response()->json($mensaje);
        }
    }

    public static function cambiar_estado(){

    }
}

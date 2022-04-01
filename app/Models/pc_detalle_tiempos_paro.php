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
    protected $fillable     = ['id_tipo_tiempo_paro', 'num_orden', 'cantidad', 'numero_personas', 'id_turno', 'id_usuario'];
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
    public static function GuardarNumeroPersona(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {

                $id_articulo    = $request->input('id_articulo');
                $num_orden      = $request->input('num_orden');
                $cantidad       = $request->input('cantidad');

                $id_usuario     = 1;

                $id_exist = DB::table('pc_detalle_tiempos_paro')
                    ->select('id')
                    ->where('num_orden',  $num_orden)
                    ->where('id_tipo_tiempo_paro', $id_articulo)
                    ->get()->first();

                if (!is_null($id_exist)) {
                    $id = $id_exist->id;
                    $response =   pc_detalle_tiempos_paro::where('id',  $id)->update([
                        'numero_personas' => $cantidad,
                    ]);
                    return response()->json(1);
                } else {
                    $requisado = new pc_detalle_tiempos_paro();
                    $requisado->id_tipo_tiempo_paro = $id_articulo;
                    $requisado->num_orden           = $num_orden;
                    $requisado->numero_personas     = $cantidad;
                    $requisado->id_usuario          = $id_usuario;
                    $requisado->id_turno            = 1;
                    $requisado->save();

                    return response()->json($requisado);
                }
            });
        } catch (Exception $e) {
            $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";
            return response()->json($mensaje);
        }
    }


    public static function  getTiemposParos($num_orden){

        $items_productos = DB::table('pc_tiempos_paros')->where('ACTIVO', 'S')->get();
        $datos_productos = DB::table('view_proceso_seco_detalles_tiempos_paros')->where('num_orden', $num_orden)->get()->toArray();
        $json = array();
        $i = 0;
       // $hrs_total_trabajadas =  $hrs_total_trabajadas*24;
       //var_dump($num_orden);
       //DD($num_orden);
        //DD($datos_productos);

        if( count($items_productos)>0 ){
            foreach ($items_productos as $key => $value) {

                $json[$i]['ID_ROW']        = $value->ID;
                $json[$i]['ARTICULO']           = $value->NOMBRE;
                
               $found_key = array_search($value->ID, array_column($datos_productos, 'id_row'));

             // DD($found_key);
                if ($found_key !== false) {                    
                    $json[$i]['Dia']            = number_format($datos_productos[$found_key]->Dia,2);
                    $json[$i]['Noche']          = number_format($datos_productos[$found_key]->Noche,2);
                    $json[$i]['Total_Hrs']      = number_format($datos_productos[$found_key]->Dia + $datos_productos[$found_key]->Noche,2);
                    $json[$i]['num_personas']   = number_format($datos_productos[$found_key]->Personal_Dia + $datos_productos[$found_key]->Personal_Noche,2);                    
                }else{                    
                    $json[$i]['Dia']            = number_format(0.00,2);
                    $json[$i]['Noche']          = number_format(0.00,2);
                    $json[$i]['Total_Hrs']      = number_format(0.00,2);
                    $json[$i]['num_personas']   = number_format(0.00,2);
                }
                
                $i++;
            }
        }

        return $json;
    }
}

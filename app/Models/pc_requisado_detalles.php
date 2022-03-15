<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Arr;

class pc_requisado_detalles extends Model
{

    protected $table = "pc_requisado_detalles";
    protected $fillable = ['num_orden', 'id_articulos', 'cantidad', 'tipo'];
    public    $timestamps = false;

    public static function actualizarCantidad(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {

                $num_orden   = $request->input('num_orden');
                $id_articulo = $request->input('id_articulo');
                $cantidad    = $request->input('cantidad');
                $tipo        = 5;


                $id_exist = DB::table('pc_requisado_detalles')
                    ->select('id')
                    ->where('num_orden',  $num_orden)
                    ->where('id_articulos', $id_articulo)->get()->first();
                //   pc_requisado_detalles::select(DB::raw('id'))->where('num_orden',  $num_orden)->where('id_articulos', $id_articulo)->get()->first();
                // echo $id_exist;
                // var_dump( $id);
                if (!is_null($id_exist)) {
                    $id = $id_exist->id;
                    $response =   pc_requisado_detalles::where('id',  $id)->update([
                        'cantidad' => $cantidad,
                    ]);
                    return response()->json(1);
                } else {
                    $requisa = new pc_requisado_detalles();
                    $requisa->num_orden          =   $num_orden;
                    $requisa->id_articulos       =   $id_articulo;
                    $requisa->cantidad           =   $cantidad;
                    $requisa->tipo               =   $tipo;
                    $requisa->save();

                    return response()->json($requisa);
                }
            });
        } catch (Exception $e) {
            $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";

            return response()->json($mensaje);
        }
    }
    public static function guardarRequisado(Request $request)
    {
        if ($request->ajax()) {
            try {
                //dd($request);
                $requisado = new pc_requisado_detalles();
                $requisado->num_orden = $request->input('num_orden');
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
    public static function actualizarRequisado(Request $request)
    {
        if ($request->ajax()) {
            try {
                //dd($request);
                $requisado = new pc_requisado_detalles();
                $requisado->num_orden = $request->input('num_orden');
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

    public static function getRequisadosMP($num_orden,  $id_articulo)
    {
        $data = array();
        $i = 0;
        $data = array();
        $requisadoMP = DB::table('pc_requisado_detalles')
            ->where('num_orden',  $num_orden)
            ->where('id_articulos',  $id_articulo)
            ->get();

        if (!is_null($requisadoMP)) {
            foreach ($requisadoMP as $MP  => $value) {
                $data[$i]['id']             =  $value->id;
                $data[$i]['num_orden']      =  $value->num_orden;
                $data[$i]['id_articulos']   =  $value->id_articulos;
                $data[$i]['cantidad']       =  $value->cantidad;
                $data[$i]['tipo']           =  $value->tipo;
                $i++;
            }
            // var_dump($data);
            return $data;
        } else {
            var_dump('Estas en el else');
        }

    }
}

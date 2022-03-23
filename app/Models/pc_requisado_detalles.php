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
    public static function guardarMatP(Request $request) //guarda lp y merma
    {

        if ($request->ajax()) {
            try {
                $data = $request->input('data');
                $response = '';
                foreach ($data as $requisado) {
                    if ($requisado['cantidad'] != '') {
                        $id_exist = DB::table('pc_requisado_detalles') //Confirmar si existe 
                            ->select('id')
                            ->where('num_orden', $requisado['num_orden'])
                            ->where('id_articulos', $requisado['id_articulo'])
                            ->where('tipo', $requisado['tipo'])->get()->first();

                        if (!is_null($id_exist)) {
                            $id = $id_exist->id;
                            $requisa =   pc_requisado_detalles::where('id',  $id_exist->id)->update([
                                'cantidad' => $requisado['cantidad'],
                            ]);
                        } else {
                            $requisa = new pc_requisado_detalles();
                            $requisa->num_orden          =   $requisado['num_orden'];
                            $requisa->id_articulos       =   $requisado['id_articulo'];
                            $requisa->cantidad           =   $requisado['cantidad'];
                            $requisa->tipo               =   $requisado['tipo'];
                            $requisa->created_at         =  date('Y-m-d H:i:s');
                            $requisa->save();
                        }
                    }
                }
                return $requisa;
            } catch (Exception $e) {
                $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";
                return response()->json($mensaje);
            }
        }
    }
    public static function actualizarMP(Request $request)
    {
        if ($request->ajax()) {
            try {

                $requisado = new pc_requisado_detalles();
                $num_orden = $request->input('num_orden');
                $id_articulo = $request->input('id_articulo');
                $id = $request->input('id_requisa');
                $cantidad = $request->input('cantidad');
                $tipo = $request->input('tipo');

                if (!empty($id)) {
                    $response =   pc_requisado_detalles::where('id',  $id)->update([
                        'cantidad' => $cantidad,
                    ]);
                    return response()->json($response);
                } else {
                    $requisado = new pc_requisado_detalles();
                    $requisado->num_orden = $num_orden;
                    $requisado->id_articulos = $id_articulo;
                    $requisado->cantidad = $cantidad;
                    $requisado->tipo = $tipo;
                    $requisado->save();
                    return response()->json($requisado);
                }
            } catch (Exception $e) {
                $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";
                return response()->json($mensaje);
            }
        }
    }

    public static function getRequisadosMP($num_orden, $id_articulo, $tipo)
    {
        $i = 0;
        $data = array();
        setlocale(LC_TIME, "spanish");
        $requisadoMP = DB::table('view_articulos_detalles')
            ->where('num_orden',  $num_orden)
            ->where('ID_ARTICULO',  $id_articulo)
            ->where('ID_TIPO_REQUISA',  $tipo)
            ->get();

        if (!is_null($requisadoMP)) {
            foreach ($requisadoMP as $MP  => $value) { // lp_inicial
                $data[$i]['id']                 =  $value->id;
                $data[$i]['num_orden']          =  $value->num_orden;
                $data[$i]['id_articulos']       =  $value->ID_ARTICULO;
                $data[$i]['articulo']           =  $value->ARTICULO;
                $data[$i]['cantidad']           =  number_format($value->CANTIDAD,2);
                $data[$i]['id_tipo_requisa']    =  $value->ID_TIPO_REQUISA;
                $data[$i]['tipo_requisa']       =  $value->TIPO_REQUISA;
                $data[$i]['fecha_creacion']     =   strftime('%a %d de %b %G', strtotime($value->fecha_creacion)); 
                $i++;
            }
            return $data;
            //    return $data;
        } else {
            return 0;
        }
    }

    public static function getRequisadosAll($num_orden, $id_articulo)
    {
        $requisadoMP = DB::table('view_articulos_detalles')
            ->where('num_orden',  $num_orden)
            ->where('ID_ARTICULO',  $id_articulo)
            ->get();

        return $requisadoMP;
    }

    public static function addRequisa(Request $request)
    {
        if ($request->ajax()) {
            try {
                //dd($request);LlL
                $requisado = new pc_requisado_detalles();
                $requisado->num_orden    = $request->input('num_orden');
                $requisado->id_articulos = $request->input('id_articulo');
                $requisado->cantidad     = $request->input('cantidad');
                $requisado->tipo         = $request->input('tipo');
                $requisado->save();
            } catch (Exception $e) {
                $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";
                return response()->json($mensaje);
            }
        }
    }
    public static function eliminarRequisaPC(Request $request)
    {
        if ($request->ajax()) {
            try {
                //dd($request);
                $id =  $request->input('id');
                $delete = pc_requisado_detalles::where('id', $id )->delete();
                return  $delete;               
            } catch (Exception $e) {
                $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";
                return response()->json($mensaje);
            }
        }
    }
}

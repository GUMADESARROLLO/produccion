<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

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
}

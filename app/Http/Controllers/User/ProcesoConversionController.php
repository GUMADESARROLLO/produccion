<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\detalle_pc_ordenes;
use App\Models\pc_ordenes_produccion;
use App\Models\pc_requisado_detalles;
use App\Models\pc_requisados_tipos;
use App\Models\pc_detalle_tiempos_paro;
use App\Models\ProcesoConversion;
use Exception;
use Illuminate\Http\Request;

class ProcesoConversionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        setlocale(LC_ALL, "es_ES");
    }
    public function index()
    {
        return view('User.Proceso_Conversion.index');
    }

    public function doc($Orden)
    {
        return view('User.Proceso_Conversion.detalle', compact('Orden'));
    }

    public function getOrdenes(Request $request)
    {

        $from   = $request->input('f1') . ' 00:00:00';
        $to     = $request->input('f2') . ' 23:59:59';

        $ordenes = detalle_pc_ordenes::getOrdenes($from, $to);
        return response()->json($ordenes);
    }

    public function guardar(Request $request)
    {
        $orden = pc_ordenes_produccion::guardar($request);
        return response()->json($orden);
    }

    public function eliminar(Request $request)
    {
        $response = pc_ordenes_produccion::eliminar($request);
        return response()->json($response);
    }

    public function jsonInfoOrder($Orden)
    {
        $obj = ProcesoConversion::getJson($Orden);
        
        return response()->json($obj);
    }

    public function datos_detalles($Orden)
    {
        $obj = ProcesoConversion::datos_detalles($Orden);
        return response()->json($obj);
    }


    public function doc_printer($Orden)
    {

        $data_orden = ProcesoConversion::getJson($Orden);

        //$data_orden[0]['data']['jr_total_kg'] = array_sum(array_column($data_orden[1]['data'], 'KG'));  

        $data_orden[0]['data']['jr_total_kg'] = number_format(array_sum(str_replace(['', ',', '.'], ['', '', '.'], array_column($data_orden[1]['data'], 'KG'))), 2, '.', ',');

        $data = [
            'Informacion_Orden' =>  $data_orden[0]['data'],
            'Producto'          =>  $data_orden[1]['data'],
            'Materia_prima'     =>  $data_orden[2]['data'],
            'Tempos_paro'       =>  $data_orden[3]['data'],
        ];

        //dd($data_orden[1]['data']);
        //return view('User.Proceso_Conversion.print', compact('data'));
        $pdf = \PDF::loadView('User.Proceso_Conversion.print', compact('data'));
        return $pdf->download('Orden.pdf');
        //return response()->json($obj);
    }

    public function GuardarNumeroPersona(Request $request)
    {
        $response = pc_detalle_tiempos_paro::GuardarNumeroPersona($request);
        return response()->json($response);
    }

    public function GuardarTiempoParo(Request $request)
    {
        $response = pc_detalle_tiempos_paro::Insertar($request);
        return response()->json($response);
    }
    public function actualizarCantidad(Request $request)
    {
        $response = pc_requisado_detalles::actualizarCantidad($request);
        return response()->json($response);
    }

    public function guardarMatP(Request $request)
    {
        $response = pc_requisado_detalles::guardarMatP($request);
        return response()->json($response);
    }

    public function getRequisados_tipos()
    {
        $requisados = pc_requisados_tipos::getRequisados_tipos();
        return response()->json($requisados);
    }

    public function actualizarRequisado()
    {
        $requisados = pc_requisados_tipos::actualizarRequisado();
        return response()->json($requisados);
    }

    public function getRequisadosMP($numOrden, $articulo, $tipo)
    {
        $requisados = pc_requisado_detalles::getRequisadosMP($numOrden, $articulo, $tipo);
        return response()->json($requisados);
    }

    public function actualizarMP(Request $request)
    {
        $response = pc_requisado_detalles::actualizarMP($request);
        return response()->json($response);
    }

    public function addRequisa(Request $request)
    {
        $response = pc_requisado_detalles::addRequisa($request);
        return response()->json($response);
    }

    public function getRequisadosAll($num_orden, $id_articulo)
    {
        $requisados = pc_requisado_detalles::getRequisadosAll($num_orden, $id_articulo);
        return response()->json($requisados);
    }
    public function eliminarRequisaPC(Request $request)
    {
        $requisados = pc_requisado_detalles::eliminarRequisaPC($request);
        return response()->json($requisados);
    }
    public function updateFechafinal(Request $request)
    {
        $requisados = pc_ordenes_produccion::updateFechafinal($request);
        return response()->json($requisados);
    }

    public function addComment(Request $request)
    {
        $requisados = pc_ordenes_produccion::addComment($request);
        return response()->json($requisados);
    }

    public function updateFechaInicial(Request $request)
    {
        $requisados = pc_ordenes_produccion::updateFechaInicial($request);
        return response()->json($requisados);
    }

    public function getTiemposParos($Orden)
    {
        $response = pc_detalle_tiempos_paro::getTiemposParos($Orden);
        return response()->json($response);
    }
}

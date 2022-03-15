<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\detalle_pc_ordenes;
use App\Models\pc_ordenes_produccion;
use App\Models\pc_requisado_detalles;
use App\Models\pc_requisados_tipos;
use App\Models\ProcesoConversion;
use Exception;
use Illuminate\Http\Request;

class ProcesoConversionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('User.Proceso_Conversion.index');
    }

    public function doc($Orden)
    {
        return view('User.Proceso_Conversion.detalle',compact('Orden'));
    }

    public function getOrdenes(){
        $ordenes = detalle_pc_ordenes::getOrdenes();
        return response()->json($ordenes);
    }

    public function guardar(Request $request)
    {
        $data = $request->input('data');
        $numOrden = $request->input('num_orden');
        $orden = pc_ordenes_produccion::guardar($data, $numOrden);
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

    public function doc_printer($Orden){        
        
        $data_orden = ProcesoConversion::getJson($Orden);

        //$data_orden[0]['data']['jr_total_kg'] = array_sum(array_column($data_orden[1]['data'], 'KG'));  

        $data_orden[0]['data']['jr_total_kg'] = number_format(array_sum( str_replace(['', ',', '.'], ['', '', '.'],array_column($data_orden[1]['data'], 'KG')) ),2, '.', ',');
        
        $data = [
            'Informacion_Orden' =>  $data_orden[0]['data'],
            'Producto'          =>  $data_orden[1]['data'],
            'Materia_prima'     =>  $data_orden[2]['data'],
        ];
        
        //dd($data_orden[1]['data']);
        //return view('User.Proceso_Conversion.print', compact('data'));
        $pdf = \PDF::loadView('User.Proceso_Conversion.print', compact('data'));
        return $pdf->download('Orden.pdf');
        //return response()->json($obj);
    }
    

    public function actualizarCantidad(Request $request)
    {
        $response = pc_requisado_detalles::actualizarCantidad($request);
        return response()->json($response);
    }

    public function guardarMatP(Request $request)
    {
        $response = pc_requisado_detalles::guardarRequisado($request);
        return response()->json($response);
    }

    public function getRequisados(){
        $requisados = pc_requisados_tipos::getRequisados();
        return response()->json($requisados);
    }

    public function actualizarRequisado(){
        $requisados = pc_requisados_tipos::actualizarRequisado();
        return response()->json($requisados);
    }

    public function getRequisadosMP($numOrden,$articulo){
        $requisados = pc_requisado_detalles::getRequisadosMP($numOrden,$articulo);
        return response()->json($requisados);
    }


    
    
}

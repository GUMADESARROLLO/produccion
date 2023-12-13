<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\detalle_pc_ordenes;
use App\Models\orden_produccion;
use App\Models\DetalleOrden;
use App\Models\Logs_access;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        setlocale(LC_ALL, "es_ES");
    }
    public function index()
    {
        Logs_access::add("DashBoard");

        return view('User.Dashboard.index');

       
    }
    public function getDetalles(Request $request)
    {

        $from   = $request->input('f1') . ' 00:00:00';
        $to     = $request->input('f2') . ' 23:59:59';

        $ord_humedo         = DetalleOrden::getOrdenes($from, $to);

        $ord_conversion     = detalle_pc_ordenes::getOrdenes($from, $to);
        $hrs_humedo         = DetalleOrden::whereBetween('fechaInicio', [$from, $to])->sum('hrsTrabajadas');
        $hrs_conversion     = detalle_pc_ordenes::whereBetween('fecha_hora_inicio', [$from, $to])->sum('Hrs_trabajadas');


        $costo_tt           = DetalleOrden::whereBetween('fechaInicio', [$from, $to])->sum('costo_total');
        $costo_tt_dolar     = DetalleOrden::whereBetween('fechaInicio', [$from, $to])->sum('costo_total_dolar');
        
        $dt_costo           = DB::table("inn_home_details_orden_prod")
                                ->select(DB::raw(" SUM(ifnull((( costo_total / tipo_cambio ) / (( prod_real + merma_total ) / 1000 )), 0 )) AS costo_real_tonelada_mensual"))
                                ->whereBetween('fechaInicio',[$from, $to])
                                ->get();

        $costo_tt_dlr_ton   = $dt_costo[0]->costo_real_tonelada_mensual;

        $pro_real           = DetalleOrden::whereBetween('fechaInicio', [$from, $to])->sum('prod_real');
        $pro_total          = DetalleOrden::whereBetween('fechaInicio', [$from, $to])->sum('prod_total');


        $dt_jr              = DB::table("view_proceso_seco_ordenes_produccion")
                                ->select(DB::raw("sum(TOTAL_BULTOS_UNDS * FORMAT(PESO_PORCENT,2)) AS TOTAL_BULTOS_UNDS"))
                                ->whereBetween('fecha_hora_inicio',[$from, $to])
                                ->get();

        $dt_tt_jr           = $dt_jr[0]->TOTAL_BULTOS_UNDS;
        $dt_tt_bultos       = detalle_pc_ordenes::whereBetween('fecha_hora_inicio', [$from, $to])->sum('TOTAL_BULTOS_UNDS');




        $arry_hrs_trabajadas    = array(
                                    'Humedo'        => $hrs_humedo,
                                    'Conversion'    => $hrs_conversion
                                );

        $arry_costos            = array(
                                    'costo_tt'          => $costo_tt,
                                    'costo_tt_dolar'    => $costo_tt_dolar,
                                    'costo_tt_dlr_ton'  => $costo_tt_dlr_ton
                                );
                                
        $arry_prod              = array(
                                    'pro_real'      => $pro_real,
                                    'pro_total'     => $pro_total
                                );

        $arry_conver            = array(
                                    'dt_tt_jr'      => $dt_tt_jr,
                                    'dt_tt_bul'     => $dt_tt_bultos
                                );
        


        $dtaHorasTrabajadas[] = array(
            'tipo' => 'dtaHorasTrabajadas',
            'data' => $arry_hrs_trabajadas
        );

        $dtaCostosTotales[] = array(
            'tipo' => 'dtaCostosTotales',
            'data' => $arry_costos
        );

        $dtaResumenProcesoHumedo[] = array(
            'tipo' => 'dtaResumenProcesoHumedo',
            'data' => $arry_prod
        );

        $dtaResumenConversion[] = array(
            'tipo' => 'dtaResumenConversion',
            'data' => $arry_conver
        );

        $dtaOrdenesHumedo[] = array(
            'tipo' => 'dtaOrdenesHumedo',
            'data' => $ord_humedo
        );

        $dtaConversion[] = array(
            'tipo' => 'dtaConversion',
            'data' => $ord_conversion
        );

        $array_merge = array_merge($dtaHorasTrabajadas,$dtaCostosTotales,$dtaResumenProcesoHumedo,$dtaResumenConversion,$dtaOrdenesHumedo, $dtaConversion);

        return response()->json($array_merge);
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ConsumoGas;
use Illuminate\Http\Request;
use App\Models\orden_produccion;
use App\Models\tiempo_pulpeo;
use App\Models\tiempo_lavado;
use App\Models\tiempos_muertos;
use App\Models\Turno;
use App\Models\productos;
use App\Models\electricidad;
use App\Models\consumo_agua;
use App\Models\jumboroll;
use App\Models\fibras;
use App\Models\inventario_solicitud;
use App\Models\jumboroll_detalle;
use App\Models\horas_efectivas;
use App\Models\Admin\usuario;
use App\Models\Logs_access;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;


class reporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $array = array();
        $i = 0;
        $orden = orden_produccion::where('estado', 1)->get()->first();
        $producto = productos::where('idProducto', $orden->producto)->get()->first();
        $tiempoPulpeo = tiempo_pulpeo::where('numOrden', $orden->numOrden)->orderBy('fecha', 'asc')->get();
        $tiempoLavado = tiempo_lavado::where('numOrden', $orden->numOrden)->orderBy('fecha', 'asc')->get();
        $t_muerto = tiempos_muertos::where('numOrden', $orden->numOrden)->orderBy('fecha', 'asc')->get();
        $productos = productos::where('estado', 1)->get();
        $turnos = Turno::where('estado', 1)->orderBy('horaInicio', 'asc')->get();
        $pulpeo = tiempo_pulpeo::where('numOrden', $orden->numOrden)->distinct()->get()->first();
        $lavado = tiempo_lavado::where('numOrden', $orden->numOrden)->distinct()->get()->first();
        $consumo_agua = consumo_agua::where('numOrden', $orden->numOrden)->get()->first();
        $electricidad = electricidad::where('numOrden', $orden->numOrden)->get()->first();
        $consumo_gas = ConsumoGas::where('numOrden', $orden->numOrden)->get()->first();
        $jumboroll = jumboroll::where('numOrden', $orden->numOrden)->where('idTurno', $turnos[0]['idTurno'])->get();
        $jumborollDT = jumboroll::where('numOrden', $orden->numOrden)->distinct()->get()->first();

        $usuarios   = usuario::usuarioByRole();

        return view('User.Reporte.index', compact([
            'orden', 'tiempoPulpeo', 'tiempoLavado', 'lavado', 'pulpeo', 't_muerto',
            'usuarios', 'turnos', 'productos', 'producto', 'jumboroll', 'jumborollDT', 'consumo_agua', 'consumo_gas', 'electricidad'
        ]));
    }

    public function reporte($numOrden)
    {
        Logs_access::add("orden-produccion/reporte");

        $array = array();
        $i = 0;
        $orden = orden_produccion::where('numOrden', $numOrden)->get()->first();
        $producto = productos::where('idProducto', $orden->producto)->get()->first();
        $tiempoPulpeo = tiempo_pulpeo::where('numOrden', $orden->numOrden)->orderBy('fecha', 'asc')->get();
        $tiempoLavado = tiempo_lavado::where('numOrden', $orden->numOrden)->orderBy('fecha', 'asc')->get();
        $t_muerto = tiempos_muertos::where('numOrden', $orden->numOrden)->orderBy('fecha', 'asc')->get();
        $productos = productos::where('estado', 1)->get();
        $turnos = Turno::where('estado', 1)->orderBy('horaInicio', 'asc')->get();
        $pulpeo = tiempo_pulpeo::where('numOrden', $orden->numOrden)->distinct()->get()->first();
        $lavado = tiempo_lavado::where('numOrden', $orden->numOrden)->distinct()->get()->first();
        $consumo_agua = consumo_agua::where('numOrden', $orden->numOrden)->get()->first();
        $electricidad = electricidad::where('numOrden', $orden->numOrden)->get()->first();
        $consumo_gas = ConsumoGas::where('numOrden', $orden->numOrden)->get()->first();
        $jumboroll = jumboroll::where('numOrden', $orden->numOrden)->where('idTurno', $turnos[0]['idTurno'])->get();

        $jumborollDT = jumboroll::where('numOrden', $orden->numOrden)->get();
        $usuarios   = usuario::usuarioByRole();

        $hrasEfectivas = horas_efectivas::where('numOrden', $orden->numOrden)->get();
        $yk_hrasEftvs = horas_efectivas::calcularHrasEftvs($numOrden);

        return view('User.Reporte.index', compact([
            'orden', 'tiempoPulpeo', 'tiempoLavado', 'lavado', 'pulpeo', 't_muerto',
            'usuarios', 'turnos', 'productos', 'producto', 'jumboroll', 'jumborollDT',
            'consumo_agua', 'consumo_gas', 'electricidad', 'hrasEfectivas', 'yk_hrasEftvs'
        ]));
    }

    public function guardarTiempoPulpeo(Request $request)
    {
        $i = 0;
        $numOrden = $request->input('codigo');

        tiempo_pulpeo::where('numOrden', $numOrden)->delete();

        if ($request->isMethod('post')) {
            $array = array();
            foreach ($request->input('data') as $key) {
                $array[$i]['numOrden']      = $key['orden'];
                $array[$i]['tiempoPulpeo']  = $key['tiempo_pulpeo'];
                $array[$i]['fecha']         = date('Y-m-d', strtotime($key['fecha']));
                $array[$i]['cant_dia']      = $key['dia'];
                $array[$i]['cant_noche']    = $key['noche'];
                $i++;
            }

            $response = tiempo_pulpeo::insert($array);

            return response()->json(true);
        }
    }

    public function guardarTiempoLavado(Request $request)
    {
        $i = 0;
        $numOrden = $request->input('codigo');

        tiempo_lavado::where('numOrden', $numOrden)->delete();

        if ($request->isMethod('post')) {
            $array = array();
            foreach ($request->input('data') as $key) {
                $array[$i]['numOrden']      = $key['orden'];
                $array[$i]['tiempoLavado']  = $key['tiempo_lavado'];
                $array[$i]['fecha']         = date('Y-m-d', strtotime($key['fecha']));
                $array[$i]['cant_dia']      = $key['dia'];
                $array[$i]['cant_noche']    = $key['noche'];
                $i++;
            }

            $response = tiempo_lavado::insert($array);

            return response()->json(true);
        }
    }

    public function guardarTiemposMuertos(Request $request)
    {
        $i = 0;
        $numOrden = $request->input('codigo');

        tiempos_muertos::where('numOrden', $numOrden)->delete();

        if ($request->isMethod('post')) {
            $array = array();
            foreach ($request->input('data') as $key) {
                $array[$i]['numOrden']      = $key['orden'];
                $array[$i]['fecha']         = date('Y-m-d', strtotime($key['dia']));
                $array[$i]['y1_dia']        = $key['y1M'];
                $array[$i]['y2_dia']        = $key['y2M'];
                $array[$i]['y1_noche']      = $key['y1N'];
                $array[$i]['y2_noche']      = $key['y2N'];
                $i++;
            }

            $response = tiempos_muertos::insert($array);

            return response()->json($response);
        }
    }

    public function guardarInventario(Request $request)
    {
        if ($request->isMethod('post')) {
            $numOrden = $request->input('codigo');
            $fibra = $request->input('fibra');
            $cantidad = $request->input('cantidad');

            $inv_sol = new inventario_solicitud();
            $inv_sol->numOrden    = $numOrden;
            $inv_sol->idFibra = $fibra;
            $inv_sol->cantidad  = $cantidad;
            $inv_sol->save();

            return response()->json(true);
        }
    }

    public function guardarInventarioAjax(Request $request)
    {
        $array = array();
        $i = 0;
        if ($request->isMethod('post')) {
            $data = $request->input('data');
            $codigo = $request->input('codigo');

            inventario_solicitud::where('numOrden', $codigo)->delete();

            foreach ($data as $key) {
                $idFibra = fibras::select('idFibra')->where('descripcion', $key['fibra'])->get()->first();
                $numOrden = $key['codigo'];



                foreach ($key['cantidades'] as $k => $value) {

                    $inv_sol = new inventario_solicitud();

                    $inv_sol->numOrden    = $numOrden;
                    $inv_sol->idFibra = $idFibra->idFibra;
                    $inv_sol->cantidad  = floatval($value);
                    $inv_sol->save();
                }
            }


            return response()->json($array);
        }
    }

    public function getDataInventario($numOrden)
    {
        $fibras = fibras::where('estado', 1)->get()->toArray();
        $data = array();
        $columns = 0;
        $i = 0;

        foreach ($fibras as $key) {
            $inventario = inventario_solicitud::where('idFibra', $key['idFibra'])->where('numOrden', $numOrden)->get()->toArray();

            if (count($inventario) > 0) {
                if ((count($inventario) > $columns)) {
                    $columns = count($inventario);
                }
            }
        }

        foreach ($fibras as $key) {
            $inventario = inventario_solicitud::where('idFibra', $key['idFibra'])->where('numOrden', $numOrden)->orderBy('id', 'asc')->get()->toArray();

            if (count($inventario) > 0) {
                $data[$i]['fibra'] = $key['descripcion'];
                $data[$i]['data'] = $inventario;
                $data[$i]['columns'] = $columns;
                $i++;
            }
        }

        return response()->json($data);
    }

    public function guardarJumboRoll(Request $request)
    {
        $id = 0;
        $i = 0;
        $numOrden = $request->input('codigo'); // numero de orden

        $orden = orden_produccion::where([['numOrden', $request->input('codigo')], ['estado', 1]])->orderBy('idOrden', 'asc')->get();
        $fechaInicio = date('Y-m-d');
        $fechaFinal =  date('Y-m-d');
        $idTurno = 0;
        $idJefe = 0;

        $validate = jumboroll::where('numOrden', $numOrden)->get();
        if ($request->isMethod('post')) {

            if (count($validate) > 0) {

                $jumboroll_ = jumboroll::select('id')->where('numOrden', $numOrden)->get()->first();
                $id = $jumboroll_->id;

                jumboroll_detalle::where('idJumboroll', $id)->delete();

                foreach ($request->input('data') as $key) {
                    $array[$i]['vinieta']       = $key['vinieta'];
                    $array[$i]['kg']            = $key['kg'];
                    $array[$i]['gsm']           = $key['gsm'];
                    $array[$i]['yankee']        = $key['yankee'];
                    $array[$i]['idJumboroll']   = $id;
                    $i++;
                }

                $response = jumboroll_detalle::insert($array);
            } else {
                //echo'estoy en el else';
                $jumboroll = new jumboroll();
                $jumboroll->numOrden    = $numOrden;
                $jumboroll->fechaInicio = $fechaInicio;
                $jumboroll->fechaFinal  = $fechaFinal;
                /*$jumboroll->residuo_pulper =        '';
                $jumboroll->lavadora_tetrapack =    '';
                $jumboroll->merma_yankee_dry_1 =    '';
                $jumboroll->merma_yankee_dry_2 =    '';*/
                $jumboroll->idTurno     = $idTurno;
                $jumboroll->idUsuario   = $idJefe;
                $jumboroll->save();

                //$id = jumboroll::latest('id')->first();
                $jumboroll_ = jumboroll::select('id')->where('numOrden', $numOrden)->get()->first();
                $id = $jumboroll_->id;

                foreach ($request->input('data') as $key) {
                    $array[$i]['vinieta']       = $key['vinieta'];
                    $array[$i]['kg']            = $key['kg'];
                    $array[$i]['gsm']           = $key['gsm'];
                    $array[$i]['yankee']        = $key['yankee'];
                    $array[$i]['idJumboroll']   = $id;
                    $i++;
                }

                $response = jumboroll_detalle::insert($array);
            }
        }
    }

    public function eliminarTiempoPulpeo(Request $request)
    {
        $id = $request->input('id');

        $response = tiempo_pulpeo::where('id', $id)->delete();

        return response()->json($response);
    }

    public function eliminarTiempoLavado(Request $request)
    {
        $id = $request->input('id');

        $response = tiempo_lavado::where('id', $id)->delete();

        return response()->json($response);
    }

    public function eliminarTiemposMuertos(Request $request)
    {
        $id = $request->input('id');

        $response = tiempos_muertos::where('id', $id)->delete();

        return response()->json($response);
    }

    public function eliminarVinietaJRoll(Request $request)
    {
        $id = $request->input('id');

        $response = jumboroll_detalle::where('id', $id)->delete();

        return response()->json($response);
    }

    public function getDataJumboRoll($idTurno, $codigo)
    {
        $data = jumboroll_detalle::select('jumboroll.*', 'jumboroll_detalle.id', 'jumboroll_detalle.vinieta', 'jumboroll_detalle.kg', 'jumboroll_detalle.gsm', 'jumboroll_detalle.yankee')
            ->join('jumboroll', 'jumboroll_detalle.idJumboroll', '=', 'jumboroll.id')
            ->where('jumboroll.idTurno', $idTurno)
            ->where('jumboroll.numOrden', $codigo)
            ->orderBy('jumboroll_detalle.id', 'asc')
            ->get();

        return response()->json($data);
    }

    public function guardarDetailJR(Request $request)
    {
        $numOrden = $request->input('codigo');
        $validate = jumboroll::where('numOrden', $numOrden)->get();

        if ($request->isMethod('post')) {
            $resPulper      = floatval($request->input('resPulper'));
            $lavTetrapack   = floatval($request->input('lavTetrapack'));
            $mermaYDRY1     = floatval($request->input('mermaYDRY1'));
            $mermaYDRY2     = floatval($request->input('mermaYDRY2'));
            if (count($validate) > 0) {
                $response = jumboroll::where('numOrden', $numOrden)
                    ->update([
                        'residuo_pulper'        => $resPulper,
                        'lavadora_tetrapack'    => $lavTetrapack,
                        'merma_yankee_dry_1'    => $mermaYDRY1,
                        'merma_yankee_dry_2'    => $mermaYDRY2
                    ]);
            } else {
                $jumboroll = new jumboroll();
                $jumboroll->numOrden    = $numOrden;
                $jumboroll->fechaInicio = date('Y-m-d');
                $jumboroll->fechaFinal  = date('Y-m-d');
                $jumboroll->residuo_pulper =        $resPulper;
                $jumboroll->lavadora_tetrapack =    $lavTetrapack;
                $jumboroll->merma_yankee_dry_1 =    $mermaYDRY1;
                $jumboroll->merma_yankee_dry_2 =    $mermaYDRY2;
                $jumboroll->idTurno     = 0;
                $jumboroll->idUsuario   = 0;
                $response = $jumboroll->save();
            }
        }

        return response()->json($response);
    }

    public function getDataJRDetail($codigo)
    {

        $data = jumboroll::where('numOrden', $codigo)->get();
        return response()->json($data);
    }

    public function guardarhrasEft(Request $request)
    {
        $i = 0;
        $numOrden = $request->input('codigo');
        //$id = intval($request->input('id'));

        $response = '';
        if ($request->isMethod('post')) {
            $array = array();
            foreach ($request->input('data') as $key) {
                $hras_eftv_exist = horas_efectivas::where([['id', $key['id']], ['numOrden', $numOrden]])->get(); //->toArray();
                   if (count($hras_eftv_exist) > 0) {
                    $response = horas_efectivas::where('id', $key['id'])->update([
                        'numOrden'      => $key['orden'],
                        'fecha'         => date('Y-m-d', strtotime($key['dia'])),
                        'y1_dia'        => date('H:i:s', strtotime($key['y1M'])),
                        'y2_dia'        => date('H:i:s',strtotime($key['y2M'])),
                        'y1_noche'      => date('H:i:s',strtotime($key['y1N'])),
                        'y2_noche'      => date('H:i:s', strtotime($key['y2N'])),
                        'estado'        => 1,
                        'updated_at'     => date('Y-m-d H:i:s')
                    ]);
                } else {

                    $array[$i]['numOrden']      = $key['orden'];
                    $array[$i]['fecha']         = date('Y-m-d', strtotime($key['dia']));
                    $array[$i]['y1_dia']        = $key['y1M'];
                    $array[$i]['y2_dia']        = $key['y2M'];
                    $array[$i]['y1_noche']      = $key['y1N'];
                    $array[$i]['y2_noche']      = $key['y2N'];
                    $array[$i]['estado']        = 1;
                    $array[$i]['created_at']     = date('Y-m-d H:i:s');
                    $i++;
                }
            }
            if(count($array)>0){
                $response = horas_efectivas::insert($array);
                return response()->json($response);
            }
        }
    }

    public function eliminarHrasEft(Request $request)
    {
        $id = intval($request->input('id'));

        $response = horas_efectivas::where('id', $id)->update([
            'estado'        => 0,
            'updated_at'     => date('Y-m-d H:i:s')
        ]);

        return response()->json($response);
    }
}

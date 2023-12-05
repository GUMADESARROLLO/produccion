<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\actividad;
use App\Models\Admin\usuario;
use App\Models\consumo_agua;
use App\Models\ConsumoGas;
use App\Models\costoIndirecto;
use App\Models\DetalleProduccion;
use App\Models\electricidad;
use App\Models\fibras;
use App\Models\horas_efectivas;
use App\Models\jumboroll;
use App\Models\jumboroll_detalle;
use App\Models\manoObra;
use App\Models\maquinas;
use App\Models\mp_directa;
use App\Models\orden_produccion;
use App\Models\productos;
use App\Models\QuimicoMaquina;
use App\Models\Quimicos;
use App\Models\tiempo_lavado;
use App\Models\tiempo_pulpeo;
use App\Models\tiempos_muertos;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use \Carbon\Carbon;
use Exception;

class OrdenProduccionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $array = array();
        $i = 0;
        $ord_produccion = orden_produccion::where('estado', 1)->orderBy('numOrden', 'DESC')->get();

        if (count($ord_produccion) > 0) {
            foreach ($ord_produccion as $key) {
                $array[$i]['idOrden'] = $key['idOrden'];
                $array[$i]['numOrden'] = $key['numOrden'];
                $fibra = productos::select('nombre')->where('idProducto', $key['producto'])->get()->first();
                $array[$i]['producto'] = $fibra->nombre;

                /** Produccion Real **/
                $detalle_prod_real = DetalleProduccion::select('prod_real')->where('numOrden', $key['numOrden'])->get()->first();

                if (is_null($detalle_prod_real) || $detalle_prod_real === '') {
                    $array[$i]['prod_real'] = 0;
                    $prod_real              = 0;
                    $merma_total            = 0;
                } else {
                    $array[$i]['prod_real'] = $detalle_prod_real->prod_real;
                    $prod_real              = $detalle_prod_real['prod_real'];
                    $merma_total            = $detalle_prod_real['merma_total'];
                }

                /** Merma Total **/
                $detalle_merma_total = DetalleProduccion::select('merma_total')->where('numOrden', $key['numOrden'])->get()->first();
                if (is_null($detalle_merma_total) || $detalle_merma_total == '') {
                    $array[$i]['merma_total'] = 0;
                } else {
                    $array[$i]['merma_total'] = $detalle_merma_total->merma_total;
                }

                $array[$i]['prod_total'] = $prod_real + $merma_total;

                $array[$i]['fechaInicio'] = date('d/m/Y', strtotime($key['fechaInicio']));
                $array[$i]['fechaFinal'] = date('d/m/Y', strtotime($key['fechaFinal']));
                $array[$i]['estado'] = $key['estado'];
                $i++;
            }
        }
        return view('User.Orden_Produccion.index', compact(['array']));
    }


    public function detalle($idOP)
    {
        $array = array();
        $i = 0;

        $mo_directa = $this->calcularManoObraDirecta($idOP);
        $yk_hrasEftvs = horas_efectivas::calcularHrasEftvs($idOP);

        $ord_produccion = orden_produccion::where('numOrden', $idOP)->get()->first();
        $producto = productos::select('nombre')->where('idProducto', $ord_produccion->producto)->get()->first();
        $usuario = usuario::select('nombres', 'apellidos')->where('id', $ord_produccion->idUsuario)->get()->first();
        $idTetra = fibras::select('idFibra')->where('descripcion', 'like', '%Tetrapack%')->get()->first();

        $mp_directa = mp_directa::select('mp_directa.*', 'fibras.descripcion', 'maquinas.nombre')
            ->join('fibras', 'mp_directa.idFibra', '=', 'fibras.idFibra')
            ->join('maquinas', 'mp_directa.idMaquina', '=', 'maquinas.idMaquina')
            ->where('mp_directa.numOrden', $idOP)
            ->get();

        $totalMPTPACK = mp_directa::select(DB::raw('SUM(cantidad) as total'))
            ->where('idFibra', $idTetra->idFibra)
            ->where('numOrden', $idOP)
            ->get()->first();

        $quimico_maquina = QuimicoMaquina::select('quimico_maquina.*', 'quimicos.descripcion', 'maquinas.nombre')
            ->join('quimicos', 'quimico_maquina.idQuimico', '=', 'quimicos.idQuimico')
            ->join('maquinas', 'quimico_maquina.idMaquina', '=', 'maquinas.idMaquina')
            ->where('quimico_maquina.numOrden', $idOP)
            ->get();

        
        $horas_efectivas = horas_efectivas::where('numOrden', $idOP);

        if (count($mp_directa) > 0 && $totalMPTPACK->total != '') {
            $produccionNeta = $this->calcularProduccionNeta($idOP);
            $mermaYankeeDry = $this->calcularMermaYankeeDry($idOP);
            $residuosPulper = $this->calcularResiduosPulper($idOP);
            $lavadoraTetrapack = $this->calcularLavadoraTetrapack($idOP);
            $totalMP = $this->calcularTotalMP($idOP);
            $electricidad = $this->calcularElectricidad($idOP);
            $consumo_agua = $this->calcularConsumoAgua($idOP);
            $consumo_gas = $this->calcularConsumoGas($idOP);
            $produccion_total = $mermaYankeeDry->merma + $produccionNeta->produccionNeta;

            if ($produccion_total == 0 || $produccion_total == '') {
                $estandar_electricidad = 0;
                $estandar_gas = 0;
            } else {
                $estandar_electricidad = ($electricidad['totalProcesoH'] / $produccion_total) * 1000;
                $estandar_gas = ($consumo_gas['total'] / $produccion_total) * 1000;
            }
            $Tonelada_dia = (($mermaYankeeDry->merma > 0 && $produccionNeta->produccionNeta > 0 && $ord_produccion->hrsTrabajadas>0)?
                            number_format(($produccionNeta->produccionNeta / ($ord_produccion->hrsTrabajadas / 24)) / 1000, 2): 0);

            if ($mermaYankeeDry->merma > 0 && $produccionNeta->produccionNeta > 0) {
                $porcentMermaYankeeDry = ($mermaYankeeDry->merma / ($produccionNeta->produccionNeta + $mermaYankeeDry->merma)) * 100;

            } else {
                $porcentMermaYankeeDry = 0;
            }
            if ($lavadoraTetrapack->lav_tetrapack > 0 && $totalMPTPACK->total > 0) {
                $porcentLavadoraTetrapack = ($lavadoraTetrapack->lav_tetrapack / $totalMPTPACK->total) * 100;
            } else {
                $porcentLavadoraTetrapack = 0;
            }
            if ($residuosPulper->residuo_pulper > 0 && $totalMP->mp_directa > 0) {

                $porcentResiduosPulper = ($residuosPulper->residuo_pulper / $totalMP->mp_directa) * 100;
            } else {
                $porcentResiduosPulper = 0;
            }
            if ($produccionNeta->produccionNeta > 0 && $mermaYankeeDry->merma > 0 && $produccionNeta->produccionNeta) {
                $factorFibral = (($totalMP->mp_directa - $lavadoraTetrapack->lav_tetrapack) / ($produccionNeta->produccionNeta + $mermaYankeeDry->merma));
            } else {
                $factorFibral = 0;
            }
        } else {
            $produccionNeta = $this->calcularProduccionNeta($idOP);
            $mermaYankeeDry = $this->calcularMermaYankeeDry($idOP);
            $residuosPulper = $this->calcularResiduosPulper($idOP);
            $lavadoraTetrapack = $this->calcularLavadoraTetrapack($idOP);
            $totalMP = $this->calcularTotalMP($idOP);
            $electricidad = $this->calcularElectricidad($idOP);
            $consumo_agua = $this->calcularConsumoAgua($idOP);
            $consumo_gas = $this->calcularConsumoGas($idOP);
            $produccion_total = $mermaYankeeDry->merma + $produccionNeta->produccionNeta;

            $Tonelada_dia = 0;

            if ($produccion_total == 0 || $produccion_total == '') {
                $estandar_electricidad = 0;
                $estandar_gas = 0;
            } else {
                $estandar_electricidad = ($electricidad['totalProcesoH'] / $produccion_total) * 1000;
                $estandar_gas = ($consumo_gas['total'] / $produccion_total) * 1000;
            }

            $porcentMermaYankeeDry = 0;
            $porcentResiduosPulper = 0;
            $porcentLavadoraTetrapack = 0;

            $factorFibral = 0;
        }
        $orden = new orden(
            $ord_produccion->idOrden,
            $ord_produccion->numOrden,
            $producto->nombre,
            $usuario->nombres . ' ' . $usuario->apellidos,
            $ord_produccion->hrsTrabajadas,
            date('d/m/Y', strtotime($ord_produccion->fechaInicio)),
            date('d/m/Y', strtotime($ord_produccion->fechaFinal)),
            date('g:i a', strtotime($ord_produccion->horaInicio)),
            date('g:i a', strtotime($ord_produccion->horaFinal)),
            $produccionNeta->produccionNeta,
            $produccion_total,
            $estandar_electricidad,
            $estandar_gas,
            $mermaYankeeDry->merma,
            $residuosPulper->residuo_pulper,
            $lavadoraTetrapack->lav_tetrapack,
            number_format($porcentMermaYankeeDry, 2),
            number_format($porcentResiduosPulper, 2),
            number_format($porcentLavadoraTetrapack, 2),
            $electricidad,
            $consumo_agua,
            $consumo_gas,
            number_format($factorFibral, 2),
            $Tonelada_dia
        );

        return view('User.Orden_Produccion.detalle', compact(['orden', 'mp_directa', 'mo_directa', 'quimico_maquina', 'yk_hrasEftvs']));
    }

    public function crear()
    {
        /*$productos = productos::where('estado', 1)->get()->toArray();
        $usuarios = usuario::usuarioByRole();
        return view('User.Orden_Produccion.crear', compact(['productos', 'usuarios']));*/
        $idOrd = orden_produccion::latest('numOrden')->first();
        $fibras = fibras::where('estado', 1)->orderBy('idFibra', 'asc')->get();
        $maquinas = maquinas::where('estado', 1)->orderBy('idMaquina', 'asc')->get();
        //$mp_directa = mp_directa::where('numOrden', intval($idOrd->numOrden + 1))->get();
        $productos = productos::where('estado', 1)->get()->toArray();
        $usuarios = usuario::usuarioByRole();

        $mp_directa = mp_directa::select(
            'mp_directa.*',
            'fibras.descripcion',
            'maquinas.nombre',
            'fibras.idFibra',
            'maquinas.idMaquina'
        )
            ->join('fibras', 'mp_directa.idFibra', '=', 'fibras.idFibra')
            ->join('maquinas', 'mp_directa.idMaquina', '=', 'maquinas.idMaquina')
            ->where('mp_directa.numOrden', $idOrd->numOrden)
            ->get();

        $quimicos = Quimicos::where('estado', 1)->orderBy('idQuimico', 'asc')->get();
        $quimico_maquina = QuimicoMaquina::select(
            'quimico_maquina.*',
            'quimicos.descripcion',
            'maquinas.nombre',
            'quimicos.idQuimico',
            'maquinas.idMaquina'
        )
            ->join('quimicos', 'quimico_maquina.idQuimico', '=', 'quimicos.IdQuimico')
            ->join('maquinas', 'quimico_maquina.idMaquina', '=', 'maquinas.idMaquina')
            ->where('quimico_maquina.numOrden', $idOrd->numOrden)
            ->get();

        return view('User.Orden_Produccion.crear', compact([
            'productos', 'usuarios',
            'idOrd', 'fibras', 'maquinas', 'mp_directa', 'quimicos', 'quimico_maquina'
        ]));
    }

    public function guardar(Request $request)
    {
        //dd($request);
        //$response = '';
        /*$messages = array(
            'required' => 'El :attribute es un campo requerido',
            'unique' => 'Ya existe una orden de trabajo con este codigo'
        );

        $validator = Validator::make($request->all(), [
            'numOrden' => 'required|unique:orden_produccion',
            'producto' => 'required',
            'fecha01' => 'required|date',
            'fecha02' => 'required|date',
            'hora01' => 'required',
            'hora02' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
            //return response($validator);
        }*/
        /*if ($request->hrsTrabajadas < 0) {

            return Redirect::back()->withErrors("Las horas trabajados no pueden ser menores a 0")->withInput();
        }*/
        /*if (date("Y-m-d", strtotime($request->fecha02)) < date("Y-m-d", strtotime($request->fecha01))) {
            return Redirect::back()->withErrors("La fecha final no puede ser menor a la fecha inicial")->withInput();
        }*/

        if($request->ajax()){
            try {
                $orden_repetida= orden_produccion::where('numOrden', '=', $request->input('numOrden'))->first();
                if(!is_null($orden_repetida)){
                    return response()->json(true);
                }else{
                    DB::transaction(function () use ($request) {

                        $ordProd = new orden_produccion();
                        $ordProd->numOrden = $request->input('numOrden');
                        $ordProd->producto = $request->input('producto');
                        $ordProd->idUsuario = $request->input('jefe');
                        $ordProd->hrsTrabajadas = $request->input('hrsTrabajadas') <= 0 || $request->input('hrsTrabajadas') == "" ? 0 : $request->input('hrsTrabajadas');
                        $ordProd->fechaInicio = date("Y-m-d", strtotime($request->input('fecha01')));
                        $ordProd->fechaFinal = date("Y-m-d", strtotime($request->input('fecha02')));
                        $ordProd->horaInicio = date("H:i", strtotime($request->input('hora01')));
                        $ordProd->horaFinal = date("H:i", strtotime($request->input('hora02')));
                        $ordProd->estado = 1;
                        $ordProd->save();

                        return  response()->json($ordProd);
                        //return redirect()->route('orden-produccion/editar/{id}', [$request->numOrden])->with('message-success', 'Se creo la Orden de Produccion con exito :)');
                    });
                }

            } catch (Exception $e) {
                $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";

                return response()->json($mensaje);
            }

        }


        return redirect()->route('orden-produccion/editar/{id}', [$request->numOrden])->with('message-success', 'Se creo la Orden de Produccion con exito :)');

    }

    public function getQuimicos(Request $request){
        $idOP = $request->input('idOP');
        $quimicos = Quimicos::getQuimicos($idOP);
        return response()->json($quimicos);
    }

    public function getFibras(Request $request){
        $idOP = $request->input('idOP');
        $fibra = fibras::getFibras($idOP);
        return response()->json($fibra);
    }
    
    public function editar($idOP)
    {
        $fibras = array();
        $quimicos = array();
        $i = 0;

        $usuarios = usuario::usuarioByRole();
        $orden = orden_produccion::where('numOrden', $idOP)->where('estado', 1)->get();
        $productos = productos::where('estado', 1)->get();

        //return view('User.Orden_Produccion.editar', compact(['orden', 'usuarios', 'productos']));

        $fibras = fibras::getFibras($idOP);
        $quimicos = Quimicos::getQuimicos($idOP);
        $maquinas = maquinas::where('estado', 1)->orderBy('idMaquina', 'asc')->get();
        $mp_directa = mp_directa::where('numOrden', $idOP)->get();
        $quimico_maquina = QuimicoMaquina::where('numOrden', $idOP)->get();
        $costo_indirecto = actividad::getCostoI($idOP);
        $mano_obra = actividad::getManoO($idOP);

        //dd($mano_obra);
        //dd($quimicos);
        /*foreach($fibras->original as $fb){
            dd($fb->codigo);
        }*/

        /*$quimico_maquina = QuimicoMaquina::select(
            'quimico_maquina.*',
            'quimicos.descripcion',
            'maquinas.nombre',
            'quimicos.idQuimico',
            'maquinas.idMaquina'
        )
            ->join('quimicos', 'quimico_maquina.idQuimico', '=', 'quimicos.IdQuimico')
            ->join('maquinas', 'quimico_maquina.idMaquina', '=', 'maquinas.idMaquina')
            ->where('quimico_maquina.numOrden', $idOP)
            ->get();
        $mp_directa = mp_directa::select(
            'mp_directa.*',
            'fibras.descripcion',
            'maquinas.nombre',
            'fibras.idFibra',
            'maquinas.idMaquina'
        )
            ->join('fibras', 'mp_directa.idFibra', '=', 'fibras.idFibra')
            ->join('maquinas', 'mp_directa.idMaquina', '=', 'maquinas.idMaquina')
            ->where('mp_directa.numOrden', $idOP)
            ->get();*/
        //dd($quimico_maquina, $mp_directa);

        return view('User.Orden_Produccion.editar', compact(
            'orden',
            'mp_directa',
            'usuarios',
            'fibras',
            'productos',
            'maquinas',
            'quimicos',
            'quimico_maquina',
            'costo_indirecto',
            'mano_obra'
        ));
    }

    public function actualizar(Request $request)
    {
        if ($request->hrsTrabajadas == '') {
            return Redirect::back()->withErrors("Las horas trabajadas no pueden estar vacias")->withInput();
        }

        $messages = array(
            'required' => 'El :attribute es un campo requerido',
        );

        $validator = Validator::make($request->all(), [
            'numOrden' => 'required',
            'producto' => 'required',
            'fecha01' => 'required|date',
            'fecha02' => 'required|date',
            'hora01' => 'required',
            'hora02' => 'required',
            'hrsTrabajadas' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        orden_produccion::where('numOrden', $request->numOrden)
            ->update([
                'producto' => $request->producto,
                'idUsuario' => $request->jefe,
                'hrsTrabajadas' => $request->hrsTrabajadas,
                'fechaInicio' => date("Y-m-d", strtotime($request->fecha01)),
                'fechaFinal' => date("Y-m-d", strtotime($request->fecha02)),
                'horaInicio' => date("H:i", strtotime($request->hora01)),
                'horaFinal' => date("H:i", strtotime($request->hora02))
            ]);

        return redirect()->back()->with('message-success', 'Se actualizo la Orden de Produccion con exito :)');
    }

    public function calcularManoObraDirecta($idOP)
    {
        $array = array();

        /* DB::beginTransaction();

        try{
            DB::insert(...);
        }*/

        $t_pulpeo = tiempo_pulpeo::select(DB::raw('COALESCE(SUM(cant_dia),0) as cantDia, COALESCE(SUM(cant_noche),0) as cantNoche,  COALESCE(tiempoPulpeo,0) as tiempoPulpeo'))
            ->where('numOrden', $idOP)
            ->groupBy('tiempoPulpeo')
            ->get()->first();


        $t_lavado = tiempo_lavado::select(DB::raw('COALESCE(SUM(cant_dia),0)as cantDia, COALESCE(SUM(cant_noche),0) as cantNoche, COALESCE(tiempoLavado,0)'))
            ->where('numOrden', $idOP)
            ->groupBy('tiempoLavado')
            ->get()->first();

        $t_muertos = tiempos_muertos::select(DB::raw('COALESCE(SUM(y1_dia),0) as cantDiaY1, COALESCE(SUM(y2_dia),0) as cantDiaY2, COALESCE(SUM(y1_noche),0) as cantNocheY1, COALESCE(SUM(y2_noche),0)as cantNocheY2'))
            ->where('numOrden', $idOP)
            ->get()->first();

        $hrsTrabajadas = orden_produccion::select('hrsTrabajadas')->where('numOrden', $idOP)->get()->first();
        $hrsTrabajadas = $hrsTrabajadas->hrsTrabajadas / 2;

        if ($t_pulpeo) {
            $t_pulpeo_dia = ($t_pulpeo->cantDia * $t_pulpeo->tiempoPulpeo) / 60;
            $t_pulpeo_noche = ($t_pulpeo->cantNoche * $t_pulpeo->tiempoPulpeo) / 60;
        } else {
            $t_pulpeo_dia = 0;
            $t_pulpeo_noche = 0;
        }
        if ($t_lavado) {
            if($t_pulpeo){
                $t_lavado_dia = ($t_lavado->cantDia * $t_pulpeo->tiempoPulpeo) / 60;
                $t_lavado_noche = ($t_lavado->cantNoche * $t_pulpeo->tiempoPulpeo) / 60;
            } else {
                $t_lavado_dia = 0;
                $t_lavado_noche = 0;
            }
        } else {
            $t_lavado_dia = 0;
            $t_lavado_noche = 0;
        }
        if ($t_muertos) {
            $y1_jumboroll_dia = $hrsTrabajadas - ($t_muertos->cantDiaY1 / 60);
            $y1_jumboroll_noche = $hrsTrabajadas - ($t_muertos->cantNocheY1 / 60);
            $y1_jumboroll_total = $y1_jumboroll_dia + $y1_jumboroll_noche;

            $y2_jumboroll_dia = $hrsTrabajadas - ($t_muertos->cantDiaY2 / 60);
            $y2_jumboroll_noche = $hrsTrabajadas - ($t_muertos->cantNocheY2 / 60);
            $y2_jumboroll_total = $y2_jumboroll_dia + $y2_jumboroll_noche;
        } else {
            $y1_jumboroll_dia = 0;
            $y1_jumboroll_noche = 0;
            $y1_jumboroll_total = 0;

            $y2_jumboroll_dia = 0;
            $y2_jumboroll_noche = 0;
            $y2_jumboroll_total = 0;
        }

        $array[0]['actividad'] = 'Pulper 1 - Pasta Reciclada';
        $array[0]['dia'] = number_format($t_pulpeo_dia, 2);
        $array[0]['noche'] = number_format($t_pulpeo_noche, 2);
        $array[0]['total'] = $t_pulpeo_dia + $t_pulpeo_noche;

        $array[1]['actividad'] = 'Lavadora de Tetrapack';
        $array[1]['dia'] = number_format($t_lavado_dia, 2);
        $array[1]['noche'] = number_format($t_lavado_noche, 2);
        $array[1]['total'] = $t_lavado_dia + $t_lavado_noche;

        $array[2]['actividad'] = 'Pulper 2 - Pasta Virgen';
        $array[2]['dia'] = number_format(0, 2);
        $array[2]['noche'] = number_format(0, 2);
        $array[2]['total'] = number_format(0, 2);

        $array[3]['actividad'] = 'Pulper 2 - Pasta Virgen';
        $array[3]['dia'] = number_format(0, 2);
        $array[3]['noche'] = number_format(0, 2);
        $array[3]['total'] = number_format(0, 2);

        $array[4]['actividad'] = 'Yankee 1 - Jumbo Roll';
        $array[4]['dia'] = number_format($y1_jumboroll_dia, 2);
        $array[4]['noche'] = number_format($y1_jumboroll_noche, 2);
        $array[4]['total'] = number_format($y1_jumboroll_total, 2);

        $array[5]['actividad'] = 'Yankee 2 - Jumbo Roll';
        $array[5]['dia'] = number_format($y2_jumboroll_dia, 2);
        $array[5]['noche'] = number_format($y2_jumboroll_noche, 2);
        $array[5]['total'] = number_format($y2_jumboroll_total, 2);

        $array[6]['actividad'] = 'Caldera';
        $array[6]['dia'] = number_format($hrsTrabajadas, 2);
        $array[6]['noche'] = number_format($hrsTrabajadas, 2);
        $array[6]['total'] = number_format($hrsTrabajadas * 2, 2);

        $array[7]['actividad'] = 'Planta de Tratamiento';
        $array[7]['dia'] = number_format($hrsTrabajadas, 2);
        $array[7]['noche'] = number_format($hrsTrabajadas, 2);
        $array[7]['total'] = number_format($hrsTrabajadas * 2, 2);

        return $array;
    }

    public function calcularProduccionNeta($numOrden)
    {
        $data = jumboroll_detalle::select(DB::raw('SUM(jumboroll_detalle.kg) as produccionNeta'))
            ->join('jumboroll', 'jumboroll_detalle.idJumboroll', '=', 'jumboroll.id')
            ->where('jumboroll.numOrden', $numOrden)
            ->get()->first();

        return $data;
    }

    public function calcularProduccionTotal($numOrden)
    {
        $merma = jumboroll::select(DB::raw('( SUM(merma_yankee_dry_1) + SUM(merma_yankee_dry_2) ) AS merma'))
            ->where('jumboroll.numOrden', $numOrden)
            ->get()->first();

        $lav_tp = jumboroll::select(DB::raw('SUM(lavadora_tetrapack) AS lav_tetrapack'))
            ->where('jumboroll.numOrden', $numOrden)
            ->get()->first();

        $res_pulper = jumboroll::select(DB::raw('SUM(residuo_pulper) AS residuo_pulper'))
            ->where('jumboroll.numOrden', $numOrden)
            ->get()->first();

        $merma_yankee_dry = $merma->merma;
        $lavadora_tetrapack = $lav_tp->lav_tetrapack;
        $residuo_pulper = $res_pulper->residuo_pulper;

        //return $merma_yankee_dry + $lavadora_tetrapack + $residuo_pulper;
        //return $merma_yankee_dry;
    }

    public function calcularMermaYankeeDry($numOrden)
    {
        $merma = jumboroll::select(DB::raw('( SUM(merma_yankee_dry_1) + SUM(merma_yankee_dry_2) ) AS merma'))
            ->where('jumboroll.numOrden', $numOrden)
            ->get()->first();

        return $merma;
    }

    public function calcularResiduosPulper($numOrden)
    {
        $res_pulper = jumboroll::select(DB::raw('SUM(residuo_pulper) AS residuo_pulper'))
            ->where('jumboroll.numOrden', $numOrden)
            ->get()->first();

        return $res_pulper;
    }

    public function calcularLavadoraTetrapack($numOrden)
    {
        $lav_tp = jumboroll::select(DB::raw('SUM(lavadora_tetrapack) AS lav_tetrapack'))
            ->where('jumboroll.numOrden', $numOrden)
            ->get()->first();

        return $lav_tp;
    }

    public function calcularTotalMP($numOrden)
    {
        $data = mp_directa::select(DB::raw('SUM(cantidad) as mp_directa'))
            ->where('numOrden', $numOrden)
            ->get()->first();

        return $data;
    }

    public function calcularElectricidad($numOrden)
    {
        $data = array();
        $electricidad = electricidad::select('inicial', 'final')
            ->where('numOrden', $numOrden)
            ->get()->first();

        if ($electricidad) {
            $inicial = ($electricidad->inicial == '') ? 0 : $electricidad->inicial;
            $final = ($electricidad->final == '') ? 0 : $electricidad->final;
        } else {
            $inicial = 0;
            $final = 0;
        }

        $total = 0;

        if ($final > 0) {
            $data = array(
                'inicial' => $inicial,
                'final' => $final,
                'totalConsumo' => (($final - $inicial)),
                'totalProcesoH' => (((($final - $inicial) * 560) * 0.8))
            );
        } else {
            $data = array(
                'inicial' => 0,
                'final' => 0,
                'totalConsumo' => number_format(0),
                'totalProcesoH' => number_format(0)
            );
        }

        return $data;
    }

    public function calcularConsumoAgua($numOrden)
    {
        $data = array();
        $consumo_agua = consumo_agua::select('inicial', 'final')
            ->where('numOrden', $numOrden)
            ->get()->first();

        if ($consumo_agua) {
            $inicial = ($consumo_agua->inicial == '') ? 0 : $consumo_agua->inicial;
            $final = ($consumo_agua->final == '') ? 0 : $consumo_agua->final;
        } else {
            $inicial = 0;
            $final = 0;
        }

        $total = 0;

        if ($final > 0) {
            $data = array(
                'inicial' => $inicial,
                'final' => $final,
                'total' => number_format(($final - $inicial), 2)
            );
        } else {
            $data = array(
                'inicial' => 0,
                'final' => 0,
                'total' => number_format(0)
            );
        }

        return $data;
    }

    public function calcularConsumoGas($numOrden)
    {
        $data = array();
        $consumo_gas = ConsumoGas::select('inicial', 'final')
            ->where('numOrden', $numOrden)
            ->get()->first();

        if ($consumo_gas) {
            $inicial = ($consumo_gas->inicial == '') ? 0 : $consumo_gas->inicial;
            $final = ($consumo_gas->final == '') ? 0 : $consumo_gas->final;
        } else {
            $inicial = 0;
            $final = 0;
        }

        $total = 0;

        if ($final > 0) {
            $data = array(
                'inicial' => $inicial,
                'final' => $final,
                'total' => (($final - $inicial))
            );
        } else {
            $data = array(
                'inicial' => 0,
                'final' => 0,
                'total' => 0
            );
        }

        return $data;
    }

    public function cargarMateriaPrimadirecta($idOrd)
    {
        $array = array();
        $mp_directa_exist = "";
        $maquinas_exist = "";
        $fibras_exist = "";
        $mp_directa_ = mp_directa::where('numOrden', $idOrd)->get(); // obtengo la cantidad de materia prima
        $maquinas = maquinas::where([['nombre', 'yankee'], ['estado', 1]])->get(); // obtengo la maquina seleccionada
        $fibras = fibras::where([['idfibra', 1], ['estado', 1]])->get(); //obtengo la fibra seleccionada


        return view('User.Orden_Produccion.crear', compact(['mp_directa_', 'maquinas', 'fibras']));
    }

    public function eliminarMateriaPrima(Request $request)
    {
        $id = intval($request->input('id'));
        $response = mp_directa::where('id', $id)
            ->update([
                'estado' => 0
            ]);
        return response()->json($response);
    }

    public function getDataMateriaPrima()
    {
        $array = array();

        $fibras = fibras::where('estado', 1)
            ->get()->toArray();

        $maquinas = maquinas::where('estado', 1)
            ->get()->toArray();

        $array = array(
            'dataFibras' => $fibras,
            'dataMaquinas' => $maquinas
        );

        return response()->json($array);
    }

    public function getMaquinas()
    {
        $maquinas = maquinas::where('estado', 1)
            ->get();

        return response()->json($maquinas);
    }

    public function guardarCostosIndirectosFabricacion(Request $request)
    {
        if ($request->isMethod('post')) {
            $numOrden = $request->input('codigo');
            $consumoInicialElec = ($request->input('consumoInicialElec') == '') ? 0 : $request->input('consumoInicialElec');
            $consumoFinalElec = ($request->input('consumoFinalElec') == '') ? 0 : $request->input('consumoFinalElec');
            $consumoInicialAgua = ($request->input('consumoInicialAgua') == '') ? 0 : $request->input('consumoInicialAgua');
            $consumoFinalAgua = ($request->input('consumoFinalAgua') == '') ? 0 : $request->input('consumoFinalAgua');
            $consumoInicialGas = ($request->input('consumoInicialGas') == '') ? 0 : $request->input('consumoInicialGas');
            $consumoFinalGas = ($request->input('consumoFinalGas') == '') ? 0 : $request->input('consumoFinalGas');

            $electricidad = electricidad::where('numOrden', $numOrden)->get()->toArray();
            $consumoAgua = consumo_agua::where('numOrden', $numOrden)->get()->toArray();
            $consumoGas = ConsumoGas::where('numOrden', $numOrden)->get()->toArray();

            if (count($electricidad) > 0) {
                $response = electricidad::where('numOrden', $numOrden)
                    ->update([
                        'inicial' => $consumoInicialElec,
                        'final' => $consumoFinalElec
                    ]);
            } else {
                $electricidad = new electricidad();
                $electricidad->inicial = $consumoInicialElec;
                $electricidad->final = $consumoFinalElec;
                $electricidad->numOrden = $numOrden;
                $response = $electricidad->save();
            }

            if (count($consumoAgua) > 0) {

                $response = consumo_agua::where('numOrden', $numOrden)
                    ->update([
                        'inicial' => $consumoInicialAgua,
                        'final' => $consumoFinalAgua
                    ]);
            } else {
                $consumo_agua = new consumo_agua();
                $consumo_agua->inicial = $consumoInicialAgua;
                $consumo_agua->final = $consumoFinalAgua;
                $consumo_agua->numOrden = $numOrden;
                $response = $consumo_agua->save();
            }

            if (count($consumoGas) > 0) {

                $response = ConsumoGas::where('numOrden', $numOrden)
                    ->update([
                        'inicial' => $consumoInicialGas,
                        'final' => $consumoFinalGas
                    ]);
            } else {
                $consumo_gas = new ConsumoGas();
                $consumo_gas->inicial = $consumoInicialGas;
                $consumo_gas->final = $consumoFinalGas;
                $consumo_gas->numOrden = $numOrden;
                $response = $consumo_gas->save();
            }
        }

        return response()->json(true);
    }

    public function guardarMP(Request $request)
    {
        $i = 0;
        $countF = 0;
        //$countMP_E = 0;
        $arrayF_select = array();
        $arrayF_select2 = array();
        $j = 0;

        $numOrden = $request->input('codigo');
        $numOrdenE = orden_produccion::where('numOrden', '=', $numOrden)->first();
        $arrayFibra = $request->input('data');
        if ($numOrdenE != null) {
            if ($request->isMethod('post')) {
                $array = array();
                if (is_null($arrayFibra)) {
                    return response()->json(1);
                    // return response("Por favor ingrese materia prima,los datos estan vacios)", 400);
                } else {
                    foreach ($request->input('data') as $key) {
                        array_push($arrayF_select, $key['fibra']);
                        if ($key['maquina'] !== 'undefined' && $key['fibra'] !== 'undefined' && $key['cantidad'] !== 'undefined') {
                            $array[$i]['id'] = $key['id'];
                            $array[$i]['numOrden'] = $key['orden'];
                            $array[$i]['idMaquina'] = $key['maquina'];
                            $array[$i]['idFibra'] = $key['fibra'];
                            $array[$i]['cantidad'] = $key['cantidad'];
                            $array[$i]['estado'] = 1;
                            $i++;
                        }
                    }
                    if (count($array) >= 0) {
                        //mp_directa::where('numOrden', $numOrden)->delete();
                        $arrayF_select2 = array_unique($arrayF_select);
                        if (count($arrayF_select2) > 0) {
                            foreach ($arrayF_select2 as $select_) {
                                //echo "  MO #  " . $select_;
                                $j++;
                            }
                            if (count($arrayF_select2) < count($arrayF_select)) {
                                //return response()->json("Ha ingresado materias primas repetidas");
                                return response("Oh no! Ha ingresado materias primas repetidas D:", 400);
                            }/* else if (count($arrayF_select2) === count($arrayF_select)) {
                                return response()->json("Ha ingresado materias primas diferentes");
                            }*/

                            //return response()->json(count($arrayF_select2));
                            //return redirect()->back()->with('message-failed', 'No se guardo con exito :(, existe una materia prima repetida, por favor elija otra');
                        }
                        foreach ($array as $dataMP) {
                            $mpE = mp_directa::where([
                                ['numOrden', '=', $numOrden],
                                ['id', '=', $dataMP['id']],
                                ['estado', '=', 1]
                            ])->first();
                            if ($mpE != null) {
                                mp_directa::where([
                                    ['numOrden', '=', $numOrden],
                                    ['id', '=', $dataMP['id']],
                                    ['estado', '=', 1]
                                ])->update([
                                    'idMaquina' => $dataMP['idMaquina'],
                                    'idFibra' => $dataMP['idFibra'],
                                    'cantidad' => $dataMP['cantidad'],
                                    'estado' => 1,
                                ]);
                            } else {
                                $mpd = new mp_directa();
                                $mpd->idMaquina = $dataMP['idMaquina'];
                                $mpd->idFibra = $dataMP['idFibra'];
                                $mpd->numOrden = $dataMP['numOrden'];
                                $mpd->cantidad = $dataMP['cantidad'];
                                $mpd->estado = 1;
                                $mpd->save();
                            }
                        }
                        return response("El registro de fibras en la orden ha sido exitoso :)", 200);

                        /*mp_directa::where('numOrden', $numOrden)
                        ->update([
                            'estado' => 0
                        ]);*/
                    } else {
                        return response()->json(false);
                    }

                    //return response()->json($response);
                }
            }
            //return response("El registro de fibras en la orden ha sido exitoso :)", 200);
        } else {
            return response("Error al guardar las fibras, la orden no existe,
            por favor cree la orden antes de agregar las fibras :(", 400);
        }
    }

    public function guardarMPD(Request $request){
        $id = $request->input('id');
        $numOrden = $request->input('codigo');
        $maquina = $request->input('idMaquina');
        $fibra = $request->input('idFibra');
        $cantidad = $request->input('cantidad');

        $numOrdenE = orden_produccion::where('numOrden', '=', $numOrden)->first();

        if ($numOrdenE != null) {
            $mpE = mp_directa::where([
                ['numOrden', '=', $numOrden],
                ['idFibra', '=', $fibra],
                ['estado', '=', 1]
            ])->first();
            if ($mpE != null) {
                mp_directa::where([
                    ['numOrden', '=', $numOrden],
                    ['idFibra', '=', $fibra],
                    ['estado', '=', 1]
                ])->update([
                    'cantidad' => $cantidad
                ]);
            } else {
                $mpd = new mp_directa();
                $mpd->idMaquina = $maquina;
                $mpd->idFibra = $fibra;
                $mpd->numOrden = $numOrden;
                $mpd->cantidad = $cantidad;
                $mpd->estado = 1;
                $mpd->save();
            }
            return response("El registro de fibras en la orden ha sido exitoso :)", 200);
        }else {
            return response("Error al guardar las fibras, la orden no existe,
            por favor cree la orden antes de agregar las fibras :(", 400);
        }
       
    }

    public function actualizarMO(Request $request){
        $idActividad = $request->input('idActividad');
        $numOrden = $request->input('codigo');
        $dia = $request->input('dia');
        $noche = $request->input('noche');
        $total = "0";


        $total = number_format($dia,2, '.',',') +  number_format($noche,2, '.',',');
        $numOrdenE = orden_produccion::where('numOrden', '=', $numOrden)->first();

        if ($numOrdenE != null) {
            $ci = manoObra::where([
                ['numOrden', '=', $numOrden],
                ['idActividad', '=', $idActividad]
            ])->first();
            if ($ci != null) {
                manoObra::where([
                    ['numOrden', '=', $numOrden],
                    ['idActividad', '=', $idActividad]
                ])->update([
                    'dia' => $dia,
                    'noche' => $noche,
                    'total' => $total
                ]);
            } else {
                $ci = new manoObra();
                $ci->idActividad = $idActividad;
                $ci->numOrden = $numOrden;
                $ci->dia = $dia;
                $ci->noche = $noche;
                $ci->total = $total;
                
                $ci->save();
            }
            return response("El registro ha sido exitoso :)", 200);
        }else {
            return response("Error al guardar, la orden no existe,
            por favor cree la orden antes de agregar las fibras :(", 400);
        }
       
    }

    public function actualizarCI(Request $request){
        $idActividad = $request->input('idActividad');
        $numOrden = $request->input('codigo');
        $dia = $request->input('dia');
        $noche = $request->input('noche');
        $horas = "0";


        $horas = number_format($dia,2, '.',',') +  number_format($noche,2, '.',',');
        $numOrdenE = orden_produccion::where('numOrden', '=', $numOrden)->first();

        if ($numOrdenE != null) {
            $ci = costoIndirecto::where([
                ['numOrden', '=', $numOrden],
                ['idActividad', '=', $idActividad]
            ])->first();
            if ($ci != null) {
                costoIndirecto::where([
                    ['numOrden', '=', $numOrden],
                    ['idActividad', '=', $idActividad]
                ])->update([
                    'dia' => $dia,
                    'noche' => $noche,
                    'horas' => $horas
                ]);
            } else {
                $ci = new costoIndirecto();
                $ci->idActividad = $idActividad;
                $ci->numOrden = $numOrden;
                $ci->dia = $dia;
                $ci->noche = $noche;
                $ci->horas = $horas;
                
                $ci->save();
            }
            return response("El registro ha sido exitoso :)", 200);
        }else {
            return response("Error al guardar, la orden no existe,
            por favor cree la orden antes de agregar las fibras :(", 400);
        }
       
    }

    public function guardarQM(Request $request)
    {
        $i = 0;
        $numOrden = $request->input('codigo');
        $numOrdenE = orden_produccion::where('numOrden', '=', $numOrden)->first();
        $arrayQuimico = $request->input('data');
        if ($numOrdenE != null) {
            if ($request->isMethod('post')) {
                $array = array();
                if (is_null($arrayQuimico)) {
                    return response("Por favor ingrese Quimico,los datos estan vacios)", 400);
                } else {
                    foreach ($request->input('data') as $key) {
                        if ($key['maquina'] !== 'undefined' && $key['quimico'] !== 'undefined' && $key['cantidad'] !== 'undefined') {
                            $array[$i]['id'] = $key['id'];
                            $array[$i]['numOrden'] = $key['orden'];
                            $array[$i]['idMaquina'] = $key['maquina'];
                            $array[$i]['idQuimico'] = $key['quimico'];
                            $array[$i]['cantidad'] = $key['cantidad'];
                            $array[$i]['estado'] = 1;
                            $i++;
                        }
                    }
                    if (count($array) > 0) {
                        foreach ($array as $dataQM) {
                            $qmE = QuimicoMaquina::where([
                                ['numOrden', '=', $numOrden],
                                ['id', '=', $dataQM['id']],
                                ['estado', '=', 1]
                            ])->first();
                            if ($qmE != null) {
                                QuimicoMaquina::where([
                                    ['numOrden', '=', $numOrden],
                                    ['id', '=', $dataQM['id']],
                                    ['estado', '=', 1]
                                ])->update([
                                    'idMaquina' => $dataQM['idMaquina'],
                                    'idQuimico' => $dataQM['idQuimico'],
                                    'cantidad' => $dataQM['cantidad'],
                                    'estado' => 1,
                                ]);
                            } else {
                                $qm = new QuimicoMaquina();
                                $qm->idMaquina = $dataQM['idMaquina'];
                                $qm->idQuimico = $dataQM['idQuimico'];
                                $qm->numOrden = $dataQM['numOrden'];
                                $qm->cantidad = $dataQM['cantidad'];
                                $qm->estado = 1;
                                $qm->save();
                            }
                        }
                    } else {
                        return response()->json(false);
                    }
                    //return response()->json($response);
                    return response("El registro de quimicos en la orden ha sido exitoso :)", 200);
                }
            }
            //return response("El registro de quimicos en la orden ha sido exitoso :)", 200);
        } else {
            return response("Error al guardar los quimicos, la orden no existe,
            por favor cree la orden antes de agregar los quimicos :(", 400);
        }
    }

    public function guardarQuimico(Request $request){
        $numOrden = $request->input('codigo');
        $maquina = $request->input('idMaquina');
        $quimico = $request->input('idQuimico');
        $cantidad = $request->input('cantidad');

        $numOrdenE = orden_produccion::where('numOrden', '=', $numOrden)->first();

        if ($numOrdenE != null) {
            $mpE = QuimicoMaquina::where([
                ['numOrden', '=', $numOrden],
                ['idQuimico', '=', $quimico],
                ['estado', '=', 1]
            ])->first();
            if ($mpE != null) {
                QuimicoMaquina::where([
                    ['numOrden', '=', $numOrden],
                    ['idQuimico', '=', $quimico],
                    ['estado', '=', 1]
                ])->update([
                    'cantidad' => $cantidad
                ]);
            } else {
                $mpd = new QuimicoMaquina();
                $mpd->idMaquina = $maquina;
                $mpd->idQuimico = $quimico;
                $mpd->numOrden = $numOrden;
                $mpd->cantidad = $cantidad;
                $mpd->estado = 1;
                $mpd->save();
            }
            return response("El registro de quimicos en la orden ha sido exitoso :)", 200);
        }else {
            return response("Error al guardar los quimicos, la orden no existe,
            por favor cree la orden antes de agregar los quimicos :(", 400);
        }
       
    }

    public function getDataQuimico()
    {
        $array = array();

        $quimicos = Quimicos::where('estado', 1)
            ->get()->toArray();

        $maquinas = maquinas::where('estado', 1)
            ->get()->toArray();

        $array = array(
            'dataQuimicos' => $quimicos,
            'dataMaquinas' => $maquinas
        );

        return response()->json($array);
    }

    public function cargarQuimico($idOrd) // Cargar Quimico
    {

        $array = array();
        $qm_directa_exist = "";
        $maquinas_exist = "";
        $quimicos_exist = "";
        $qm_directa_ = QuimicoMaquina::where('numOrden', $idOrd)->get(); // obtengo la cantidad de materia prima
        $maquinas = maquinas::where([['nombre', 'yankee'], ['estado', 1]])->get(); // obtengo la maquina seleccionada
        $quimicos = Quimicos::where([['idQuimico', 1], ['estado', 1]])->get(); //obtengo el quimico seleccionado


        return view('User.Orden_Produccion.crear', compact(['qm_directa_', 'maquinas', 'quimicos']));
    }

    public function eliminarQuimico(Request $request)
    {
        $id = intval($request->input('id'));
        $response = QuimicoMaquina::where('id', $id)
            ->update([
                'estado' => 0
            ]);
        return response()->json($response);
    }


    public function getData($idOrd)
    {
        $response = array();
        $data = array();

        $i = 0;
        /*$mp_directa_exist = "";
        $maquinas_exist = "";
        $fibras_exist = "";*/
        $mp_directa_ = mp_directa::where([['numOrden', $idOrd], ['estado', 1]])->get(); // obtengo la cantidad de materia prima
        $maquinas = maquinas::where([['nombre', 'yankee'], ['estado', 1]])->get(); // obtengo la maquina seleccionada
        $fibras = fibras::where([['idfibra', 1], ['estado', 1]])->get(); //obtengo la fibra seleccionada

        //Quimicos
        /*$qm_directa_exist = "";
        $maquinas_exist = "";
        $quimicos_exist = "";*/
        $qm_directa_ = QuimicoMaquina::where([['numOrden', $idOrd], ['estado', 1]])->get(); // obtengo la cantidad de materia prima
        $maquinas = maquinas::where([['nombre', 'yankee'], ['estado', 1]])->get(); // obtengo la maquina seleccionada
        $quimicos = Quimicos::where([['idQuimico', 1], ['estado', 1]])->get(); //obtengo el quimico seleccionado

        // Array de fibras

        foreach ($mp_directa_ as $key) {
            if ($key['idMaquina'] !== '' && $key['idFibra'] !== '' && $key['cantidad'] !== '') {
                $data[$i]['id'] = $key['id'];
                $data[$i]['idMaquina'] = $key['idMaquina'];

                $maquinas = maquinas::where([['idMaquina', $key['idMaquina']], ['estado', 1]])->get(); // obtengo la maquina seleccionada
                foreach ($maquinas as $m) {
                    $data[$i]['nombreMaquina'] = $m['nombre'];
                }
                $data[$i]['idFibra'] = $key['idFibra'];
                $fibras = fibras::where([['idfibra', $key['idFibra']], ['estado', 1]])->get(); //obtengo la fibra seleccionada
                foreach ($fibras as $f) {
                    $data[$i]['nombreFibra'] = $f['descripcion'];
                }
                $data[$i]['numOrden'] = $key['numOrden'];
                $data[$i]['cantidad'] = $key['cantidad'];
                $i++;
            }
        }

        foreach ($qm_directa_ as $key) {
            if ($key['idMaquina'] !== '' && $key['idQuimico'] !== '' && $key['cantidad'] !== '') {
                $data[$i]['id'] = $key['id'];
                $data[$i]['idMaquina'] = $key['idMaquina'];

                $maquinas = maquinas::where([['idMaquina', $key['idMaquina']], ['estado', 1]])->get(); // obtengo la maquina seleccionada
                foreach ($maquinas as $m) {
                    $data[$i]['nombreMaquina'] = $m['nombre'];
                }
                $quimicos = Quimicos::where([['idQuimico', 1], ['estado', 1]])->get(); //obtengo el quimico seleccionado
                foreach ($quimicos as $q) {
                    $data[$i]['nombreQuimico'] = $q['descripcion'];
                }
                $data[$i]['idQuimico'] = $key['idQuimico'];
                $data[$i]['numOrden'] = $key['numOrden'];
                $data[$i]['cantidad'] = $key['cantidad'];
                // $array[$i]['estado'] = 1;
                $i++;
            }
        }
        return response()->json($data);

        //return view('User.Orden_Produccion.crear', compact(['qm_directa_', 'maquinas', 'quimicos']));
    }

    public function getOrdersProductions(){
        $array = array();
        $i = 0;
        $ord_produccion = orden_produccion::where('estado', 1)->orderBy('numOrden', 'DESC')->get();

        if (count($ord_produccion) > 0) {
            foreach ($ord_produccion as $key) {
                $array[$i]['idOrden'] = $key['idOrden'];
                $array[$i]['numOrden'] = $key['numOrden'];
                $fibra = productos::select('nombre')->where('idProducto', $key['producto'])->get()->first();
                $array[$i]['producto'] = $fibra->nombre;

                /** Produccion Real **/
                $detalle_prod_real = DetalleProduccion::select('prod_real')->where('numOrden', $key['numOrden'])->get()->first();
                if (is_null($detalle_prod_real) || $detalle_prod_real === '') {
                    $array[$i]['prod_real'] = 0;
                    $prod_real              = 0;
                    $merma_total            = 0;
                } else {
                    $array[$i]['prod_real'] = $detalle_prod_real->prod_real;
                }

                /** Merma Total **/
                $detalle_merma_total = DetalleProduccion::select('merma_total')->where('numOrden', $key['numOrden'])->get()->first();
                if (is_null($detalle_merma_total) || $detalle_merma_total == '') {
                    $array[$i]['merma_total'] = 0;
                } else {
                    $array[$i]['merma_total'] = $detalle_merma_total->merma_total;
                    $prod_real              = $detalle_prod_real['prod_real'];
                    $merma_total            = $detalle_prod_real['merma_total'];
                }


                $array[$i]['prod_total'] = $prod_real + $merma_total;

                $array[$i]['fechaInicio'] = date('d/m/Y', strtotime($key['fechaInicio']));
                $array[$i]['fechaFinal'] = date('d/m/Y', strtotime($key['fechaFinal']));
                $array[$i]['estado'] = $key['estado'];
                $i++;
            }
        }
        return response()->json($array);
    }
}


class orden
{
    public $idOrden;
    public $numOrden;
    public $producto;
    public $usuario;
    public $hrsTrabajadas;
    public $fechaInicio;
    public $fechaFinal;
    public $horaInicio;
    public $horaFinal;
    public $produccionNeta;
    public $produccionTotal;
    public $estandar_electricidad;
    public $estandar_gas;
    public $mermaYankeeDry;
    public $residuosPulper;
    public $lavadoraTetrapack;
    public $porcentMermaYankeeDry;
    public $porcentResiduosPulper;
    public $porcentLavadoraTetrapack;
    public $electricidad;
    public $consumo_agua;
    public $consumoGas;
    public $factorFibral;
    public $Tonelada_dia;


    public function __construct($idOrden, $numOrden, $producto, $usuario, $hrsTrabajadas, $fechaInicio, $fechaFinal, $horaInicio, $horaFinal, $produccionNeta, $produccionTotal, $estandar_electricidad, $estandar_gas, $mermaYankeeDry, $residuosPulper, $lavadoraTetrapack, $porcentMermaYankeeDry, $porcentResiduosPulper, $porcentLavadoraTetrapack, $electricidad, $consumo_agua, $consumoGas, $factorFibral, $Tonelada_dia)
    {
        $this->idOrden = $idOrden;
        $this->numOrden = $numOrden;
        $this->producto = $producto;
        $this->usuario = $usuario;
        $this->hrsTrabajadas = $hrsTrabajadas;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFinal = $fechaFinal;
        $this->horaInicio = $horaInicio;
        $this->horaFinal = $horaFinal;
        $this->produccionNeta = $produccionNeta;
        $this->produccionTotal = $produccionTotal;
        $this->estandar_electricidad = $estandar_electricidad;
        $this->estandar_gas = $estandar_gas;
        $this->mermaYankeeDry = $mermaYankeeDry;
        $this->residuosPulper = $residuosPulper;
        $this->lavadoraTetrapack = $lavadoraTetrapack;
        $this->porcentMermaYankeeDry = $porcentMermaYankeeDry;
        $this->porcentResiduosPulper = $porcentResiduosPulper;
        $this->porcentLavadoraTetrapack = $porcentLavadoraTetrapack;
        $this->electricidad = $electricidad;
        $this->consumo_agua = $consumo_agua;
        $this->consumoGas = $consumoGas;
        $this->factorFibral = $factorFibral;
        $this->Tonelada_dia = $Tonelada_dia;
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin\usuario;
use App\Models\consumo_agua;
use App\Models\electricidad;
use App\Models\fibras;
use App\Models\jumboroll;
use App\Models\jumboroll_detalle;
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

class orden_produccionController extends Controller
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
                $array[$i]['fechaInicio'] = date('d/m/Y', strtotime($key['fechaInicio']));
                $array[$i]['fechaFinal'] = date('d/m/Y', strtotime($key['fechaFinal']));
                $array[$i]['horaInicio'] = date('g:i a', strtotime($key['horaInicio']));
                $array[$i]['horaFinal'] = date('g:i a', strtotime($key['horaFinal']));
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

        $ord_produccion = orden_produccion::where('numOrden', $idOP)->get()->first();
        $producto = productos::select('nombre')->where('idProducto', $ord_produccion->producto)->get()->first();
        $usuario = usuario::select('nombres', 'apellidos')->where('id', $ord_produccion->idUsuario)->get()->first();
        $idTetra = fibras::select('idFibra')->where('descripcion', 'like', '%Tetrapack%')->get()->first();

        /*$electricidad = electricidad::where('descripcion','like','%Tetrapack%')->get()->first();
        $consumo_agua = consumo_agua::where('descripcion','like','%Tetrapack%')->get()->first();*/

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

        if (count($mp_directa) > 0 && $totalMPTPACK->total != '') {
            $produccionNeta = $this->calcularProduccionNeta($idOP);
            $produccionBruta_ = $this->calcularProduccionBruta($idOP);
            $produccion_bruta = $produccionBruta_ + $produccionNeta->produccionNeta;
            $mermaYankeeDry = $this->calcularMermaYankeeDry($idOP);
            $residuosPulper = $this->calcularResiduosPulper($idOP);
            $lavadoraTetrapack = $this->calcularLavadoraTetrapack($idOP);
            $totalMP = $this->calcularTotalMP($idOP);
            $electricidad = $this->calcularElectricidad($idOP);
            $consumo_agua = $this->calcularConsumoAgua($idOP);

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


            /*$porcentMermaYankeeDry = ( $mermaYankeeDry->merma/($produccionNeta->produccionNeta+$mermaYankeeDry->merma) )*100;
            $porcentResiduosPulper = ($residuosPulper->residuo_pulper / $totalMP->mp_directa) * 100;
            $porcentLavadoraTetrapack = ($lavadoraTetrapack->lav_tetrapack / $totalMPTPACK->total) * 100;
            $factorFibral = (($totalMP->mp_directa - $lavadoraTetrapack->lav_tetrapack) / ($produccionNeta->produccionNeta + $mermaYankeeDry->merma));*/
        } else {
            $produccionNeta = $this->calcularProduccionNeta($idOP);
            $produccionBruta_ = $this->calcularProduccionBruta($idOP);
            $produccion_bruta = $produccionBruta_ + $produccionNeta->produccionNeta;
            $mermaYankeeDry = $this->calcularMermaYankeeDry($idOP);
            $residuosPulper = $this->calcularResiduosPulper($idOP);
            $lavadoraTetrapack = $this->calcularLavadoraTetrapack($idOP);
            $totalMP = $this->calcularTotalMP($idOP);
            $electricidad = $this->calcularElectricidad($idOP);
            $consumo_agua = $this->calcularConsumoAgua($idOP);

            //$factor_fibral = $this->calcularFactorFibral($idOP);


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
            $produccion_bruta,
            $mermaYankeeDry->merma,
            $residuosPulper->residuo_pulper,
            $lavadoraTetrapack->lav_tetrapack,
            number_format($porcentMermaYankeeDry, 2),
            number_format($porcentResiduosPulper, 2),
            number_format($porcentLavadoraTetrapack, 2),
            $electricidad,
            $consumo_agua,
            number_format($factorFibral, 2)

        );

        return view('User.Orden_Produccion.detalle', compact(['orden', 'mp_directa', 'mo_directa', 'quimico_maquina']));
    }

    public function crear()
    {
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
            ->where('mp_directa.numOrden', intval($idOrd->numOrden + 1))
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
            ->where('quimico_maquina.numOrden', intval($idOrd->numOrden + 1))
            ->get();

        return view('User.Orden_Produccion.crear', compact([
            'productos', 'usuarios',
            'idOrd', 'fibras', 'maquinas', 'mp_directa', 'quimicos', 'quimico_maquina'
        ]));
    }

    public function guardar(Request $request)
    {
        $messages = array(
            'required' => 'El :attribute es un campo requerido',
            'unique' => 'Ya existe una orden de trabajo para este turno'
        );

        $validator = Validator::make($request->all(), [
            'numOrden' => 'required|unique:orden_produccion',
            'producto' => 'required',
            'fecha01' => 'required|date',
            'fecha02' => 'required|date',
            'hora01' => 'required',
            'hora02' => 'required',
            'hrsTrabajadas' => 'required|digits_between:1,9|regex:/^[-0-9\+]+$/'
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        if ($request->hrsTrabajadas < 0) {
            return Redirect::back()->withErrors("Las horas trabajados no pueden ser menores a 0")->withInput();
        }
        if (date("Y-m-d", strtotime($request->fecha02)) < date("Y-m-d", strtotime($request->fecha01))) {
            return Redirect::back()->withErrors("La fecha final no puede ser menor a la fecha inicial")->withInput();
        }
        if (date("H:i", strtotime($request->hora02)) < date("H:i", strtotime($request->hora01))) {
            return Redirect::back()->withErrors("La hora final no puede ser menor a la hora inicial")->withInput();
        }


        $ordProd = new orden_produccion();
        $ordProd->producto = $request->producto;
        $ordProd->numOrden = $request->numOrden;
        $ordProd->idUsuario = $request->jefe;
        $ordProd->hrsTrabajadas = $request->hrsTrabajadas;
        $ordProd->fechaInicio = date("Y-m-d", strtotime($request->fecha01));
        $ordProd->fechaFinal = date("Y-m-d", strtotime($request->fecha02));
        $ordProd->horaInicio = date("H:i", strtotime($request->hora01));
        $ordProd->horaFinal = date("H:i", strtotime($request->hora02));
        $ordProd->estado = 1;
        $ordProd->save();

        return redirect()->route('orden-produccion');
    }

    public function editar($idOP)
    {
        $fibras = array();
        $quimicos = array();
        $i = 0;
        $usuarios = usuario::usuarioByRole();
        $orden = orden_produccion::where('numOrden', $idOP)->where('estado', 1)->get();
        $productos = productos::where('estado', 1)->get();
        $fibras = fibras::where('estado', 1)->orderBy('idFibra', 'asc')->get();
        $quimicos = Quimicos::where('estado', 1)->orderBy('idQuimico', 'asc')->get();
        $maquinas = maquinas::where('estado', 1)->orderBy('idMaquina', 'asc')->get();
        $mp_directa = mp_directa::where('numOrden', $idOP)->get();
        //$quimico_maquina = QuimicoMaquina::where('numOrden', $idOP)->get();
        $quimico_maquina = QuimicoMaquina::select(
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

        return view('User.Orden_Produccion.editar', compact(
            'orden',
            'mp_directa',
            'usuarios',
            'fibras',
            'productos',
            'maquinas',
            'quimicos',
            'quimico_maquina'
        ));
    }

    public function actualizar(Request $request)
    {
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
            'hrsTrabajadas' => 'required|digits_between:1,9'
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
            $t_lavado_dia = ($t_lavado->cantDia * $t_pulpeo->tiempoPulpeo) / 60;
            $t_lavado_noche = ($t_lavado->cantNoche * $t_pulpeo->tiempoPulpeo) / 60;
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

    public function calcularProduccionBruta($numOrden)
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

        return $merma_yankee_dry + $lavadora_tetrapack + $residuo_pulper;
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
                'total' => number_format(($final - $inicial) * 560, 2)
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

        $response = mp_directa::where('id', $id)->delete();

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
            $numOrden = intval($request->input('codigo'));
            $consumoInicialElec = ($request->input('consumoInicialElec') == '') ? 0 : $request->input('consumoInicialElec');
            $consumoFinalElec = ($request->input('consumoFinalElec') == '') ? 0 : $request->input('consumoFinalElec');
            $consumoInicialAgua = ($request->input('consumoInicialAgua') == '') ? 0 : $request->input('consumoInicialAgua');
            $consumoFinalAgua = ($request->input('consumoFinalAgua') == '') ? 0 : $request->input('consumoFinalAgua');

            $electricidad = electricidad::where('numOrden', $numOrden)->get()->toArray();
            $consumoAgua = consumo_agua::where('numOrden', $numOrden)->get()->toArray();

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
        }

        return response()->json(true);
    }

    public function guardarMP(Request $request)
    {
        $i = 0;
        $numOrden = intval($request->input('codigo'));

        if ($request->isMethod('post')) {
            $array = array();

            foreach ($request->input('data') as $key) {
                if ($key['maquina'] !== 'undefined' && $key['fibra'] !== 'undefined' && $key['cantidad'] !== 'undefined') {
                    $array[$i]['numOrden'] = $key['orden'];
                    $array[$i]['idMaquina'] = $key['maquina'];
                    $array[$i]['idFibra'] = $key['fibra'];
                    $array[$i]['cantidad'] = $key['cantidad'];
                    $i++;
                }
            }
            if (count($array) > 0) {
                mp_directa::where('numOrden', $numOrden)->delete();
                $response = mp_directa::insert($array);
            } else {
                return response()->json(false);
            }

            return response()->json($response);
        }
    }

    public function guardarQM(Request $request)
    {
        $i = 0;
        $numOrden = intval($request->input('codigo'));

        if ($request->isMethod('post')) {
            $array = array();

            foreach ($request->input('data') as $key) {
                if ($key['maquina'] !== 'undefined' && $key['quimico'] !== 'undefined' && $key['cantidad'] !== 'undefined') {
                    $array[$i]['numOrden'] = $key['orden'];
                    $array[$i]['idMaquina'] = $key['maquina'];
                    $array[$i]['idQuimico'] = $key['quimico'];
                    $array[$i]['cantidad'] = $key['cantidad'];
                    $i++;
                }
            }
            if (count($array) > 0) {
                QuimicoMaquina::where('numOrden', $numOrden)->delete();
                $response = QuimicoMaquina::insert($array);
            } else {
                return response()->json(false);
            }

            return response()->json($response);
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

    public function cargarQuimico($idOrd)
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

        $response = QuimicoMaquina::where('id', $id)->delete();

        return response()->json($response);
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
    public $produccionReal;
    public $mermaYankeeDry;
    public $residuosPulper;
    public $lavadoraTetrapack;
    public $porcentMermaYankeeDry;
    public $porcentResiduosPulper;
    public $porcentLavadoraTetrapack;
    public $electricidad;
    public $consumoAgua;
    public $factorFibral;

    public function __construct($idOrden, $numOrden, $producto, $usuario, $hrsTrabajadas, $fechaInicio, $fechaFinal, $horaInicio, $horaFinal, $produccionNeta, $produccionReal, $mermaYankeeDry, $residuosPulper, $lavadoraTetrapack, $porcentMermaYankeeDry, $porcentResiduosPulper, $porcentLavadoraTetrapack, $electricidad, $consumoAgua, $factorFibral)
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
        $this->produccionReal = $produccionReal;
        $this->mermaYankeeDry = $mermaYankeeDry;
        $this->residuosPulper = $residuosPulper;
        $this->lavadoraTetrapack = $lavadoraTetrapack;
        $this->porcentMermaYankeeDry = $porcentMermaYankeeDry;
        $this->porcentResiduosPulper = $porcentResiduosPulper;
        $this->porcentLavadoraTetrapack = $porcentLavadoraTetrapack;
        $this->electricidad = $electricidad;
        $this->consumoAgua = $consumoAgua;
        $this->factorFibral = $factorFibral;
    }
}

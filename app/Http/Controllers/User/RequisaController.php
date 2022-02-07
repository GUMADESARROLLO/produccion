<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DetalleRequisa;
use App\Models\fibras;
use App\Models\orden_produccion;
use App\Models\Quimicos;
use App\Models\Turno;
use App\Models\usuario_rol;
use Illuminate\Http\Request;
use App\Models\Requisa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class RequisaController extends Controller
{
    /**
     * Constructor de la clase con inyeccion de dependencias
     */
    protected $requisas;

    public function __construct(Requisa $requisas)
    {
        $this->middleware('auth');
        $this->requisas = $requisas;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requisas = $this->requisas->obtenerRequisas();
        return view('User.Requisas.index', compact('requisas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($idOP)
    {
        $orden = orden_produccion::where('estado', 1)->where('numOrden', $idOP)->orderBy('idOrden', 'asc')->get();
        //$jefe = usuario_rol::where('estado',1)->where('rol_id',5)->get();
        $jefe = DB::select(('select u.id ,u.nombres, u.apellidos
                                    from users u
                                    join usuario_rol ur
                                    on u.id = ur.usuario_id
                                    where ur.rol_id = 5
                                    order by u.nombres asc ;'));
        $turno = Turno::all();
        return view('User.Requisas.nuevo', compact(['orden', 'jefe', 'turno']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $orden = $request['num_Orden'];
        $messages = array(
            'required' => ':attribute es un campo requerido',
            'numeric' => 'El :attribute campo debe ser númerico',
        );
        $validator = Validator::make($request->all(), [
            'numOrden' => 'required',
            'codigo_req' => 'required',
            'jefe_turno' => 'required',
            'id_turno' => 'required',
            'flexRadioDefault' => 'required|in:1,2'

        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        } else {
            //dd($request);
            $requisa = new Requisa();
            $requisa->numOrden = $request->numOrden;
            $requisa->codigo_req = $request->codigo_req;
            $requisa->jefe_turno = $request->jefe_turno;
            $requisa->turno = $request->id_turno;
            $requisa->tipo = $request->flexRadioDefault;
            $requisa->estado = 1;
            $requisa->save();
            return redirect()->back()->with('message-success', 'Se creo la Orden de Produccion con exito :)');
        }
        return  0;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $requisa = $this->requisas->obtenerRequisaPorId($id);
        return view('User.Requisas.detalle', ['requisa' => $requisa]);
    }

    public function edit($id)
    {
        $requisa = $this->requisas->obtenerRequisaPorId($id);
        $jefe = DB::select(('select u.id ,u.nombres, u.apellidos
                                    from users u
                                    join usuario_rol ur
                                    on u.id = ur.usuario_id
                                    where ur.rol_id = 5
                                    order by u.nombres asc ;'));
        $turno = Turno::all();
        return view('User.Requisas.editar', compact(['requisa', 'jefe', 'turno']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $messages = array(
            'required' => ':attribute es un campo requerido',
        );

        $validator = Validator::make($request->all(), [
            'numOrden' => 'required',
            'codigo_req' => 'required',
            'jefe_turno' => 'required',
            'id_turno' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        requisa::where('id', $id)
            ->update([
                'jefe_turno' => $request->jefe_turno,
                'turno' => $request->id_turno,

            ]);

        return redirect()->action(RequisaController::class, 'index')
            ->with('message-success', 'Se edito con exito :)');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function guardarDetalleReq(Request $request)
    {

        $obj = DetalleRequisa::guardarDetalleReq($request->input('data'));
        return response()->json($obj);
    }

    public function actualizarDetalleReq(Request $request)
    {

        $obj = DetalleRequisa::actualizarDetalleReq($request->input('data'));
        return response()->json($obj);
    }


    public function getDetalleReq($cod_requisa, $tipo)
    {
        $Requisado = array();
        $obj = DetalleRequisa::where('requisa_id', $cod_requisa)->get();
        $i = 0;
        if ($tipo == 1) { //Fibra
            foreach ($obj as $detalleRequisa) {
                $fibras = fibras::where('idFibra', $detalleRequisa['elemento_id'])->get();
                foreach ($fibras as $f) {
                    $Requisado[$i]['id'] =     $f['idFibra'];
                    $Requisado[$i]['codigo'] =      $f['codigo'];
                    $Requisado[$i]['descripcion'] = $f['descripcion'];
                    $Requisado[$i]['unidad'] = $f['unidad'];
                    $Requisado[$i]['cantidad'] =    $detalleRequisa['cantidad'];
                    $i++;
                }
            }
        } else {
            foreach ($obj as $detalleRequisa) {
                $quimicos = Quimicos::where('idQuimico', $detalleRequisa['elemento_id'])->get();
                foreach ($quimicos as $q) {
                    $Requisado[$i]['id'] =          $q['idQuimico'];
                    $Requisado[$i]['codigo'] =      $q['codigo'];
                    $Requisado[$i]['descripcion'] = $q['descripcion'];
                    $Requisado[$i]['unidad'] =      $q['unidad'];
                    $Requisado[$i]['cantidad'] =    $detalleRequisa['cantidad'];
                    $i++;
                }
            }
        }
        //->where('tipo', $tipo)->get();
        return response()->json($Requisado);
    }
}

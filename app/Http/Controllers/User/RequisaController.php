<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DetalleRequisa;
use App\Models\orden_produccion;
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


    public function index()
    {
        $requisas = $this->requisas->obtenerRequisas();
        return view('User.Requisas.index', compact('requisas'));
    }


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


    public function store(Request $request)
    {

        $orden = $request['num_Orden'];
        $messages = array(
            'required' => ':attribute es un campo requerido',
            'numeric' => 'El :attribute campo debe ser númerico',
        );

        $validator = Validator::make($request->all(), [
            'numOrden' => 'required',
            'codigo_req' => 'required',
            'jefe_turno' => 'required',
            'id_turno' => 'required'
        ], $messages);

        $requisa_repetida = Requisa::where('numOrden', '=', $request['num_Orden'])->where('codigo_req', '=', $request['codigo_req'])->first();

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        if ($requisa_repetida)
        {
            return redirect()->back()->with('message-failed', 'No se guardo con exito :(, es una requisa duplicada, por favor elija otra');
        } else
                {
                    //dd($request);
                    $requisa = new Requisa();
                    $requisa->numOrden = $request->numOrden;
                    $requisa->codigo_req = $request->codigo_req;
                    $requisa->jefe_turno = $request->jefe_turno;
                    $requisa->turno = $request->id_turno;
                    $requisa->tipo = $request->tipo;
                    $requisa->estado = 1;
                    $requisa->save();
                    //return redirect()->back()->with('message-success', 'Se creo la Requisa con exito :)');
                    $data = Requisa::latest('id');
                }
    }


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


    public function destroy($id)
    {
        //
    }

    public function guardarDetalleReq(Request $request)
    {
        //$requisa = $request->input('dataR');
        //$requisa = $this->store($request->input('dataDR'));
        //return response()->json($requisa);
        // Guardar Requisa

        $obj = DetalleRequisa::guardarDetalleReq($request->input('dataDR'));
        return response()->json($obj);
    }
    public function actualizarDetalleReq(Request $request)
    {
        $obj = DetalleRequisa::actualizarDetalleReq($request->input('data'));
        return response()->json($obj);
    }
    public function getFibreReq($codigo)
    {
        $obj = DetalleRequisa::where('requisa_id', $codigo)->get();
        return response()->json($obj);
    }

    public function getQuimicoReq($codigo)
    {
        $obj = DetalleRequisa::where('requisa_id', $codigo)->get();
        return response()->json($obj);
    }

}

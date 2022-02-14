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
use Exception;
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
            'id_turno' => 'required',
            'flexRadioDefault' => 'required|in:1,2'

        ], $messages);

        $requisa_repetida = Requisa::where('numOrden', '=', $request['num_Orden'])->where('codigo_req', '=', $request['codigo_req'])->first();

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        if ($requisa_repetida) {
            return redirect()->back()->with('message-failed', 'No se guardo con exito :(, es una requisa duplicada, por favor elija otra');
        } else {
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


        $numOrden   =   $request->input('numOrden');
        $codigo_req =   $request->input('codigo_req');
        $jefe_turno =   $request->input('jefe_turno');
        $id_turno      =   $request->input('id_turno');
        $tipo       =   $request->input('tipo');

        $requisa_repetida = Requisa::where('numOrden', '=',  $numOrden)->where('codigo_req', '=', $codigo_req)->first();
        if ($requisa_repetida) {
            return redirect()->back()->with('message-failed', 'No se guardo con exito :(, es una requisa duplicada, por favor elija otra');
        } else {
            //dd($request);
            try {
                $requisa = new Requisa();
                $requisa->numOrden =  $numOrden;
                $requisa->codigo_req = $codigo_req;
                $requisa->jefe_turno = $jefe_turno;
                $requisa->turno = $id_turno;
                $requisa->tipo = $tipo;
                $requisa->estado = 1;
                $requisa->save();
                //return redirect()->back()->with('message-success', 'Se creo la Requisa con exito :)');
                $obj = DetalleRequisa::guardarDetalleReq($request->input('dataDR'));
              
                return response()->json($obj);

            } catch (Exception $e) {
                $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";

                return response()->json($mensaje );
            }
        }
    }

    public function actualizarDetalleReq(Request $request)
    {
        $obj = DetalleRequisa::actualizarDetalleReq($request->input('data'));
        return response()->json($obj);
    }


    public function getDetalleReq($cod_requisa, $tipo)
    {
        $obj = DetalleRequisa::getDetalleReq($cod_requisa, $tipo);
        return response()->json($obj);
    }

    public function getRequisas()
    {
        $requisas = $this->requisas->obtenerRequisas();

        return response()->json($requisas);
    }

    public function updateRequisa(Request $request)
    {

        $numOrden   =   $request->input('numOrden');
        $codigo_req =   $request->input('codigo_req');
        $jefe_turno =   $request->input('jefe_turno');
        $turno      =   $request->input('turno');
        $id_req     =   $request->input('id_req');
        $tipo       =   $request->input('tipo');
        $data       =   $request->input('arrayDR');

        try {

            $requisa_ = requisa::where('id', $id_req)
                ->update([
                    'jefe_turno' =>  $jefe_turno,
                    'turno' => $turno,

                ]);
            foreach ($data as $dataDR) {
                $id_DR = $dataDR["id"];
                $cantidad =  $dataDR["cantidad"];
                $codigo_req =  $dataDR["requisa_id"];
                $elemento_id =  $dataDR["elemento_id"];                //actualizar detalles de la requisa
                DB::select('call inn_requisas_update("' .   $numOrden . '", "' . $id_DR  . '",
                "' . $codigo_req . '","' .  $tipo  . '","' .  $elemento_id  . '","' .  $cantidad  . '")');
            };

            return response()->json($requisa_);
        } catch (Exception $e) {

            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
        //  DB::select('call inn_requisas_update()');
        // return "llego hasta aqui";
    }
}

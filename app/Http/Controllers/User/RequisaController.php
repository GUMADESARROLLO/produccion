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

    public function __construct( Requisa $requisas)
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
        $orden = orden_produccion::where('estado', 1)->where('numOrden',$idOP)->orderBy('idOrden', 'asc')->get();
        //$jefe = usuario_rol::where('estado',1)->where('rol_id',5)->get();
        $jefe = DB::select(('select u.id ,u.nombres, u.apellidos
                                    from users u
                                    join usuario_rol ur
                                    on u.id = ur.usuario_id
                                    where ur.rol_id = 5
                                    order by u.nombres asc ;'));
        $turno = Turno::all();
        return view('User.Requisas.nuevo', compact(['orden','jefe', 'turno']));
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
            'id_turno' => 'required'
        ], $messages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        } else {
            //dd($request);
            $requisa = new Requisa();
            $requisa->numOrden = $request->numOrden;
            $requisa->codigo_req = $request->codigo_req;
            $requisa->jefe_turno = $request->jefe_turno;
            $requisa->turno = $request->id_turno;
            $requisa->tipo = $request->tipo;
            $requisa->estado=1;
            $requisa->save();
            return redirect()->action([RequisaController::class, 'index'])
                ->with('message-success', 'Se guardo con exito :)');
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
        return view('User.Requisas.detalle', ['requisa' =>$requisa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        return view('User.Requisas.editar', compact(['requisa','jefe', 'turno']));
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

    public function guardarDetalleReq(Request $request){

     // $detail_requisa =  new detalle_requisa();
     // $tipo_requisa = intval($request->input('type'));

        $obj = DetalleRequisa::guardarDetalleReq($request);
        return response()->json($obj);
       /* return response()->json($response);
        $obj = inventario_model::getCostosArticulos($articulo);*/
		//return response()->json($obj);
    }
}

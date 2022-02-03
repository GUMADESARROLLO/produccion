<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\orden_produccion;
use App\Models\Turno;
use Illuminate\Http\Request;
use App\Models\Requisa;
use App\Models\detalle_requisas;
use Illuminate\Support\Facades\DB;

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
    public function create()
    {
        $orden = orden_produccion::all();
        $turno = Turno::all();
        return view('User.Requisas.nuevo', compact(['orden', 'turno']));
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
        //dd($request);
        $requisa = new Requisa($request->all());
        //$requisa->estado=1;
        $requisa->save();
        return redirect()->action([RequisaController::class, 'index'])
            ->with('message-success', 'Se guardo con exito :)');
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
        //
        $requisa = $this->requisas->obtenerRequisaPorId($id);
        return view('User.Requisas.editar', ['requisa' =>$requisa]);
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
        $requisa = Requisa::find($id);

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
     
        $obj = detalle_requisas::guardarDetalleReq($request->input('data'));
        return response()->json($obj);

    }
   
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\fibras;
use App\Models\Logs_access;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class fibrasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $fibras = fibras::where('estado', 1)->orderBy('idFibra', 'asc')->get();
        return view('User.Fibras.index', compact('fibras'));
    }

    public function nuevaFibra() {
        return view('User.Fibras.nuevo');
    }

    public function guardarFibra(Request $request) {
        $messages = array(
            'required' => 'El :attribute es un campo requerido',
            'unique' => 'El :attribute es un dato unico'
        );

        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|max:100',
            'codigo'        => 'required|max:20|unique:fibras',
            'unidad'        => 'required|max:20'
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $fibras = new fibras();
        $fibras->descripcion = $request->descripcion;
        $fibras->codigo = $request->codigo;
        $fibras->unidad = $request->unidad;
        $fibras->estado = 1;
        $fibras->save();

        return redirect()->back()->with('message-success', 'Se guardo la fibra con exito :)');
    }

    public function editarFibras($idFibra) {
        
        Logs_access::add("orden-produccion/editarFibras");

        $fibra  = fibras::where('idFibra', $idFibra)->where('estado', 1)->get()->toArray();
        return view('User.Fibras.editar', compact(['fibra']));
    }

    public function actualizarFibras(Request $request) {

        $messages = array(
            'required' => 'El :attribute es un campo requerido'
        );

        $validator = Validator::make($request->all(), [
            'idFibra' => 'required',
            'codigo' => 'required|max:20',
            'nombre' => 'required|max:100',
            'unidad' => 'required|max:100'
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        fibras::where('idFibra', $request->idFibra)
        ->update([
            'codigo'               => $request->codigo,
            'descripcion'          => $request->nombre,
            'unidad'               => $request->unidad
        ]);

        return redirect()->back()->with('message-success', 'Se actualizo la fibra con exito :)');
    }

    public function eliminarFibras($idFibra) {
        fibras::where('idFibra', $idFibra)
        ->update([
            'estado' => 0
        ]);

        return (response()->json(true));
    }

    public function getFibras() {
        $fibras = fibras::where('estado', 1)->get();

        return response()->json($fibras);
    }
}

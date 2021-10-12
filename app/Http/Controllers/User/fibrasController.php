<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\fibras;
use Illuminate\Support\Facades\Validator;
use Redirect;
use DB;

class fibrasController extends Controller {
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
            'required' => 'El :attribute es un campo requerido'
        );

        $validator = Validator::make($request->all(), [
            'descripcion' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $fibras = new fibras();
        $fibras->descripcion = $request->descripcion;
        $fibras->estado      = 1;
        $fibras->save();

        return redirect()->back()->with('message-success', 'Se guardo con exito :)');
    }

    public function editarFibras($idFibra) {
        $fibra  = fibras::where('idFibra', $idFibra)->where('estado', 1)->get()->toArray();
        return view('User.Fibras.editar', compact(['fibra']));
    }

    public function getFibras() {
        $fibras = fibras::where('estado', 1)
                    ->get();
        
        return response()->json($fibras);
    }

    public function actualizarFibras(Request $request) {
        $messages = array(
            'required' => 'El :attribute es un campo requerido'
        );

        $validator = Validator::make($request->all(), [
            'idFibra' => 'required',
            'nombre' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        fibras::where('idFibra', $request->idFibra)
        ->update([
            'descripcion'          => $request->nombre
        ]);

        return redirect()->back()->with('message-success', 'Se actualizo el producto con exito :)');
    }

    public function eliminarFibras($idFibra) {
        fibras::where('idFibra', $idFibra)
        ->update([
            'estado' => 0
        ]);

        return (response()->json(true));
    }
}

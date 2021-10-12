<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\maquinas;
use Illuminate\Support\Facades\Validator;
use Redirect;

class maquinasController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $maquinas = maquinas::where('estado', 1)->orderBy('idMaquina', 'asc')->get();
        return view('User.Maquinas.index', compact('maquinas'));
    }

    public function nueva() {
        return view('User.Maquinas.nueva');
    }

    public function guardar(Request $request) {
        $messages = array(
            'required' => 'El :attribute es un campo requerido'
        );

        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $maquinas = new maquinas();
        $maquinas->nombre = $request->nombre;
        $maquinas->estado      = 1;
        $maquinas->save();

        return redirect()->back()->with('message-success', 'Se guardo con exito :)');
    }

    public function editar($idMaquina) {
        $maquina  = maquinas::where('idMaquina', $idMaquina)->where('estado', 1)->get()->toArray();
        return view('User.Maquinas.editar', compact(['maquina']));
    }

    public function actualizar(Request $request) {
        $messages = array(
            'required' => 'El :attribute es un campo requerido'
        );

        $validator = Validator::make($request->all(), [
            'idMaquina' => 'required',
            'nombre' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        maquinas::where('idMaquina', $request->idMaquina)
        ->update([
            'nombre' => $request->nombre
        ]);

        return redirect()->back()->with('message-success', 'Se actualizo el nombre de la Maquina con exito :)');
    }

    public function eliminar($idMaquina) {
        maquinas::where('idMaquina', $idMaquina)
        ->update([
            'estado' => 0
        ]);

        return (response()->json(true));
    }
}

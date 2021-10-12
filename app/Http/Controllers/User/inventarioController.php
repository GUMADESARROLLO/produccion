<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;

class inventarioController extends Controller {
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function insumos()
    {
        $insumos = inventario::where('estado', 1)->orderBy('idInventario', 'asc')->get();
        return view('User.Insumos.index', compact('insumos'));
    }

    public function inventario()
    {
        $insumos = inventario::where('estado', 1)->orderBy('idInventario', 'asc')->get();
        return view('User.Inventario.nuevo', compact('insumos'));
    }

    public function nuevo() {
        return view('User.Insumos.nuevo');
    }

    public function guardar(Request $request) {
        $messages = array(
            'required' => 'La :attribute es un campo requerido',
            'email' => 'The :attribute field is required',
            'unique' => 'Ya existe un insumo con este codigo'
        );


        $validator = Validator::make($request->all(), [
            'codigo' => 'required|unique:inventario',
            'descripcion' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $inventario = new inventario();
        $inventario->codigo       = $request->codigo;
        $inventario->descripcion  = $request->descripcion;
        $inventario->estado       = 1;
        $inventario->save();

        return redirect()->back()->with('message-success', 'Se guardo con exito :)');
    }

}

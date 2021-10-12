<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\productos;
use App\Models\turnos;
use App\Models\maquinas;
use App\Models\Admin\Rol;
use Illuminate\Support\Facades\Validator;
use Redirect;

class produccionController extends Controller {

    public function productos() {
        $productos   = productos::where('estado', 1)->orderBy('idProducto', 'asc')->get();
        return view('User.Productos.index', compact('productos'));
    }

    public function nuevo() {
        return view('User.Productos.nuevo');
    }

    public function guardarProducto(Request $request) {
        $messages = array(
            'required' => 'El :attribute es un campo requerido'
        );

        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $productos = new productos();
        $productos->nombre  = $request->nombre;
        $productos->estado  = 1;
        $productos->save(); 

        return redirect()->back()->with('message-success', 'Se guardo con exito :)');
    }

    public function editarProducto($idProducto) {
        $producto  = productos::where('idProducto', $idProducto)->where('estado', 1)->get()->toArray();
        return view('User.Productos.editar', compact(['producto']));
    }

    public function actualizarProducto(Request $request) {
        $messages = array(
            'required' => 'El :attribute es un campo requerido'
        );

        $validator = Validator::make($request->all(), [
            'idProducto' => 'required',
            'nombre' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        productos::where('idProducto', $request->idProducto)
        ->update([
            'nombre'          => $request->nombre
        ]);

        return redirect()->back()->with('message-success', 'Se actualizo el producto con exito :)');
    }

    public function eliminarProducto($idProducto) {
        productos::where('idProducto', $idProducto)
        ->update([
            'estado' => 0
        ]);

        return (response()->json(true));
    }
}

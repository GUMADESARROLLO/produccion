<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Costo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
//use Redirect;

class CostoController extends Controller
{
    public function costos() {
        $costo   = costo::where('estado', 1)->orderBy('id', 'asc')->get();
        return view('User.Costo.index', compact('costo'));
    }

    public function nuevoCosto() {
        return view('User.Costo.nuevo');
    }

    public function guardarCosto(Request $request) {
        $messages = array(
            'required' => 'El :attribute es un campo requerido'
        );

        /*$validator = Validator::make($request->all(), [
            'descripcion' => 'required',
            'unidad_medida' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }*/

        $costo = new costo();
        $costo->codigo  = $request->codigocosto;
        $costo->descripcion  = $request->descripcioncosto;
        $costo->unidad_medida  = $request->unidadmedidacosto;
        $costo->estado  = 1;
        $costo->save();

        return redirect()->back()->with('message-success', 'Se guardo con exito :)');
    }

    public function editarCosto($id) {
        $costo  = costo::where('id', $id)->where('estado', 1)->get()->toArray();
        return view('User.Costo.editar', compact(['costo']));
    }

    public function actualizarCosto(Request $request) {
        $messages = array(
            'required' => 'El :attribute es un campo requerido'
        );

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'descripcion' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        costo::where('id', $request->id)
            ->update([
                'descripcion'          => $request->descripcion
            ]);

        return redirect()->back()->with('message-success', 'Se actualizo el producto con exito :)');
    }

}


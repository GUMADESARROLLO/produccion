<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Costo;
use App\Models\CostoOrden;
use App\Models\orden_produccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CostoOrdenController extends Controller
{
    public function index() {
        $costoOrden   = costoOrden::where('estado', 1)->orderBy('id', 'asc')->get();
        return view('User.CostoOrden.index', compact('costoOrden'));
    }

    public function nuevoCosto() {
        $ordenes = orden_produccion::where('estado', 1)->orderBy('idOrden', 'asc')->get();
        $costos = costo::where('estado', 1)->orderBy('id', 'asc')->get();
        return view('User.CostoOrden.nuevo', compact(['ordenes', 'costos']));
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

        $costoOrden = new costoOrden();
        $costoOrden->numOrden  = $request->codigocosto;
        $costoOrden->costo_id  = $request->costo_id;
        $costoOrden->cantidad  = $request->cantidad;
        $costoOrden->costo_unitario  = $request->costo_unitario;
        $costoOrden->estado  = 1;
        $costoOrden->save();

        return redirect()->back()->with('message-success', 'Se guardo con exito :)');
    }

    public function editarCosto($id) {
        $costo  = costo::where('id', $id)->where('estado', 1)->get()->toArray();
        return view('User.CostoOrden.editar', compact(['costo']));
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

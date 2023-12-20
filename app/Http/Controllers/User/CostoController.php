<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Costo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Logs_access;
//use Redirect;

class CostoController extends Controller
{
    public function index()
    {
        Logs_access::add("Costo/Home");
        $costo = costo::where('estado', 1)->orderBy('id', 'asc')->get();
        return view('User.Costo.index', compact('costo'));
    }

    public function nuevoCosto()
    {
        return view('User.Costo.nuevo');
    }

    public function guardarCosto(Request $request)
    {
        $messages = array(
            'required' => ':attribute es un campo requerido',
            'numeric' => 'El :attribute campo debe ser númerico',
            'digits_between'  => 'El valor de :attribute debe ser estar entre 1 y 11 digitos'

        );

        $validator = Validator::make($request->all(), [
            'codigocosto' => 'required',
            'descripcioncosto' => 'required',
            'unidadmedidacosto' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $costo = new costo();
        $costo->codigo = $request->codigocosto;
        $costo->descripcion = $request->descripcioncosto;
        $costo->unidad_medida = $request->unidadmedidacosto;
        $costo->estado = 1;
        $costo->save();

        return redirect()->back()->with('message-success', 'Se guardo con exito :)');
    }

    public function editarCosto($id)
    {
        Logs_access::add("Costo/Editar");
        $costo = costo::where('id', $id)->where('estado', 1)->get()->toArray();
        return view('User.Costo.editar', compact(['costo']));
    }

    public function actualizarCosto(Request $request)
    {
        $messages = array(
            'required' => ':attribute es un campo requerido',
            'digits_between'  => 'El campo debe ser númerico y estar entre 1 y 11 digitos'

        );

        $validator = Validator::make($request->all(), [
            'codigo' => 'required',
            'descripcion' => 'required',
            'unidad_medida' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        costo::where('id', $request->id)
            ->update([
                'codigo' => $request-> codigo,
                'descripcion' => $request->descripcion,
                'unidad_medida' => $request->unidad_medida
            ]);

        return redirect()->back()->with('message-success', 'Se actualizo el producto con exito :)');
    }
    public function getCostos()
    {
        $costo = costo::where('estado', 1)->orderBy('id', 'asc')->get();
        return response()->json($costo);
    }

}


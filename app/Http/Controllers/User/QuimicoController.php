<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Quimicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class QuimicoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $quimico = Quimicos::where('estado', 1)->orderBy('idQuimico', 'asc')->get();
        return view('User.Quimico.index', compact('quimico'));
    }

    public function nuevoQuimico()
    {
        return view('User.Quimico.nuevo');
    }

    public function guardarQuimico(Request $request)
    {

        $messages = array(
            'required' => 'El :attribute es un campo requerido'
        );

        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|max:100',
            'codigo'        => 'required|max:20'
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }


        $quimico = new Quimicos();
        $quimico->codigo  = $request->codigo;
        $quimico->descripcion  = $request->descripcion;
        $quimico->estado  = 1;
        $quimico->save();

        return redirect()->back()->with('message-success', 'Se guardo con exito :)');
    }

    public function editarQuimico($quimico)
    {

        $quimico  = Quimicos::where('idQuimico', $quimico)->where('estado', 1)->get()->toArray();
        return view('User.Quimico.editar', compact(['quimico']));
    }


    public function actualizarQuimico(Request $request)
    {

        $messages = array(
            'required' => 'El :attribute es un campo requerido'
        );

        $validator = Validator::make($request->all(), [
            'idQuimico' =>'required',
            'codigo' =>'required|max:20',
            'descripcion' => 'required|max:100'
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Quimicos::where('idQuimico', $request->idQuimico)
            ->update([
                'codigo'               => $request->codigo,
                'descripcion'          => $request->descripcion
            ]);

        return redirect()->back()->with('message-success', 'Se actualizo el producto con exito :)');
    }

    public function eliminarQuimico($idQuimico) {
        Quimicos::where('idQuimico', $idQuimico)
        ->update([
            'estado' => 0
        ]);

        return (response()->json(true));
    }

    public function getQuimicos() {
        $fibras = Quimicos::where('estado', 1)
            ->get();

        return response()->json($fibras);
    }
    //
}

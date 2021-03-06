<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\productos;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class produccionController extends Controller
{

    public function productos()
    {
        $productos = productos::where('estado', 1)->orderBy('idProducto', 'asc')->get();
        return view('User.Productos.index', compact('productos'));
    }

    public function nuevo()
    {
        return view('User.Productos.nuevo');
    }

    public function guardarProducto(Request $request)
    {
        $messages = array(
            'required' => 'El :attribute es un campo requerido',
            'unique' => 'El :attribute es un dato unico'
        );

        $validator = Validator::make($request->all(), [
            'codigo' => 'required|unique:productos',
            'nombre' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $success = false;
        try {
            DB::beginTransaction();
            $productos = new productos();
            $productos->codigo = $request->codigo;
            $productos->nombre = $request->nombre;
            $productos->descripcion = $request->descripcion;
            $productos->unidad = $request->unidad;
            $productos->estado = 1;
            $productos->save();

            $success = true;
            if ($success) {
                DB::commit();
            }
            //DB::commit();
            //return redirect()->back()->with('message-success', 'Se guardo con exito :)');
        } catch (Exception $e) {
            DB::rollback();
            $success = false;
            //return ["error" => $e->getMessage()];
            return redirect()->back()->with('message-error', 'Ocurrio un error');
            //$mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";

            //return response()->json($mensaje);
        }
        //return ["success" => "Data Inserted"];
        return redirect()->back()->with('message-success', 'Se guardo con exito :)');
    }

    public function editarProducto($idProducto)
    {
        $producto = productos::where('idProducto', $idProducto)->where('estado', 1)->get()->toArray();
        return view('User.Productos.editar', compact(['producto']));
    }

    public function actualizarProducto(Request $request)
    {
        $messages = array(
            'required' => ':attribute es un campo requerido'
        );

        $validator = Validator::make($request->all(), [
            'idProducto' => 'required',
            'codigo' => 'required',
            'nombre' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        productos::where('idProducto', $request->idProducto)
            ->update([
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'unidad' => $request->unidad
            ]);

        return redirect()->back()->with('message-success', 'Se actualizo el producto con exito :)');
    }

    public function eliminarProducto($idProducto)
    {
        productos::where('idProducto', $idProducto)
            ->update([
                'estado' => 0
            ]);

        return (response()->json(true));
    }

    public function getProductos() {
        $productos   = productos::where('estado', 1)->orderBy('idProducto', 'asc')->get();
        
        return response()->json($productos);
    }
}

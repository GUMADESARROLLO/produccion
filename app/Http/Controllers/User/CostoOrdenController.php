<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Costo;
use App\Models\CostoOrden;
use App\Models\DetalleOrden;
use App\Models\orden_produccion;
use App\Models\productos;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CostoOrdenController extends Controller
{
    public function index()
    {
        //$costoOrden = costoOrden::where('estado', 1)->orderBy('id', 'asc')->get();
        //return view('User.CostoOrden.index', compact('costoOrden'));
        //$orden_costo = DetalleCostoSubtotal::all()->sum('subtotal');
        $array = array();
        $i = 0;
        $ord_produccion = orden_produccion::where('estado', 1)->orderBy('numOrden', 'desc')->get();

        if (count($ord_produccion) > 0) {
            foreach ($ord_produccion as $key) {
                $array[$i]['idOrden'] = $key['idOrden'];
                $array[$i]['numOrden'] = $key['numOrden'];
                $fibra = productos::select('nombre')->where('idProducto', $key['producto'])->get()->first();

                $array[$i]['producto'] = $fibra->nombre;
                $array[$i]['fechaInicio'] = date('d/m/Y', strtotime($key['fechaInicio']));
                $array[$i]['fechaFinal'] = date('d/m/Y', strtotime($key['fechaFinal']));
                $array[$i]['estado'] = $key['estado'];
                $i++;
            }
        }
        return view('User.CostoOrden.index', compact(['array']));
    }

    public function detalleCostoOrden($idOP)
    {
        $costoOrden = costoOrden::where('numOrden', $idOP)->orderBy('id', 'asc')->get();
        $ordenes = orden_produccion::where([['numOrden',$idOP], ['estado', 1]])->orderBy('idOrden', 'asc')->get();
        //dd($costoOrden);
        return view('User.CostoOrden.detalle', compact(['costoOrden', 'ordenes']));
    }

    public function nuevoCostoOrden()
    {
        $ordenes = orden_produccion::where('estado', 1)->orderBy('idOrden', 'asc')->get();
        $costos = costo::where('estado', 1)->orderBy('id', 'asc')->get();
        return view('User.CostoOrden.nuevo', compact(['ordenes', 'costos']));
    }

    public function guardarCostoOrden(Request $request)
    {
        $messages = array(
            'required' => 'El :attribute es un campo requerido',
            'numeric' => ':attribute debe ser un valor númerico'
        );

        $validator = Validator::make($request->all(), [
            'cantidad' => 'required|numeric|digits_between:1,9',
            'costo_unitario' => 'required|numeric|digits_between:1,9'
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        if (CostoOrden::where('numOrden', '=', $request['num_Orden'])
            ->where('costo_id', '=', $request['costo_orden'])->first()
        ) {
            return redirect()->back()->with('message-failed', 'No se guardo con exito :(, es un costo duplicado, por favor elija otro costo');
        } else {

            $costoOrden = new costoOrden();
            $costoOrden->numOrden = $request->num_Orden;
            $costoOrden->costo_id = $request->costo_orden;
            $costoOrden->cantidad = $request->cantidad;
            $costoOrden->costo_unitario = $request->costo_unitario;
            $costoOrden->estado = 1;
            $costoOrden->save();

            /*$array = [
        'numOrden' => $request->num_Orden,
        'costo_id' => $request->costo_orden,
        'cantidad' => $request->cantidad,
        'costo_unitario' => $request->costo_unitario,
            'estado' => 1
    ];
        CostoOrden::insertOrIgnore($array);*/

            return redirect()->back()->with('message-success', 'Se guardo con exito :)');
        }
    }

    public function editarCostoOrden($id)
    {
        $costoOrden = costoOrden::where('id', $id)->where('estado', 1)->get()->toArray();
        $ordenes = orden_produccion::where('estado', 1)->orderBy('idOrden', 'asc')->get();
        $costos = costo::where('estado', 1)->orderBy('id', 'asc')->get();
        return view('User.CostoOrden.editar', compact(['costoOrden', 'ordenes', 'costos']));
    }

    public function actualizarCostoOrden(Request $request)
    {
        $messages = array(
            'required' => 'El :attribute es un campo requerido',
            'numeric' => ':attribute debe ser un valor númerico'

        );

        $validator = Validator::make($request->all(), [
            'cantidad' => 'required|numeric|digits_between:1,9',
            'costo_unitario' => 'required|numeric|digits_between:1,9'
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        costoOrden::where('id', $request->id)
            ->update([
                'numOrden' => $request->num_Orden,
                'costo_id' => $request->costo_orden,
                'cantidad' => $request->cantidad,
                'costo_unitario' => $request->costo_unitario
            ]);

        return redirect()->back()->with('message-success', 'Se actualizo el costo de la orden con exito :)');
    }

    public function guardarHrasProd(Request $request)
    {

        $numOrden = intval($request->input('codigo'));

        orden_produccion::where('numOrden', $numOrden)
            ->update([
                'horaJY1'    => intval($request->input('horaJY1')),
                'horaJY2'    => intval($request->input('horaJY2')),
                'horaLY1'    => intval($request->input('horaLY1')),
                'horaLY2'    => intval($request->input('horaLY2'))
            ]);

        return redirect()->back()->with('message-success', 'Se agregaron las horas producidas :)');
    }

    public function guardarComment(Request $request)
    {
        $messages = array(
            'required' => 'El :attribute es un campo requerido',
        );

        $validator = Validator::make($request->all(), [
            'Orden' => 'required',
            'comentario' => 'required|max:200',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        orden_produccion::where('numOrden', $request->Orden)
            ->update([
                'numOrden'      => $request->Orden,
                'comentario'    => $request->comentario
            ]);

        return redirect()->back()->with('message-success', 'Comnetario agregado exitosamente)');
    }
}

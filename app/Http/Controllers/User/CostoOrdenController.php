<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Costo;
use App\Models\CostoOrden;
use App\Models\DetalleOrden;
use App\Models\TipoCambio;
use App\Models\orden_produccion;
use App\Models\DetalleCostoSubtotal;
use App\Models\Logs_access;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CostoOrdenController extends Controller
{
    public function index()
    {
        return view('User.CostoOrden.index');
        //return response()->json($array);
    }

    public function detalleCostoOrden($idOP)
    {
        $costoOrdenL = DB::select(('select costo_orden.id, costo_orden.numOrden, costo_orden.costo_id,
                                    costo.unidad_medida,  costo.descripcion, costo_orden.cantidad,
                                    costo_orden.costo_unitario
                                    from costo_orden
                                    inner join costo on costo_orden.costo_id = costo.id
                                    where costo_orden.numOrden = :orden
                                    order by costo_id asc'), array('orden' => $idOP));

        $costoOrden = costoOrden::where('numOrden', $idOP)->orderBy('id', 'asc')->get();
        $ordenes = orden_produccion::where([['numOrden', $idOP], ['estado', 1]])->orderBy('idOrden', 'asc')->get();
        $detalle_orden = DetalleCostoSubtotal::where('numOrden', $idOP)->sum('subtotal');
        $TipoCambio = orden_produccion::where([['numOrden', $idOP], ['estado', 1]])->pluck('tipo_cambio')->first();

        return view('User.CostoOrden.detalle', compact(['costoOrdenL', 'ordenes', 'costoOrden', 'detalle_orden', 'TipoCambio']));
    }

    public function nuevoCostoOrden($idOP)
    {
        $ordenes = orden_produccion::where('estado', 1)->where('numOrden', $idOP)->orderBy('idOrden', 'asc')->get();
        $costos = costo::where('estado', 1)->orderBy('id', 'asc')->get();
        return view('User.CostoOrden.nuevo', compact(['ordenes', 'costos']));
    }

    public function guardarCostoOrden(Request $request)
    {
        $orden = $request['num_Orden'];

        $messages = array(
            'required' => 'El :attribute es un campo requerido',
            'numeric' => ':attribute debe ser un valor númerico'
        );

        $validator = Validator::make($request->all(), [
            'cantidad' => 'required|numeric',
            'costo_unitario' => 'required|numeric'
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        if (CostoOrden::where('numOrden', '=', $request['num_Orden'])->where('costo_id', '=', $request['costo_orden'])->first()) {
            return redirect()->back()->with('message-failed', 'No se guardo con exito :(, es un costo duplicado, por favor elija otro costo');
        } else {
            $costoOrden = new costoOrden();
            $costoOrden->numOrden = $request->num_Orden;
            $costoOrden->costo_id = $request->costo_orden;
            $costoOrden->cantidad = $request->cantidad;
            $costoOrden->costo_unitario = $request->costo_unitario;
            $costoOrden->estado = 1;
            $costoOrden->save();
            //return redirect()->back()->with('message-success', 'Se guardo con exito :)');
            return redirect('/costo-orden/detalle/' . $request->num_Orden);
        }
    }

    public function editarCostoOrden($id)
    {
        Logs_access::add("Costo-orden/Editar");
        //$costoOrden = costoOrden::where('id', $id)->where('estado', 1)->get()->toArray();
        //$ordenes = orden_produccion::where('estado', 1)->orderBy('idOrden', 'asc')->get();
        //$costos = costo::where('estado', 1)->orderBy('id', 'asc')->get();
        $costoOrden = DB::select(('select costo_orden.id, costo_orden.numOrden, costo_orden.costo_id,
                                    costo.unidad_medida,  costo.descripcion, costo_orden.cantidad,
                                    costo_orden.costo_unitario
                                    from costo_orden
                                    inner join costo on costo_orden.costo_id = costo.id
                                    where costo_orden.id = :id
                                    order by costo_id asc'), array('id' => $id));
        return view('User.CostoOrden.editar', compact(['costoOrden']));
    }

    public function actualizarCostoOrden(Request $request)
    {
        //dd($request);
        $orden = $request['num_Orden'];
        $messages = array(
            'required' => 'El :attribute es un campo requerido',
            'numeric' => ':attribute debe ser un valor númerico'

        );
        $validator = Validator::make($request->all(), [
            'cantidad' => 'required|numeric',
            'costo_unitario' => 'required|numeric'
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
        return redirect::to('costo-orden/detalle/' . $orden);
        
    }

    public function guardarHrasProd(Request $request)
    {

        $numOrden = $request->input('codigo');

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

        return redirect()->back()->with('message-success', 'Comentario agregado exitosamente)');
    }
    public function getCostoOrden()
    {
        $obj = CostoOrden::getCostoOrden();
        return response()->json($obj);
    }
}

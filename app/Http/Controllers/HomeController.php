<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use App\Models\DetalleOrden;
use App\Models\DetalleCostoSubtotal;
use App\Traits\ModelScopes;

class HomeController extends Controller
{
    use ModelScopes;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $detalle_orden = DetalleOrden::all();
        //dd($detalle_orden);
        return view('home', compact(['detalle_orden']));
    }

    public function detail($idOP)
    {
        $detalle_costo_subtotal = DetalleCostoSubtotal::where('numOrden', $idOP)->get();
        $detalle_orden = DetalleOrden::where('numOrden', $idOP)->get()->first();
        $hras_efectivas = $this->calcularHrasEftvs($idOP);

        return view('homed', compact('detalle_orden', 'detalle_costo_subtotal', 'hras_efectivas'));
    }

    public function getDetalleHome()
    {
        $detalle_orden = DetalleOrden::all();
        $detail = array();
        $i = 0;
        foreach ($detalle_orden as $d) {
            $detail[$i]['numOrden'] = $d['numOrden'];
            $detail[$i]['nombre'] = strtoupper($d['nombre']);
            $detail[$i]['prod_real'] = number_format($d['prod_real'],2);
            $detail[$i]['prod_real_ton'] = number_format(($d['prod_real']/1000),2);
            $detail[$i]['costo_total'] = number_format($d['costo_total'],2);
            $detail[$i]['tipo_cambio'] = number_format($d['tipo_cambio'],4);

            if ($d['tipo_cambio'] == 0) {
                $detail[$i]['CTotal_dollar'] =  number_format(0, 4);
                $detail[$i]['CTon_dollar'] =    number_format(0, 4);
            } else {
                $detail[$i]['CTotal_dollar'] = number_format(($d['costo_total'] / $d['tipo_cambio']), 4);
                $detail[$i]['CTon_dollar'] =    number_format((($d['costo_total']/$d['tipo_cambio'])/($d['prod_real']/1000)),4);
                $i++;
            }
            $i++;
        }
        return response()->json($detail);
    }
}

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
}

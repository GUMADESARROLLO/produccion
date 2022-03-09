<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\detalle_pc_ordenes;
use App\Models\pc_ordenes_produccion;


use Illuminate\Http\Request;



class ProcesoConversionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('User.Proceso_Conversion.index');
    }

    public function getOrdenes(){
        $ordenes = detalle_pc_ordenes::getOrdenes();
        return response()->json($ordenes);
    }

    public function guardar(Request $request){
        
        $data = $request->input('data');
        $orden = pc_ordenes_produccion::guardar($data);
        return response()->json($orden);
    }
    
    
}
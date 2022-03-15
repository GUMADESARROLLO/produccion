<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\pc_requisado_detalles;
use Illuminate\Http\Request;

class PcRequisadoDetalleController extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function guardarMatP(Request $request)
    {
        $response = pc_requisado_detalles::guardarRequisado($request);
        return response()->json($response);
    }
}

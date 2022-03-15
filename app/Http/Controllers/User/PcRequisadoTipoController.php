<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\pc_requisados_tipos;

class PcRequisadoTipoController extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getRequisados(){
        $requisados = pc_requisados_tipos::getRequisados();
        return response()->json($requisados);
    }

}

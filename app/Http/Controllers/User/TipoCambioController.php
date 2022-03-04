<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\TipoCambio;
use App\Models\orden_produccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TipoCambioController extends Controller
{

    public function getTipoCambio($date){
        $json = array();


        $date_tc = date('Y-m-d H:i:s'.'.000', strtotime($date));
        
        $TipoCambio = TipoCambio::where('FECHA', '=', $date_tc)->pluck('MONTO')->first();
        $json[0]['TipoCambio'] = number_format($TipoCambio,4);

        return response()->json($json);
    }

    public function actualizarTC(Request $request){
        $response = orden_produccion::where('numOrden', $request->input('numOrden'))
        ->update([
            'tipo_cambio' => $request->input('tasaCambio'),
        ]);
        return response()->json($response);
    }

}

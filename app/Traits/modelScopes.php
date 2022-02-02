<?php

namespace App\Traits;

use App\Models\horas_efectivas;
use Illuminate\Support\Facades\DB;


trait ModelScopes
{
    public function calcularHrasEftvs($idOrd)
    {
        //$horas_efectivas = horas_efectivas::where([['numOrden', $idOrd], ['estado', 1]])->get(); // obtengo las horas efectivas
        $data = array();

        $horas_efectivas = horas_efectivas::select(DB::raw('SUM(TIME_TO_SEC(y1_dia)) as total_y1_Dia,
                                                            SUM(TIME_TO_SEC(y1_noche)) as total_y1_Noche, 
                                                            SUM(TIME_TO_SEC(y2_dia)) as total_y2_Dia,
                                                            SUM(TIME_TO_SEC(y2_noche)) as total_y2_Noche'))
            ->where('numOrden', $idOrd)->where('estado', 1)->groupBy('numOrden')
            ->get()->first();
        if (is_null($horas_efectivas)) {
                 // YANKEE 1
            $data[0]['nombre'] =  'Yankee  Dryer 1 '; //$horas_efectivas->;
            $data[0]['dia'] =  number_format(0, 2); //$horas_efectivas->;
            $data[0]['noche'] = number_format(0, 2);
            $data[0]['total'] =  number_format(0, 2);
            $data[0]['totalYk'] = number_format(0, 2);

            //YANKEE 2
            $data[1]['nombre'] =  'Yankee  Dryer 2'; //$horas_efectivas->;
            $data[1]['dia'] = number_format(0, 2);
            $data[1]['noche'] = number_format(0, 2);
            $data[1]['total'] = number_format(0, 2);
        } else {
            $total_y1_Dia   = $horas_efectivas->total_y1_Dia / 3600;
            $total_y1_Noche = $horas_efectivas->total_y1_Noche / 3600;
            $total_y2_Dia   = $horas_efectivas->total_y2_Dia / 3600;
            $total_y2_Noche = $horas_efectivas->total_y2_Noche / 3600;
            $total          = $total_y1_Dia +  $total_y1_Noche  + $total_y1_Dia +  $total_y1_Noche +  $total_y2_Dia + $total_y2_Noche;
            $totak_yk       = number_format($total / 3, 2);

            // YANKEE 1
            $data[0]['nombre'] =  'Yankee  Dryer 1 '; //$horas_efectivas->;
            $data[0]['dia'] =  number_format($total_y1_Dia, 2); //$horas_efectivas->;
            $data[0]['noche'] = number_format($total_y1_Noche, 2);
            $data[0]['total'] =  number_format($total_y1_Dia + $total_y1_Noche, 2);
            $data[0]['totalYk'] = number_format($totak_yk, 2);

            //YANKEE 2
            $data[1]['nombre'] =  'Yankee  Dryer 2'; //$horas_efectivas->;
            $data[1]['dia'] = number_format($total_y2_Dia, 2);
            $data[1]['noche'] = number_format($total_y2_Noche, 2);
            $data[1]['total'] = number_format($total_y2_Dia + $total_y2_Noche, 2);
        }


        return $data;
    }
}

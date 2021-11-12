<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\DetalleOrden;
use App\Models\CostoOrden;



class PDFController extends Controller
{
   
    public function detalleOrdenPDF($numOrden){

        $detalle_orden = DetalleOrden::all();
        $costo_orden = costoOrden::where('numOrden',$numOrden)->orderBy('id', 'asc')->get();


        $pdf = \PDF::loadView('prueba',compact(['detalle_orden','costo_orden']))->setPaper('a4', 'landscape');
        return $pdf->stream('prueba.pdf');
    }

}

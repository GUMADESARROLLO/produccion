<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\DetalleOrden;
use App\Models\CostoOrdenSubTotal;



class PDFController extends Controller
{
   
    public function detalleOrdenPDF($numOrden){

        $detalle_orden = DetalleOrden::where('numOrden',$numOrden)->get();
        $costo_orden_subTotal = CostoOrdenSubTotal::where('numOrden',$numOrden)->orderBy('costo_id', 'asc')->get();
        
        $pdf = \PDF::loadView('PDF',compact(['detalle_orden','costo_orden_subTotal']))->setPaper('a4', 'landscape')->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('prueba.pdf');
    }

}

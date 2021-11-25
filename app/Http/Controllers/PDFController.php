<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\DetalleOrden;
use App\Models\CostoOrdenSubTotal;
use App\Models\jumboroll;

class PDFController extends Controller
{
   
    public function detalleOrdenPDF($numOrden){

        $detalle_orden = DetalleOrden::where('numOrden',$numOrden)->get();
        $costo_orden_subTotal = CostoOrdenSubTotal::where('numOrden',$numOrden)->orderBy('costo_id', 'asc')->get();
        $jumborrol = jumboroll::select('COUNT(jd.idJumboroll)')
            ->join('jumboroll_detalle', 'jumboroll_detalle.idJumboroll', '=', 'jumboroll.id')
            ->where('jumboroll.numOrden', $numOrden)
            ->get();

        $pdf = \PDF::loadView('PDF',compact(['detalle_orden','costo_orden_subTotal', 'jumborrol']))->setPaper('a4', 'landscape')->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('prueba.pdf');
    }

}

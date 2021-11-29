<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DB;
use App\Models\DetalleOrden;
use App\Models\CostoOrdenSubTotal;
use App\Models\jumboroll;
use App\Models\jumboroll_detalle;

class PDFController extends Controller
{
   
    public function detalleOrdenPDF($numOrden){

        $detalle_orden = DetalleOrden::where('numOrden',$numOrden)->get();
        $costo_orden_subTotal = CostoOrdenSubTotal::where('numOrden',$numOrden)->orderBy('costo_id', 'asc')->get();
        $jumborrol = jumboroll_detalle::select(DB::raw('count(*) as bobinas'))
            ->join('jumboroll', 'jumboroll_detalle.idJumboroll', '=', 'jumboroll.id')
            ->where('jumboroll.numOrden', $numOrden)
            ->get();

        $pdf = \PDF::loadView('PDF',compact(['detalle_orden','costo_orden_subTotal', 'jumborrol']))->setPaper('a4', 'landscape')->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('prueba.pdf');
    }

}

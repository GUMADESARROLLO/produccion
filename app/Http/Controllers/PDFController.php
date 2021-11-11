<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    public function PDF(){
        $pdf = \PDF::loadView('prueba');
        return $pdf->stream('prueba.pdf');
    }
}

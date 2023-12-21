<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Logs_access;
use App\Models\productos;

use Illuminate\Support\Facades\DB;

class LogsAccessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getHome(Request $request){

        $productos = productos::where('estado', 1)->orderBy('idProducto', 'asc')->get();
        return view('User.LogsAccess.Home', compact('productos'));
    }
    public function getDataLogs(Request $request) {
        $from   = $request->input('f1') . ' 00:00:00';
        $to     = $request->input('f2') . ' 23:59:59';

        $result = Logs_access::select('idUser','name', 'description', \DB::raw('COUNT(name) as hits'))
                    ->whereBetween('created_at', [$from, $to])
                    ->groupBy('idUser','name', 'description')
                    ->get();
        
        return response()->json($result);
    }

}

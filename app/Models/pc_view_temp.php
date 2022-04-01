<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class pc_view_temp extends Model{

    protected $table = "view_orden_detalles";
    public    $timestamps = false;

    public static function getRows($num_orden,$Id)
    {
        return pc_view_temp::where('num_orden', $num_orden)->get();
        
    }

}

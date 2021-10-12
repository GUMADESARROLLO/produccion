<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class configuracionModel extends Model {

    public static function getTurnos() {
        return DB::table('turnos')->where('estado',1)->orderby('idTurno', 'asc')->get()->toArray();        
    }   

}

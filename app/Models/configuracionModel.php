<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class configuracionModel extends Model {

    public static function getTurnos() {
        return DB::table('turno')->where('estado',1)->orderby('idTurno', 'asc')->get()->toArray();
    }

}

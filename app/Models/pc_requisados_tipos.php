<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class pc_requisados_tipos extends Model{

    protected $table = "pc_requisados_tipos";
    public    $timestamps = false;

    public static function getRequisados_tipos()
    {
        return pc_requisados_tipos::all();
    }

}

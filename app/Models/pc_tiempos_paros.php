<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class pc_tiempos_paros extends Model{

    protected $table = "pc_tiempos_paros";
    protected $fillable = ['id','nombre','activo'];
    public    $timestamps = false;

}
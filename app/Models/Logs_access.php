<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Logs_access extends Model
{
    protected $table = "tbl_logs_access";

    public static function add($Mod)
    {

        $obj = new Logs_access();   
        $obj->idUser        = Auth::id();            
        $obj->name          = Auth::user()->nombres;
        $obj->description   = $Mod;      
        $obj->save();
    }

    
}

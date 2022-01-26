<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class maquinas extends Model
{
    protected $table = "maquinas";
    protected $fillable = ['idMaquina','nombre','estado'];
    protected $guarded = ['idMaquina'];
    public $timestamps = false;

    public function obtenerMaquinas()
    {
        //return maquinas::all();
        return maquinas::where('estado', 1)->orderBy('idMaquina', 'asc')->get();
    }
}

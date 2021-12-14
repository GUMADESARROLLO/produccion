<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsumoGas extends Model
{
    protected $table = "gas";
    protected $fillable = ['inicial','final','numOrden'];
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class maquinas extends Model
{
    protected $table = "maquinas";
    protected $fillable = ['idMaquina','nombre','estado'];
    protected $guarded = ['idMaquina'];
    public $timestamps = false;
}

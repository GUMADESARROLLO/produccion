<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quimicos extends Model
{
    //
    protected $table = "quimicos";
    protected $fillable = ['codigo','descripcion','estado'];
    public $timestamps = false;
}

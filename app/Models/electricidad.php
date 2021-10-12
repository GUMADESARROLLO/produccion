<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class electricidad extends Model {
    protected $table = "electricidad";
    protected $fillable = ['id','inicial','final','numOrden'];
    public $timestamps = false;
}

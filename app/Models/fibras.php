<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class fibras extends Model
{
    protected $table = "fibras";
    protected $fillable = ['idFibra','codigo','descripcion','estado'];
    protected $guarded = ['idFibra'];
    public $timestamps = false;
}

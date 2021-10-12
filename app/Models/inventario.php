<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inventario extends Model
{
    protected $table = "inventario";
    protected $fillable = ['idInventario','codigo','descripcion','estado'];
    protected $guarded = ['idInventario'];
    public $timestamps = false;
}

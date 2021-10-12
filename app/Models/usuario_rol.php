<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usuario_rol extends Model
{
    protected $table = "usuario_rol";
    protected $fillable = ['id', 'rol_id', 'usuario_id', 'estado'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuimicoMaquina extends Model
{
    protected $table = "quimico_maquina";
    protected $fillable = ['id', 'idMaquina', 'idQuimico', 'numOrden','cantidad','estado'];
    public $timestamps = false;
}

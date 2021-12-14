<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quimicos extends Model
{
    //
    protected $table = "quimicos";
    protected $primaryKey = 'idQuimico';
    protected $fillable = ['codigo','descripcion','estado'];
    public $timestamps = false;

    /***** Relaciones *******/
    public function ordenesq()
    {
        return $this->belongsToMany('orden_produccion', 'QuimicoMaquina', 'idQuimico', 'numOrden');
    }
}

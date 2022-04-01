<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quimicos extends Model
{
    //
    protected $table = "quimicos";
    protected $primaryKey = 'idQuimico';
    protected $fillable = ['codigo','descripcion','unidad','estado'];
    public $timestamps = false;

    /***** Relaciones *******/
    // 1-Modelo a Relacionar, 2-Tabla Puente, 3-fk del modelo definido , 4-fk del modelo a relacionar
    public function ordenesq()
    {
        return $this->belongsToMany('orden_produccion', 'QuimicoMaquina', 'idQuimico', 'numOrden');
    }

    public function quimicosR(){
        return $this->belongsToMany('App\Models\Requisa', 'detalle_requisas', 'elemento_id', 'requisa_id')
                    ->withPivot('cantidad', 'estado')->withTimestamps();
    }
}

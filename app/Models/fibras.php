<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class fibras extends Model
{
    protected $table = "fibras";
    protected $primaryKey = 'idFibra';
    protected $fillable = ['codigo','descripcion','unidad','estado'];
    //protected $guarded = ['idFibra'];
    public $timestamps = false;

    /***** Relaciones *******/
    // 1-Modelo a Relacionar, 2-Tabla Puente, 3-fk del modelo definido , 4-fk del modelo a relacionar
    public function ordenesf()
    {
        return $this->belongsToMany('orden_produccion', 'mp_directa', 'idFibra', 'numOrden');
    }

    public function fibrasR(){
        return $this->belongsToMany('App\Models\Requisa', 'detalle_requisas', 'elemento_id', 'requisa_id')
                    ->withPivot('cantidad', 'estado')->withTimestamps();
    }
}

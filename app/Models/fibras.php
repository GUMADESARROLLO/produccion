<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class fibras extends Model
{
    protected $table = "fibras";
    protected $primaryKey = 'idFibra';
    protected $fillable = ['codigo','descripcion','estado'];
    //protected $guarded = ['idFibra'];
    public $timestamps = false;

    /***** Relaciones *******/
    public function ordenesf()
    {
        return $this->belongsToMany('orden_produccion', 'mp_directa', 'idFibra', 'numOrden');
    }
}

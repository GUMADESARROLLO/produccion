<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orden_produccion extends Model
{
    protected $table = "orden_produccion";
    protected $primaryKey = "idOrden";
    protected $fillable = ['numOrden', 'producto','idUsuario','hrsTrabajadas','fechaInicio','fechaFinal','horaInicio','horaFinal','estado','horaJY1','horaJY2','horaLY1','horaLY2','tipo_cambio'];
    //protected $guarded = ['idOrden'];
    public $timestamps = false;

    /***** Relaciones *******/
    public function quimicos()
    {
        return $this->belongsToMany('Quimicos', 'QuimicoMaquina', 'numOrden', 'idQuimico');
    }

    public function fibras()
    {
        return $this->belongsToMany('fibras', 'mp_directa', 'numOrden', 'idFibra');
    }

    //Una orden tiene muchas requisas
    public function requisas()
    {
        return $this->hasMany('App\Models\Requisa', 'numOrden', 'numOrden');
    }

}

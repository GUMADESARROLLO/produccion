<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requisa extends Model
{
    protected $table = 'requisas';
    protected $primaryKey = 'id';
    protected $fillable = ['numOrden','codigo_req','jefe_turno'];

    public function obtenerRequisas()
    {
        return Requisa::all();
    }

    public function obtenerRequisaPorId($id)
    {
        return Requisa::find($id);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requisa extends Model
{
    protected $table = 'requisas';
    protected $primaryKey = 'id';
    protected $fillable = ['numOrden','codigo_req','jefe_turno'];
    public $timestamps = true;

    public function obtenerRequisas()
    {
        //return Requisa::all();
        return Requisa::select(['numOrden', 'codigo_req', 'turno', 'created_at'])->get();
    }

    public function obtenerRequisaPorId($id)
    {
        return Requisa::find($id);
    }

    public function orden(){
        return $this->belongsTo('App\Models\orden_produccion', 'numOrden', 'numOrden');
    }


}

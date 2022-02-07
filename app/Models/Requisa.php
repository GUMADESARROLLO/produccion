<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requisa extends Model
{
    protected $table = 'requisas';
    protected $primaryKey = 'id';
    protected $fillable = ['numOrden','codigo_req', 'jefe_turno','turno','tipo', 'estado'];
    public $timestamps = true;

    public function obtenerRequisas()
    {
        //return Requisa::all();
        return Requisa::select(['id', 'numOrden', 'codigo_req', 'turno', 'created_at'])->get();
    }

    public function obtenerRequisaPorId($id)
    {
        //return Requisa::find($id);
        $requisa = Requisa::where('id', $id)->where('estado',1)->get();
        return $requisa;
    }

    public function orden()
    {
        return $this->belongsTo('App\Models\orden_produccion', 'numOrden', 'numOrden');
    }

    public function requisasFibras(){
        return $this->belongsToMany('App\Models\fibras', 'DetalleRequisa', 'elemento_id', 'idFibra');
    }

}

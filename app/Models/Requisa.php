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

    #Relaciones
    //Una requisa pertenece a una orden de produccion
    public function orden()
    {
        return $this->belongsTo('App\Models\orden_produccion', 'numOrden', 'numOrden');
    }

    // 1-Modelo a Relacionar, 2-Tabla Puente, 3-fk del modelo definido , 4-fk del modelo a relacionar

    //Una requisa tiene muchas fibras, $data = Requisa::with('requisaF')->get();
    public function requisaF(){
        return $this->belongsToMany('App\Models\fibras', 'detalle_requisas', 'requisa_id', 'elemento_id')
                    ->withPivot('cantidad', 'estado')->withTimestamps();
    }

    //Una requisa tiene muchos quimicos
    public function requisaQ(){
        return $this->belongsToMany('App\Models\Quimico', 'detalle_requisas', 'requisa_id', 'elemento_id')
                    ->withPivot('cantidad', 'estado')->withTimestamps();
    }
}

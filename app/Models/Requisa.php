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
        $i = 0;
        $data = array();
        //return Requisa::all();
        $Requisa = Requisa::select(['id', 'numOrden', 'codigo_req', 'turno', 'created_at'])->get();
        foreach($Requisa as $rq){
            $data[$i]['id'] =  $i + 1;
            $data[$i]['numOrden'] =  $rq['numOrden'];
            $data[$i]['codigo_req'] =  $rq['codigo_req'];
            $data[$i]['turno'] = $rq['turno'] == 1? "Dia" : "Noche";          
            $data[$i]['created_at'] =  date("Y-m-d H:i:s", strtotime($rq['created_at'])) ;   
            $data[$i]['acciones'] =  '<a href="requisas/'.$rq['id'].'/edit"><i class="feather icon-edit text-c-blue f-30 m-r-10"></i></a>' .
                                        '<a href="#!" onclick="deleteTurno()"><i class="feather icon-x-circle text-c-red f-30 m-r-10"></i></a>';
            $i++;
        }
        return $data;
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

    public function updateRequisa(){
        return $this->belongsToMany('App\Models\fibras', 'DetalleRequisa', 'elemento_id', 'idFibra');
    }

}

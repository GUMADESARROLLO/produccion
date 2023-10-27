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

    public function quimicoM(){
        return $this->hasMany('App\Models\QuimicoMaquina', 'idQuimico', 'idQuimico');
    }

    public static function getQuimicos($numOrden){
        $array = array();
        $i = 0;

        $qui = Quimicos::orderBy('idMaquina')->get();

        foreach($qui as $q){
            $cantidad = 0.00;

            foreach($q->quimicoM as $mq){
                if($numOrden == $mq->numOrden){
                    if($q->idQuimico == $mq->idQuimico){
                        $cantidad = $mq->cantidad;
                    }
                }
            }

            $array[$i]['idQuimico'] = $q->idQuimico;
            $array[$i]['codigo'] = $q->codigo;
            $array[$i]['descripcion'] = $q->descripcion;
            $array[$i]['unidad'] = $q->unidad;
            $array[$i]['estado'] = $q->estado;
            $array[$i]['idMaquina'] = $q->idMaquina;
            $array[$i]['cantidad'] = number_format($cantidad,2,'.',',');
            
            $i++;
        }

        return response()->json($array);
    }
}

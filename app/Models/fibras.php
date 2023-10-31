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

    public function materia_prima(){
        return $this->hasMany('App\Models\mp_directa', 'idFibra', 'idFibra');
    }

    public static function getFibras($numOrden){
        $array = array();
        $i = 0;

        $fib = fibras::get();

        foreach($fib as $fb){
            $cantidad = 0.00;

            foreach($fb->materia_prima as $mp){
                if($numOrden == $mp->numOrden){
                    if($mp->idFibras == $fb->idFibras){
                        $cantidad = $mp->cantidad;
                    }
                }
            }

            $array[$i]['idFibra'] = $fb->idFibra;
            $array[$i]['codigo'] = $fb->codigo;
            $array[$i]['descripcion'] = $fb->descripcion;
            $array[$i]['unidad'] = $fb->unidad;
            $array[$i]['estado'] = $fb->estado;
            $array[$i]['idMaquina'] = $fb->idMaquina;
            $array[$i]['cantidad'] = number_format($cantidad,2,'.',',');
            
            $i++;
        }

        return response()->json($array);
    }

}

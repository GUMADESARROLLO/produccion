<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class actividad extends Model
{
    protected $table = "actividad";
    protected $primaryKey = 'idActividad';
    protected $fillable = ['descripcion'];
    public $timestamps = false;

    public function costo_indirecto(){
        return $this->hasMany('App\Models\costoIndirecto', 'idActividad', 'idActividad');
    }

    public function mano_obra(){
        return $this->hasMany('App\Models\manoObra', 'idActividad', 'idActividad');
    }

    public static function getManoO($orden){
        $json = array();
        $i = 0;
        $act = actividad::get();

        foreach($act as $a){
            $dia = $noche = $total = '0';
            foreach($a->mano_obra as $mo){
                if($mo->numOrden == $orden && $a->idActividad == $mo->idActividad){
                   $dia = $mo->dia;
                   $noche = $mo->noche;
                   $total = $mo->total;
                } 
                
            }

            $json[$i]['idActividad'] = $a->idActividad;
            $json[$i]['descripcion'] = $a->descripcion;
            $json[$i]['orden'] = $orden;
            $json[$i]['dia'] = $dia;
            $json[$i]['noche'] = $noche;
            $json[$i]['total'] = $total;

            $i++;
        }

        return $json;
    }

    public static function getCostoI($orden){
        $json = array();
        $i = 0;
        $act = actividad::get();

        foreach($act as $a){
            $dia = $noche = $horas = '0.00';
            foreach($a->costo_indirecto as $ci){
                if($ci->numOrden == $orden && $a->idActividad == $ci->idActividad){
                   $dia = $ci->dia;
                   $noche = $ci->noche;
                   $horas = $ci->horas;
                } 
                
            }

            $json[$i]['idActividad'] = $a->idActividad;
            $json[$i]['descripcion'] = $a->descripcion;
            $json[$i]['orden'] = $orden;
            $json[$i]['dia'] = $dia;
            $json[$i]['noche'] = $noche;
            $json[$i]['horas'] = $horas;

            $i++;
        }

        return $json;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProcesoConversion extends Model {
    
    public static function getJson($Orden){
        $array_merge = array();

        $data_orden = ProcesoConversion::get_info_orden($Orden);

        $Array_Info[] = array(
            'tipo' => 'dtaOrden',
            'data' => $data_orden
        );
        
        $Array_Producto[] = array(
            'tipo' => 'dtaProducto',
            'data' => ProcesoConversion::get_info_producto($data_orden['peso_procent'],$data_orden['id_productor'],$data_orden['num_orden'])
        );
        $Array_Materia[] = array(
            'tipo' => 'dtaMateria',
            'data' => ProcesoConversion::get_materia_prima($data_orden['peso_procent'],$data_orden['id_productor'],$data_orden['num_orden'])
        );

        $array_merge = array_merge($Array_Info,$Array_Producto,$Array_Materia);
        return $array_merge;

    }

    public static function get_info_orden($Orden){
        $datos_ordenes = DB::table('view_proceso_seco_ordenes_produccion')->where('num_orden', $Orden)->get();
        $json = array();
        $i = 0;

        if( count($datos_ordenes)>0 ){
            foreach ($datos_ordenes as $key => $value) {
                $json['id']                 = $value->id;
                $json['id_productor']       = $value->id_productor;
                $json['num_orden']          = $value->num_orden;
                $json['nombre']             = $value->nombre;
                $json['fecha_inicio']       = strftime('%a %d de %b %G', strtotime($value->fecha_hora_inicio));
                $json['hora_inicio']        = date('h:i a', strtotime($value->fecha_hora_inicio));
                $json['fecha_final']        = strftime('%a %d de %b %G', strtotime($value->fecha_hora_final));
                $json['hora_final']         = date('h:i a', strtotime($value->fecha_hora_final));
                $json['hrs_trabajadas']     = number_format($value->Hrs_trabajadas,2);
                $json['peso_procent']       = number_format($value->PESO_PORCENT,2);
                $json['total_bultos_und']   = number_format($value->TOTAL_BULTOS_UNDS,2);
                
                $i++;
            }
        }

        return $json;
        $sql_server->close();
    }
    public static function get_info_producto($peso_porcent,$id_productor,$num_orden){
        
        $items_productos = DB::table('pc_productos_ordenes')->where('id_producto', $id_productor)->where('TIPO', 'PRODUCTO')->get();
        $datos_productos = DB::table('view_agrupado_detalle_requisas')->where('num_orden', $num_orden)->get()->toArray();
        $json = array();
        $i = 0;
        //DD($datos_productos);
        if( count($items_productos)>0 ){
            foreach ($items_productos as $key => $value) {

                $json[$i]['ID_ARTICULO']        = $value->ID_ARTICULO;
                $json[$i]['ARTICULO']           = $value->ARTICULO;
                $json[$i]['DESCRIPCION_CORTA']  = $value->DESCRIPCION_CORTA;
                
                $found_key = array_search($value->ID_ARTICULO, array_column($datos_productos, 'ID_ARTICULO'));
                if ($found_key !== false) {                    
                    $json[$i]['BULTO']              = number_format($datos_productos[$found_key]->PRODUCTO,2);
                    $json[$i]['PERSO_PORCENT']      = number_format($peso_porcent,2);
                    $json[$i]['KG']                 = number_format($datos_productos[$found_key]->PRODUCTO * $peso_porcent,2);
                }else{                    
                    $json[$i]['BULTO']              = number_format(0.00,2);
                    $json[$i]['PERSO_PORCENT']      = number_format(0,2);
                    $json[$i]['KG']                 = number_format(0.00,2);
                }
                
                $i++;
            }
        }

        return $json;
        $sql_server->close();
    }
    public static function get_materia_prima($peso_porcent,$id_productor,$num_orden){
        $items_productos = DB::table('pc_productos_ordenes')->where('id_producto', $id_productor)->where('TIPO', 'MATERIA_PRIMA')->get();
        $datos_materia_prima = DB::table('view_proceso_seco_estadisticas')->where('num_orden', $num_orden)->get()->toArray();
        $json = array();
        $i = 0;

        if( count($items_productos)>0 ){
            foreach ($items_productos as $key => $value) {

                $json[$i]['ID_ARTICULO']        = $value->ID_ARTICULO;
                $json[$i]['ARTICULO']           = $value->ARTICULO;
                $json[$i]['DESCRIPCION_CORTA']  = $value->DESCRIPCION_CORTA;                  

                $found_key = array_search($value->ID_ARTICULO, array_column($datos_materia_prima, 'ID_ARTICULO'));

                if ($found_key !== false) {                    
                    $json[$i]['REQUISA']            = number_format($datos_materia_prima[$found_key]->REQUISA,2);
                    $json[$i]['PISO']               = number_format($datos_materia_prima[$found_key]->PISO,2);
                    $json[$i]['PERSO_PORCENT']      = number_format($datos_materia_prima[$found_key]->CONSUMO,2);
                    $json[$i]['MERMA']              = number_format($datos_materia_prima[$found_key]->MERMA ,2);
                    $json[$i]['MERMA_PORCENT']      = number_format($datos_materia_prima[$found_key]->MERMA_PORCENT ,2);
                }else{                    
                    $json[$i]['REQUISA']            = number_format(0,2);
                    $json[$i]['PISO']               = number_format(0,2);
                    $json[$i]['PERSO_PORCENT']      = number_format(0,2);
                    $json[$i]['MERMA']              = number_format(0,2);
                    $json[$i]['MERMA_PORCENT']      = number_format(0,2);
                }

                $i++;
            }
        }

        return $json;
        $sql_server->close();
    }

}
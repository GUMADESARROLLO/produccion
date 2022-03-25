<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\pc_view_temp;

class ProcesoConversion extends Model {


    
    public static function datos_detalles($num_orden){

        $data_orden = ProcesoConversion::get_info_orden($num_orden);

        $json = array();
        $obj_unset = array();
        $Array_Tipos_Datos = array();
        $i = 1;
        $t = 0;

        $datos_productos = DB::table('pc_requisados_tipos')->select("NOMBRE")->where('ID', '<>',5)->get()->toArray();
        $VIEW_TEMP = pc_view_temp::getRows($num_orden,$data_orden['id_productor']);
        
        foreach($datos_productos as $key => $value){
            $Array_Tipos_Datos[$t] = $value->NOMBRE;
            $t++;
        }

        for($c=1; $c <= 13 ; $c++){

            $str_ITEM = "ITEM".$c; 
            
            foreach($VIEW_TEMP as $key){    
                if(!is_null($key[$str_ITEM])){
                    $obj_unset[$i]= $key['TIPO_REQUISA'];
                    $json[$str_ITEM][$i]['ACTIVIDAD']   = $key['TIPO_REQUISA'];
                    $json[$str_ITEM][$i]['VALORES']     = $key[$str_ITEM]; 
                    $i++;
                }
                
            }
            $diff_result = array_diff($Array_Tipos_Datos, $obj_unset);

            
            foreach($diff_result as $key => $value){
                $json[$str_ITEM][$i]['ACTIVIDAD']      = $value;
                $json[$str_ITEM][$i]['VALORES']        = "0.00"; 
                
                $i++;
            }
            
            
            $obj_unset = array();
            

            $i=1;


        }

        

        return $json;
    }
    public static function getJson($Orden){
        $array_merge = array();
        setlocale(LC_TIME, "spanish");
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
        $Array_Tiempos_Paros[] = array(
            'tipo' => 'dtaTiemposParos',
            'data' => ProcesoConversion::get_tiempos_paro($data_orden['num_orden'])
        );

        $array_merge = array_merge($Array_Info,$Array_Producto,$Array_Materia,$Array_Tiempos_Paros);
        //$array_merge = array_merge($Array_Tiempos_Paros);
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

                $json['hrs_total_trabajadas']     =  $value->hrs_total_trabajadas;
                $json['comentario']               =  $value->comentario;
 
                $i++;
            }
        }

        return $json;
    }
    public static function get_tiempos_paro($num_orden){
        
        $items_productos = DB::table('pc_tiempos_paros')->where('ACTIVO', 'S')->get();
        $datos_productos = DB::table('view_proceso_seco_detalles_tiempos_paros')->where('num_orden', $num_orden)->get()->toArray();
        $json = array();
        $i = 0;
        //DD($datos_productos);
        if( count($items_productos)>0 ){
            foreach ($items_productos as $key => $value) {

                $json[$i]['ID_ROW']        = $value->ID;
                $json[$i]['ARTICULO']           = $value->NOMBRE;
                
               $found_key = array_search($value->ID, array_column($datos_productos, 'id_row'));

               //DD($found_key);
                if ($found_key !== false) {                    
                    $json[$i]['Dia']            = number_format($datos_productos[$found_key]->Dia,2);
                    $json[$i]['Noche']          = number_format($datos_productos[$found_key]->Noche,2);
                    $json[$i]['Total_Hrs']      = number_format($datos_productos[$found_key]->Dia + $datos_productos[$found_key]->Noche,2);
                    $json[$i]['num_personas']   = number_format($datos_productos[$found_key]->Personal_Dia + $datos_productos[$found_key]->Personal_Noche,2);                    
                }else{                    
                    $json[$i]['Dia']            = number_format(0.00,2);
                    $json[$i]['Noche']          = number_format(0.00,2);
                    $json[$i]['Total_Hrs']      = number_format(0.00,2);
                    $json[$i]['num_personas']   = number_format(0.00,2);
                }
                
                $i++;
            }
        }

        return $json;
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
    }
}
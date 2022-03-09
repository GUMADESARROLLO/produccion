<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class pc_ordenes_produccion extends Model{

    protected $table = "pc_ordenes_produccion";
    protected $fillable = ['num_orden','id_productor','fecha_hora_inicio','fecha_hora_final'];
    public    $timestamps = false;

    public static function guardar($data)
    {
        try {
            DB::transaction(function () use ($data) {
               
                $array = array();
                $i= 0;
                $orden = new pc_ordenes_produccion();
                foreach ($data as $dataO) {
                    
                    $orden->num_orden           =   $dataO['num_orden'];
                    $orden->id_productor       =   $dataO['id_productor'];
                    $orden->fecha_hora_inicio  =   $dataO['fecha_hora_inicio'];
                    $orden->fecha_hora_final  =   $dataO['fecha_hora_final'];

                   //$orden->fecha_orden        =   $dataP['fecha_orden'];
                    $orden->save();             
                    
                };                
                return response()->json($orden);
            });
        } catch (Exception $e) {
            $mensaje =  'Excepción capturada: ' . $e->getMessage() . "\n";

            return response()->json($mensaje);
        }   
    }


}
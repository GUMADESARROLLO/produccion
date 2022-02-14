<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class DetalleRequisa extends Model
{
    protected $table = 'detalle_requisas';
    protected $primaryKey = 'id';
    protected $fillable = ['requisa_id', 'elemento_id', 'cantidad', 'estado', 'created_at', 'updated_at'];
    public $timestamps = true;

    
    public static function guardarDetalleReq($data)
    {
        if (!is_null($data)) {
            foreach ($data as $detail_req) {
                $dta_Req = new DetalleRequisa();
                $dta_Req->requisa_id = $detail_req['requisa_id'];
                $dta_Req->elemento_id = $detail_req['elemento_id'];
                $dta_Req->cantidad = $detail_req['cantidad'];
                $dta_Req->estado = 1;
                $dta_Req->save();

                DB::select('call inn_requisas("' . $detail_req['numOrden'] . '", "' . $detail_req['elemento_id'] . '",
                "' . $detail_req['tipo'] . '","' . $detail_req['cantidad'] . '")');

            }
           // return response()->json('true');
            return 'Se ha ingresado correctamente';
        }
    }

    public static function actualizarDetalleReq($data){
        if (!is_null($data)) {
            foreach ($data as $detail_req) {
              

            }
            return 'Se ha ingresado correctamente';
        }
    }

    public static function getDetalleReq($cod_requisa, $tipo){
        $Requisado = array();
        $obj = DetalleRequisa::where('requisa_id', $cod_requisa)->get();
        $i = 0;
        if ($tipo == 1) { //Fibra
            foreach ($obj as $detalleRequisa) {
                $fibras = fibras::where('idFibra', $detalleRequisa['elemento_id'])->get();
                foreach ($fibras as $f) {
                    $Requisado[$i]['numero'] = $i+1;
                    $Requisado[$i]['id'] =     $detalleRequisa['id'];
                    $Requisado[$i]['elemento_id'] =     $f['idFibra'];
                    $Requisado[$i]['codigo'] =      $f['codigo'];
                    $Requisado[$i]['descripcion'] = $f['descripcion'];
                    $Requisado[$i]['unidad'] = $f['unidad'];
                    $Requisado[$i]['cantidad'] =    "<input type='text' class='form-control' onkeypress='validarNum(event, this, true)' id='cantidad-". $detalleRequisa['id'] ."' name='". $detalleRequisa['id'] ."' value='".$detalleRequisa['cantidad']."'>" ;
                    $i++;
                }
            }
        } else {
            foreach ($obj as $detalleRequisa) {
                $quimicos = Quimicos::where('idQuimico', $detalleRequisa['elemento_id'])->get();
                foreach ($quimicos as $q) {
                    $Requisado[$i]['numero'] = $i+1;
                    $Requisado[$i]['id'] =   $detalleRequisa['id'];
                    $Requisado[$i]['elemento_id'] =    $q['idQuimico'];
                    $Requisado[$i]['codigo'] =      $q['codigo'];
                    $Requisado[$i]['descripcion'] = $q['descripcion'];
                    $Requisado[$i]['unidad'] =      $q['unidad'];
                    $Requisado[$i]['cantidad'] =    "<input type='text' class='form-control' onkeypress='validarNum(event, this, true)'  id='cantidad-". $detalleRequisa['id'] ."' name='". $detalleRequisa['id'] ."' value='".$detalleRequisa['cantidad']."'>" ;
                    $i++;
                }
            }
        }

        return($Requisado);
    }

}

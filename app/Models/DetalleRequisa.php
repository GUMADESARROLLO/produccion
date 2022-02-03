<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleRequisa extends Model
{
    protected $table = 'detalle_requisas';
    protected $primaryKey = 'id';
    protected $fillable = ['requisa_id', 'elemento_id', 'cantidad', 'estado'];
    public $timestamps = true;

    public static function guardarDetalleReq($data)
    {
        $i = 0;
        if (!is_null($data)) {
            foreach ($data as $detail_req) {
                $dta_Req = new DetalleRequisa();
                $dta_Req->requisa_id = $detail_req['requisa_id'];
                $dta_Req->elemento_id = $detail_req['elemento_id'];
                $dta_Req->cantidad = $detail_req['cantidad'];
                $dta_Req->estado = 1;
                // $dta_Req->created_at = date('Y-m-d H:i:s');
                $dta_Req->save();

                DB::select('call inn_requisas_update("' . $detail_req['numOrden'] . '", "' . $detail_req['elemento_id'] . '",
                "' . $detail_req['tipo'] . '","' . $detail_req['cantidad'] . '")');

            }
            // return response()->json('true');
            return 'Se ha ingresado correctamente';
        }
    }
}

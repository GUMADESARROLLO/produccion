<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Turno extends Model
{
    protected $table = 'turnos';
    protected $primaryKey = 'id';
    protected $fillable = ['turno', 'horaInicio', 'horaFinal', 'descripcion', 'estado'];
    public $timestamps = true;

    public static function getTurnos()
    {
        $turnos= DB::table('turno')->where('estado',1)
                    ->orderby('idTurno', 'asc')->get()
                    ->toArray();

        return $turnos;
    }

    public static function getTurnoPorId($id)
    {
        //$turno= Turno::find($id);
        $turno = Turno::where('id',$id)->where('estado', 1)->get()->toArray();
        return $turno;
    }

    public function turnos() {
        $turnos = Turno::where('estado', 1)->orderBy('horaInicio', 'asc')->get();
        $message = [
            'mensaje' =>  '',
            'tipo' => ''
        ];
        return view('User.Turnos.index', compact('turnos', 'message'));
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\configuracionModel;
use App\Models\turnos;
use Illuminate\Support\Facades\Validator;
use Redirect;
use DB;

class configuracionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('User.Configuracion.index');
    }

    public function turnos() {
        $turnos = turnos::where('estado', 1)->orderBy('horaInicio', 'asc')->get();
        $message = [
            'mensaje' =>  '',
            'tipo' => ''
        ];
        return view('User.Turnos.index', compact('turnos', 'message'));
    }

    public function crearTurno() {
        $message = [
            'mensaje' =>  '',
            'tipo' => ''
        ];
        return view('User.Turnos.crear', $message);
    }

    public function validaSiExisteElTurno($time1, $time2) {
        $validador = DB::table('turnos')
            ->where('estado', 1)
            ->when($time1, function ($query) use ($time1) {
                return $query->where('horaFinal','>', $time1);
            })->when($time2, function ($query) use ($time2) {
                return $query->where('horaInicio','<', $time2);
            })->orderBy('horaInicio', 'asc')->get();

        if ( count($validador)>0 ) {
            return true;
        }

        return false;
    }

    public function guardarTurno(Request $request) {
        $messages = array(
            'required' => 'El :attribute es un campo requerido'
        );

        $validator = Validator::make($request->all(), [
            'nombre'        => 'required',
            'horaInicio'    => 'required',
            'horaFin'       => 'required',
            'descripcion'   => 'required'
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $time1 = date("H:i", strtotime($request->horaInicio));
        $time2 = date("H:i", strtotime($request->horaFin));
        $validateHora = configuracionController::validaSiExisteElTurno($time1, $time2);
        
        if ($validateHora) {
            return redirect()->back()->with('message-error', 'El horario especificado coincide con otro turno guardado previamente :/');
        }else {
            $turnos = new turnos();
            $turnos->turno = $request->nombre;
            $turnos->horaInicio = date("H:i", strtotime($request->horaInicio));
            $turnos->horaFinal = date("H:i", strtotime($request->horaFin));
            $turnos->descripcion = ($request->descripcion=='')?'N/D':$request->descripcion;
            $turnos->estado = 1;
            $turnos->save();

            return redirect()->back()->with('message-success', 'Se guardo con exito :)');
        }
    }

    public function editarTurno($idTurno) {
        $turnos = turnos::where('idTurno', $idTurno)->get()->toArray();

        $message = [
            'mensaje' =>  '',
            'tipo' => ''
        ];

        return view('User.Turnos.editar', compact(['message', 'turnos']));
    }

    public function eliminarTurno($idTurno) {
        turnos::where('idTurno', $idTurno)
        ->update([
            'estado' => 0
        ]);

        return (response()->json(true));
    }

    public function actualizarTurno(Request $request) {

        $validatedData = $request->validate([
            'idTurno' => 'required',
            'nombre' => 'required',
            'horaInicio' => 'required',
            'horaFin' => 'required'
        ]);

        if ($validatedData) {
            $idTurno    = $request->idTurno;
            $time1      = date("H:i:s", strtotime($request->horaInicio));
            $time2      = date("H:i:s", strtotime($request->horaFin));

            $turnos = turnos::where('idTurno', $request->idTurno)->get()->toArray();

            if ( count($turnos)>0 ) {

                if ( $turnos[0]['horaInicio']==$time1 && $turnos[0]['horaFinal']==$time2 ) {
                    turnos::where('idTurno', $idTurno)
                    ->update([
                    'turno'          => $request->nombre,
                    'descripcion'    => ($request->descripcion=='')?'N/D':$request->descripcion
                    ]);

                    return redirect()->action('User\configuracionController@editarTurnoSuccess');

                }else {

                    turnos::where('idTurno', $idTurno)
                    ->update([
                        'estado'          => 0
                    ]);

                    $validador = configuracionController::validaSiExisteElTurno($time1, $time2);

                    if ($validador) {
                        $message = [
                            'mensaje' =>  'El horario especificado coincide con otro turno guardado previamente',
                            'tipo' => 'alert alert-danger'
                        ];

                        return redirect()->action('User\configuracionController@editarTurnoFailed', ['id' => $request->idTurno]);

                    }else {
                        $message = [
                            'mensaje' =>  'Se guardo con exito',
                            'tipo' => 'alert alert-success'
                        ];

                        turnos::where('idTurno', $request->idTurno)
                            ->update([
                                'turno'          => $request->nombre,
                                'horaInicio'     => date("H:i", strtotime($request->horaInicio)),
                                'horaFinal'      => date("H:i", strtotime($request->horaFin)),
                                'descripcion'    => ($request->descripcion=='')?'N/D':$request->descripcion,
                                'estado'         => 1
                            ]);

                            return redirect()->action('User\configuracionController@editarTurnoSuccess');
                    }
                }
            }
        }
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Turno;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class TurnoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*public function index()
    {
        return view('User.Configuracion.index');
    }*/

    public function index() {
        $turnos = Turno::where('estado', 1)->orderBy('horaInicio', 'asc')->get();
        $message = [
            'mensaje' =>  '',
            'tipo' => ''
        ];
        return view('User.Turnos.index', compact('turnos', 'message'));
    }

    public function create() {
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

    public function store(Request $request) {
        $messages = array(
            'required' => 'El :attribute es un campo requerido'
        );

        $validator = Validator::make($request->all(), [
            'nombre'        => 'required|max:255',
            'horaInicio'    => 'required',
            'horaFin'       => 'required',
            'descripcion'   => 'required|max:255'
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $time1 = date("H:i", strtotime($request->horaInicio));
        $time2 = date("H:i", strtotime($request->horaFin));
        $validateHora = TurnoController::validaSiExisteElTurno($time1, $time2);

        if ($validateHora) {
            return redirect()->back()->with('message-error', 'El horario especificado coincide con otro turno guardado previamente :/');
        }else {
            $turnos = new Turno();
            $turnos->turno = $request->nombre;
            $turnos->horaInicio = date("H:i", strtotime($request->horaInicio));
            $turnos->horaFinal = date("H:i", strtotime($request->horaFin));
            $turnos->descripcion = ($request->descripcion=='')?'N/D':$request->descripcion;
            $turnos->estado = 1;
            $turnos->save();

            return redirect()->back()->with('message-success', 'Se guardo con exito :)');
        }
    }

    public function edit($id) {
        $turno = Turno::where('id', $id)->get()->toArray();

        $message = [
            'mensaje' =>  '',
            'tipo' => ''
        ];

        return view('User.Turnos.editar', compact(['message', 'turno']));
    }

    public function destroy($id) {
        Turno::where('id', $id)
            ->update([
                'estado' => 0
            ]);

        return (response()->json(true));
    }

    public function update(Request $request) {

        $validatedData = $request->validate([
            'id' => 'required',
            'nombre' => 'required|max:255',
            'horaInicio' => 'required',
            'horaFin' => 'required'
        ]);

        if ($validatedData)
        {
            $id    = $request->id;
            $time1      = date("H:i:s", strtotime($request->horaInicio));
            $time2      = date("H:i:s", strtotime($request->horaFin));

            $turnos = Turno::where('id', $request->id)->get()->toArray();

            if ( count($turnos)>0 )
            {

                if ( $turnos[0]['horaInicio']==$time1 && $turnos[0]['horaFinal']==$time2 )
                {
                    Turno::where('id', $id)
                        ->update([
                            'turno'          => $request->nombre,
                            'descripcion'    => ($request->descripcion=='')?'N/D':$request->descripcion
                        ]);

                    return redirect()->action('User\configuracionController@editarTurnoSuccess');

                }
                else {

                    Turno::where('id', $id)
                        ->update([
                            'estado'          => 0
                        ]);

                    $validador = TurnoController::validaSiExisteElTurno($time1, $time2);

                    if ($validador) {
                        $message = [
                            'mensaje' =>  'El horario especificado coincide con otro turno guardado previamente',
                            'tipo' => 'alert alert-danger'
                        ];

                        //return redirect()->action('User\configuracionController@editarTurnoFailed', ['id' => $request->id]);
                        return Redirect::back()->withErrors("La fecha final no puede ser menor a la fecha inicial")->withInput();
                    }else {
                        $message = [
                            'mensaje' =>  'Se guardo con exito',
                            'tipo' => 'alert alert-success'
                        ];

                        Turno::where('id', $request->id)
                            ->update([
                                'turno'          => $request->nombre,
                                'horaInicio'     => date("H:i", strtotime($request->horaInicio)),
                                'horaFinal'      => date("H:i", strtotime($request->horaFin)),
                                'descripcion'    => ($request->descripcion=='')?'N/D':$request->descripcion,
                                'estado'         => 1
                            ]);

                        //return redirect()->action('User\configuracionController@editarTurnoSuccess');
                        return redirect()->back()->with('message-success', 'Se creo la Orden de Produccion con exito :)');
                    }
                }
            }
        }
    }
}

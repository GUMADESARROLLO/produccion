<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\usuario;
use App\Models\Admin\Rol;
use Illuminate\Support\Facades\Validator;
use Redirect;
use DB;


class usuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $message = [
            'mensaje' =>  '',
            'tipo' => ''
        ];
        $user = usuario::orderBy('id', 'asc')->get();
        return view('Admin.Admin.Usuario.index', compact(['user', 'message']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        $message = [
            'mensaje' =>  '',
            'tipo' => ''
        ];
        $rol = Rol::orderBy('id', 'asc')->get();

        return view('Admin.Admin.Usuario.crear', compact(['rol', 'message']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request)
    {

        $messages = array(
            'required' => 'El :attribute es un campo requerido'
        );

        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users|max:100',
            'password' => 'required|max:255',
            'nombre'   => 'required|max:255',
            'apellido' => 'required|max:255',
            'fechaNac' => 'required|date',
            'rol_id'   => 'required'
        ], $messages);

        if ($validator->fails()) {
            return redirect()->action('Admin\usuarioController@guardarUserFailed');
        }

        $user = new usuario();
        $user->nombres = $request->nombre;
        $user->apellidos = $request->apellido;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->fecha_nacimiento = $request->fechaNac;
        $user->image = 'none';
        $user->estado = true;
        $user->id_grupo = 0;
        $user->save();

        $user->roles()->attach($request->rol_id);

        return redirect()->action('Admin\usuarioController@guardarUserSuccess');
    }

    public function guardarUserSuccess()
    {
        $message = [
            'mensaje' =>  'Guardado con exito',
            'tipo' => 'alert alert-success'
        ];

        $rol = Rol::orderBy('id', 'asc')->get();
        return view('Admin.Admin.Usuario.crear', compact(['rol', 'message']));
    }

    public function guardarUserFailed()
    {
        $message = [
            'mensaje' =>  'Digite todos los campos requeridos',
            'tipo' => 'alert alert-danger'
        ];

        $rol = Rol::orderBy('id', 'asc')->get();
        return view('Admin.Admin.Usuario.crear', compact(['rol', 'message']));
    }

    
    public function editarUser($idUser)
    {
        $user  = usuario::where('id', $idUser)->where('estado', 1)->get()->toArray();
        $rol = Rol::orderBy('id', 'asc')->get();

        return view('Admin.Admin.Usuario.editar', compact(['user', 'rol']));
    }

    public function actualizarUser(Request $request)
    {
         $messages = array(
            'required' => 'El :attribute es un campo requerido'
        );
        
        $validator = Validator::make($request->all(), [
            'rol_id'   => 'required',
            'password' => 'required|max:255',
            'nombre'   => 'required|max:255',
            'apellido' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('message-success', 'No Se actualizo el usuario :)');
        }

        $user = new usuario();

        usuario::where('id', $request->id_usuario)
            ->update([
                'nombres'               => $request->nombre,
                'apellidos'             => $request->apellido,
                'password'              => Hash::make($request->password)
            ]);


        $user = usuario::findOrFail($request->id_usuario);

        $id = $user->roles()->first()->id;

        $user->roles()->updateExistingPivot($id, ['rol_id' => $request->rol_id]);

        //usuario::find($request->id_usuario)->roles()->updateExistingPivot('',['rol_id' => $request->id_rol]);

        return redirect()->back()->with('message-success', 'Se actualizo el usuario con exito :)');
    }



    public function detalleUser($idUser)
    {

        $user  = usuario::where('id', $idUser)->where('estado', 1)->get()->toArray();

        $userById = usuario::findOrFail($idUser);

        $id_rol = $userById->roles()->first()->id;

        $rol  = Rol::where('id', $id_rol)->get();

        //echo $rol;
        return view('Admin.Admin.Usuario.detalle', compact(['user', 'rol']));
    }

    public function eliminarUser($idUser)
    {


        usuario::where('id', $idUser)
            ->update([
                'estado' => 0
            ]);

        return (response()->json(true));

        //echo $rol;
    }

    public function activarUser($idUser)
    {


        usuario::where('id', $idUser)
            ->update([
                'estado' => 1
            ]);

        return (response()->json(true));

        //echo $rol;
    }
    
}

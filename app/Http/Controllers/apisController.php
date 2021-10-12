<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\grupos_model;
use App\Models\Admin\tareasModel;
use App\Models\Admin\paquetes;
use App\Models\Admin\paquete_tarea;
use App\Models\Admin\tareas_realizadas;
use Validator;
use App\User;
use DB;

class apisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getGrupos()
    {
        $grupos = grupos_model::all();
        return response()->json($grupos);
    }

    public function login(Request $request) {
        
        $request->validate([
            'username' => 'required|string',
            'password'    => 'required|string'
        ]);

        $credentials = request(['username', 'password']);
        $set = array();

        if (!Auth::attempt($credentials)) {
            $set['result'][] = array('msg' => 'Account disabled', 'success' => '0');
            return response()->json( $set );
        } else {
            $user = $request->user();            
            $set['result'][] = array(
                'id' => 0,
                'nombres' => $user->nombres,
                'apellidos' => $user->apellidos,
                'username' => $user->username,
                'fecha_nacimiento' => $user->fecha_nacimiento,
                'estado' => $user->estado,
                'id_grupo' => $user->id_grupo,
                'success' => 1
            );
        }

        return response()->json($set);

    }

    public function signup(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'nombres' => ['required', 'string', 'min:3', 'max:255'],
            'apellidos' => ['required', 'string', 'min:3', 'max:255'],
            'username' => ['required', 'string', 'min:3', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:10'],
            'fecha_nacimiento' => 'required',
            'id_grupo' =>'required|integer'
        ]);

        if ($validator->fails()) {
            $set['result'][] = array('msg' => 'Failed', 'success' => '0');
            return response()->json( $set );
        }

        $user = new User([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'username' => $request->username,
            'password' =>  Hash::make($request->password),
            'fecha_nacimiento' => date('Y-m-d', strtotime($request->fecha_nacimiento)),
            'image' => 'none',
            'estado' => 1,
            'id_grupo' => $request->id_grupo
        ]);

        $user->save();
        $set['result'][] = array('msg' => 'Success', 'success' => '1');
        return response()->json( $set );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function getTareas($idUser) {
        $array = array();
        $idGrupo = DB::table('users')->where('id', $idUser)->pluck('id_grupo');
        $i=0;

        if (!$idGrupo->isEmpty()) {
            
            $tareas = paquetes::select('tareas.id as tarea_id', 'tareas.descripcion as tarea_desc', 'paquetes.id as paquete_id')
                                ->join('paquete_tarea', 'paquetes.id', '=', 'paquete_tarea.id_paquete')
                                ->join('tareas', 'paquete_tarea.id_tarea', '=', 'tareas.id')
                                ->where('paquetes.id_grupo', $idGrupo)
                                ->where('paquetes.estado', true)
                                ->get();

            foreach ($tareas as $key) {
                $set['result'][$i]['tarea_id'] = $key['tarea_id'];
                $set['result'][$i]['tarea_desc'] = $key['tarea_desc'];
                $set['result'][$i]['paquete_id'] = $key['paquete_id'];

                if (tareas_realizadas::where('id_usuario', $idUser)
                                    ->where('id_tarea', $key['tarea_id'])
                                    ->where('id_paquete', $key['paquete_id'])->exists()) {
                    $set['result'][$i]['estado'] = true;
                }else {
                    $set['result'][$i]['estado'] = false;
                }
                $i++;
            }
            
            return response()->json( $set );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function postTarea(Request $request) {
        $tr = new tareas_realizadas();
        $msj = 'fail';
        $success = 0;
        $tmp = false;

        $st = $tr::where('id_usuario', $request->usuario_id)
                            ->where('id_tarea', $request->tarea_id)
                            ->where('id_paquete', $request->paquete_id)->exists();

        if ($st) {

            if ($request->estado==0) {                
                $tmp = $tr::where('id_usuario', $request->usuario_id)
                            ->where('id_tarea', $request->tarea_id)
                            ->where('id_paquete', $request->paquete_id)->delete();
            }

        }else {
            if ($request->estado==1) {
                $tmp = $tr->id_usuario = $request->usuario_id;
                $tr->id_tarea = $request->tarea_id;
                $tr->id_paquete = $request->paquete_id;
                $tr->save();
            }
        }

        if ($tmp) {
            $msj = 'sucess';
            $success = 1;
        }

        $set['result'][] = array('msg' => $msj, 'success' => $success);
        return response()->json( $set );
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Rol;
use App\Models\Admin\Menu;
use App\Models\Admin\MenuRol;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;



class MenuRolController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Rol::orderBy('id')->pluck('descripcion', 'id')->toArray();
        $menus = Menu::getMenu();
        $menusRoles = Menu::with('roles')->get()->pluck('roles', 'id')->toArray();

        return view('Admin.MenuRol.index', compact('roles', 'menus', 'menusRoles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request)
    {
        if ($request->ajax()) {
            $menus = new Menu();
            $array = array();
            $i = 0;
            $menu_id = $request->input('menu_id');
            if ($request->input('estado') == 1) {
                $menus->find($request->input('menu_id'))->roles()->attach($request->input('rol_id'));

                $Sub_menus = Menu::select('id')->where('menu_id', $request->input('menu_id'))->orderBy('id', 'asc')->get();
                if(is_null($Sub_menus)){
                    return response("Este rol no posee sub menus :O", 400);
                }else{
                    foreach ($Sub_menus as $key) {
                        // $array[$i]['id'] = $key['id'];
                         $menus->find($key['id'])->roles()->attach($request->input('rol_id'));
                         $i++;
                     }
                     return response("Se ha asignado el permiso al rol seleccionado ʕ•́ᴥ•̀っ♡", 200);
                }
            } else {
                $menus->find($request->input('menu_id'))->roles()->detach($request->input('rol_id'));

                $Sub_menus = Menu::select('id')->where('menu_id', $request->input('menu_id'))->orderBy('id', 'asc')->get();
                if(is_null($Sub_menus)){
                    return response("Este rol no posee sub menus :O", 400);
                }else{
                    foreach ($Sub_menus as $key) {
                        // $array[$i]['id'] = $key['id'];
                         $menus->find($key['id'])->roles()->detach($request->input('rol_id'));
                         $i++;
                     }
                     return response("Se ha eliminado el permiso al rol selecccionado  ʕ•́ᴥ•̀っ♡", 400);
                }
            }
        } else {
            abort(404);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Rol;
use App\Models\Admin\Menu;

class MenuRolController extends Controller {
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
    public function index() {
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
    public function guardar(Request $request) {
        if ($request->ajax()) {
            $menus = new Menu();

            if ($request->input('estado')==1) {                
                $menus->find($request->input('menu_id'))->roles()->attach($request->input('rol_id'));
            }else {
                $menus->find($request->input('menu_id'))->roles()->detach($request->input('rol_id'));
            }
        } else {
            abort(404);
        }
    }
}

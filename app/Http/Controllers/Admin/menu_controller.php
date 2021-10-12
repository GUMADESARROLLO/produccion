<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Menu;

class menu_controller extends Controller
{
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
        return view('Admin.Menu.crear');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request) {
        $menu = new Menu();
        $menu->nombre = $request->nombre;
        $menu->url = $request->url;
        $menu->icono = $request->icono;
        $menu->orden = 0;
        $menu->menu_id = 0;
        $menu->save();

        return redirect('menu/crear');
    }

    public function guardarOrden(Request $request) {
        if ($request->ajax()) {
            $menu = new Menu;
            $menu->guardarOrden($request->menu);
            return response()->json(['response' => 'ok']);
        }else {
            abort(404);
        }
    }
}

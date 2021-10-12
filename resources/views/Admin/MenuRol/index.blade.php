@extends('layouts.main')
@section('metodosjs')
  @include('jsViews.js_menurol')
@endsection

@section('styles')
<link href="{{ asset('js/jquery.nestable.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('scriptsPlugins')
<script src="{{ asset('js/jquery.nestable.js') }}" type="text/javascript"></script> 
@endsection

@section('content')
<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-10">
                                <div class="page-header-title">
                                    <h5 class="m-b-10">Asignacion de Menus</h5>
                                    <!--{{ session()->get('rol') }}-->
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:">Menu</a></li>
                                </ul>
                            </div>
                            <div class="col-md-2">
                                <a href="{{url('menu/crear')}}" class="btn btn-primary btn-sm  float-right">Nuevo Menu</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ Orden del Menu ] start -->
                <div class="card-body">

                </div>
                <!-- [ Orden del Menu ] end -->
                <!-- [ breadcrumb ] start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <!-- [ Tabla Asignacion de Menu ] start -->
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Asignacion de Permisos</h5>
                                    </div>  
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>menu</th>
                                                        @foreach ($roles as $id => $descripcion)
                                                            <th>{{$descripcion}}</th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($menus as $key => $menu) 
                                                        <tr class="unread">
                                                            <td>{{$menu['nombre']}}</td>
                                                            @foreach ($roles as $id => $descripcion)
                                                            <td class="text-center">
                                                                <input type="checkbox" class="menu_rol" name="menu_rol[]" data-menuid={{$menu["id"]}}  value="{{$id}}" {{ in_array($id, array_column($menusRoles[$menu["id"]], "id"))? "checked":" "}}>
                                                            </td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Tabla Asignacion de Menu ] end -->
                            <!-- [ Tabla orden de Menu ] start -->
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Orden de Menu</h5>
                                    </div>  
                                    <div class="card-block table-border-style">
                                        @csrf
                                        <div class="dd" id="nestable">
                                            <ol class="dd-list">
                                                @foreach ($menus as $key => $item)
                                                    @if ($item["menu_id"] != 0)
                                                        @break
                                                    @endif
                                                    @include("Admin.Menu.menu-item",["item" => $item])
                                                @endforeach
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Tabla orden de Menu ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->
@endsection
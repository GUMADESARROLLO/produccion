@extends('layouts.main')

@section('metodosjs')
@include('jsViews.js_usuario')
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
                            <div class="col-md-12">
                                <div class="page-header-title">
                                    <h5 class="m-b-10">Usuario</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="{{url('/usuario')}}">Usuarios</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:">Detalle</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <!-- [ Tabla Categorias ] start -->
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Detalle del Usuario</h5>
                                    </div>
                                    <div class="card-block">
                                        {{ csrf_field() }}
                                        @foreach ($user as $user)
                                        <input type="hidden" name="id_usuario" id="id_usuario" value="{{ $user['id'] }}">

                                        <div class="form-group">
                                            <label for="nombre">Nombres</label>
                                            <input type="text" readonly class="form-control" name="nombre" id="nombre" value="{{ $user['nombres'] }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="apellido">Apellidos</label>
                                            <input type="text" readonly class="form-control" name="apellido" id="apellido" value="{{ $user['apellidos']}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Nombre de usuario</label>
                                            <input type="text" readonly class="form-control" name="username" id="username" value="{{ $user['username']}}">
                                        </div>
                                        @endforeach
                                        <div class="form-group">
                                            <label for="rol">Rol asignado</label>
                                            @foreach ($rol as $rol)
                                            <label for="password"></label>
                                            <input type="text" class="form-control" readonly id="rol_id" name="rol_id" value="{{ $rol['descripcion'] }}">
                                            @endforeach
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Tabla Categorias ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->
@endsection

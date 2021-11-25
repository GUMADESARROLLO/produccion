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
                                    <li class="breadcrumb-item"><a href="javascript:">Nuevo</a></li>
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
                                        <h5>Nuevo Usuario</h5>
                                    </div>
                                    <div class="{{ $message['tipo'] }}">{{ $message['mensaje'] }}</div>
                                    <div class="card-block">
                                        <form method="post" action="{{url('usuario/guardar')}}">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label for="nombre">Nombres</label>
                                                <input type="text" class="form-control" name="nombre" id="nombre">
                                                <small id="nombreHelp" class="form-text text-muted">Escriba su unico nombre o sus dos nombres</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="apellido">Apellidos</label>
                                                <input type="text" class="form-control" name="apellido" id="apellido">
                                                <small id="apellidoHelp" class="form-text text-muted">Escriba su apellido o sus dos apellidos</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="username">Usuario</label>
                                                <input type="text" class="form-control" name="username" id="username">
                                                <small id="usernameHelp" class="form-text text-muted">Escriba un nombre de usuario</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Contraseña</label>
                                                <input type="text" class="form-control" name="password" id="password">
                                                <small id="passwordHelp" class="form-text text-muted">Escriba su contraseña</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="rol">Seleccione un rol</label>
                                                <select class="form-control" id="rol_id" name="rol_id">
                                                    <option>Seleccione un rol</option>
                                                    @foreach ($rol as $rol)
                                                    <option value="{{ $rol['id'] }}">{{ $rol['descripcion'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Enviar</button>
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

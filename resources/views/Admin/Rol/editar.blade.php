@extends('layouts.main')

@section('metodosjs')

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
                                    <h5 class="m-b-10">Menu</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="{{url('/rol')}}">Roles</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:">Editar</a></li>
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
                                        <h5>Crear Rol</h5>
                                    </div>
                                    <div class="card-block">
                                        <form method="post" action="{{url('rol/actualizar')}}">
                                            @foreach ($rol as $rol)
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" id="id" value="{{ $rol['id'] }}">
                                            <div class="form-group">
                                                <label for="descripcion">Nombre</label>
                                                <input type="text" class="form-control" name="descripcion" id="descripcion" value="{{ $rol['descripcion']}}">
                                                <small id="nombreHelp" class="form-text text-muted">Escriba el nombre del nuevo rol</small>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Enviar</button>
                                            @endforeach
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
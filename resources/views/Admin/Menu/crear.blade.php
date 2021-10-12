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
                                    <li class="breadcrumb-item"><a href="{{url('/menu')}}">Menu</a></li>
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
                                        <h5>Nuevo menu</h5>
                                    </div>  
                                    <div class="card-block">
                                        <form method="post" action="{{url('menu/guardar')}}">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label for="nombre">Nombre</label>
                                                <input type="text" class="form-control" name="nombre" id="nombre">
                                                <small id="nombreHelp" class="form-text text-muted">Escriba el nombre del nuevo menu</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="url">Url</label>
                                                <input type="text" class="form-control" name="url" id="url">
                                                <small id="urlHelp" class="form-text text-muted">Escriba direccion url</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="icono">Icono</label>
                                                <input type="text" class="form-control" name="icono" id="icono">
                                                <small id="iconoHelp" class="form-text text-muted">Icono del item</small>
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
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
                                        <h5 class="m-b-10">Nuevo Costo</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                    <!--<li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>-->
                                        <li class="breadcrumb-item"><a href="{{url('/costos')}}">Costos</a></li>
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
                                            <h5>Complete los siguientes campos</h5>
                                        </div>
                                        @if(session()->has('message-success'))
                                            <div class="alert alert-success">
                                                {{ session()->get('message-success') }}
                                            </div>
                                        @endif
                                        @if (count($errors) > 0)
                                            <div class="alert alert-danger">
                                                <p>Corrige los siguientes errores:</p>
                                                <ul>
                                                    @foreach ($errors->all() as $message)
                                                        <li>{{ $message }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="card-body">
                                            <form method="post" action="{{url('costos/guardar')}}">
                                                {{ csrf_field() }}
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="codigocosto">Codigo del costo</label>
                                                            <input type="text" class="form-control" name="codigocosto"
                                                                   id="codigocosto" value="{{old('codigocosto')}}">
                                                            <small id="codigoHelp" class="form-text text-muted">Escriba
                                                                el codigo del nuevo costo</small>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="descripcioncosto">Descripcion del costo</label>
                                                            <input type="text" class="form-control"
                                                                   name="descripcioncosto" id="descripcioncosto"
                                                                   value="{{old('descripcioncosto')}}">
                                                            <small id="descripcionHelp" class="form-text text-muted">Escriba
                                                                la descripcion del nuevo costo</small>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="unidadmedidacosto">Unidad de Medida del
                                                                costo</label>
                                                            <input type="text" class="form-control"
                                                                   name="unidadmedidacosto" id="unidadmedidacosto"
                                                                   value="{{old('unidadmedidacosto')}}">
                                                            <small id="unidadmedidaHelp" class="form-text text-muted">Escriba
                                                                la unidad de medida del nuevo costo</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary mt-5">Enviar</button>
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

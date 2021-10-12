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
                                    <h5 class="m-b-10">Editar Producto</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="{{url('/productos')}}">Productos</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:">Editar Producto</a></li>
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
                                        <h5>Edite el nombre</h5>
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
                                    <div class="card-block">
                                        <form method="post" action="{{url('producto/actualizar')}}">
                                            {{ csrf_field() }}
                                            @foreach ($producto as $p)
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="idProducto">Id del Producto</label>
                                                        <input type="text" readonly class="form-control" name="idProducto" id="idProducto" value="{{ $p['idProducto'] }}">
                                                        <small id="idTurnoHelp" class="form-text text-muted" >Id del Turno</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label for="nombre">Nombre del Producto</label>
                                                        <input type="text" class="form-control text-uppercase" name="nombre" id="nombre" value="{{ $p['nombre'] }}">
                                                        <small id="nombreHelp" class="form-text text-muted" >Escriba el nuevo nombre del producto</small>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
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
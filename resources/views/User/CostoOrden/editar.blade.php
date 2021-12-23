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
                                        <h5 class="m-b-10">Editar Detalle del Costo </h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>
                                        <li class="breadcrumb-item"><a href="{{url('/costo-orden')}}">Lista de
                                                ordenes</a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="javascript:">Editar Detalle de Costo</a>
                                        </li>
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
                                            <h5>Editar Orden</h5>
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
                                            <h5>Detalles por costo</h5>
                                            <hr>
                                            <form method="post" action="{{url('costo-orden/actualizar')}}">
                                                {{ csrf_field() }}
                                                @foreach ($costoOrden as $cor)
                                                    <div class="row" hidden>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="id">Id del Costo de la Orden</label>
                                                                <input type="text" readonly class="form-control"
                                                                       name="id" id="id" value="{{ $cor->id }}">
                                                                <small id="idcostoordenHelp"
                                                                       class="form-text text-muted">Tipo de
                                                                    Costo </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="num_Orden"># de la orden</label>
                                                                <input type="text" readonly class="form-control"
                                                                       name="num_Orden" id="num_Orden"
                                                                       value="{{ $cor->numOrden }}">
                                                                <small id="num_OrdenHelp" class="form-text text-muted">Escriba
                                                                    el # de la orden</small>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label for="costo_orden">Tipo de costo</label>

                                                                <select class="form-control" name="costo_orden"
                                                                        id="costo_orden">
                                                                    <option value="{{ $cor->costo_id }}">{{ $cor->descripcion }}</option>
                                                                </select>
                                                                <small id="costo_ordenHelp"
                                                                       class="form-text text-muted">Escriba
                                                                    la descripcion del costo</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="cantidad">Cantidad</label>
                                                                <input type="text" class="form-control" name="cantidad"
                                                                       id="cantidad" value="{{$cor->cantidad}}">
                                                                <small id="cantidadHelp" class="form-text text-muted">Escriba
                                                                    la cantidad</small>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="costo_unitario">Costo Unitario</label>
                                                                <input type="text" class="form-control"
                                                                       name="costo_unitario" id="costo_unitario"
                                                                       value="{{$cor->costo_unitario}}">
                                                                <small id="costo_unitarioHelp"
                                                                       class="form-text text-muted">Escriba
                                                                    el costo unitario</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
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

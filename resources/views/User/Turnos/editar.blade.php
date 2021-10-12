@extends('layouts.main')
@section('metodosjs')
  @include('jsViews.js_crearturno')
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
                                    <h5 class="m-b-10">Editar Turno</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="{{url('/turnos')}}">Turnos</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:">Editar Turno</a></li>
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
                                        <h5>Nuevo turno</h5>
                                    </div>
                                    
                                    <div class="{{ $message['tipo'] }}">{{ $message['mensaje'] }}</div>
                                    
                                    <div class="card-block">
                                        <form method="post" action="{{url('turnos/actualizar')}}">
                                            {{ csrf_field() }}
                                            @foreach ($turnos as $t)
                                            <div class="form-group">
                                                <label for="nombre">Id del Turno</label>
                                                <input type="text" required class="form-control" name="idTurno" id="idTurno" value="{{ $t['idTurno'] }}">
                                                <small id="idTurnoHelp" class="form-text text-muted" >Id del Turno</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="nombre">Nombre del Turno</label>
                                                <input type="text" required class="form-control text-uppercase" name="nombre" id="nombre" value="{{ $t['turno'] }}">
                                                <small id="nombreHelp" class="form-text text-muted" >Escriba el nombre del nuevo turno</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="horaInicio">Hora Inicio</label>
                                                <input type="text" required class="datetimepicker_ form-control" name="horaInicio" id="horaInicio" value="{{ $t['horaInicio'] }}">
                                                <small id="horaInicioHelp" class="form-text text-muted">Especifique la hora que inicia</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="horaFin">Hora Finaliza</label>
                                                <input type="text" required class="datetimepicker_ form-control" name="horaFin" id="horaFin" value="{{ $t['horaFinal'] }}">
                                                <small id="horaFinHelp" class="form-text text-muted">Especifique la hora que finaliza</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="descripcion">Descripcion</label>
                                                <input type="text" class="form-control" name="descripcion" id="descripcion" value="{{ $t['descripcion'] }}">
                                                <small id="descripcionHelp" class="form-text text-muted">Escriba alguna descripcion del nuevo turno</small>
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
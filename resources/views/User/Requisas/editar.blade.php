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
                                        <h5 class="m-b-10">Editar Requisa</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                    <!--<li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>-->
                                        <li class="breadcrumb-item"><a href="{{url('/requisas')}}">Requisas</a></li>
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
                                            <form method="post" action="{{url('requisas')}}">
                                                {{ csrf_field() }}
                                                @foreach ($requisa as $req)
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="numOrden">Numero de orden</label>
                                                            <input type="text" readonly class="form-control" name="numOrden"
                                                                   id="numOrden" value="{{ $req->id }}">
                                                            <small id="numOrdenHelp" class="form-text text-muted">Escriba
                                                                el # de Orden</small>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="codigo_req">Codigo</label>
                                                            <input type="text" class="form-control" name="codigo_req"
                                                                   id="codigo_req" value="{{$req->codigo_req}}">
                                                            <small id="codigo_reqHelp" class="form-text text-muted">Escriba
                                                                el codigo de la nueva requisa</small>
                                                        </div>
                                                    </div>
                                                    @endforeach

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="jefe_turno">Jefe de Turno</label>
                                                            <select class="form-control" name="jefe_turno" id="jefe_turno">
                                                                @foreach($jefe as $j)
                                                                    <option value="{{$j->id }}">{{$j->nombres}} </option>
                                                                @endforeach
                                                            </select>
                                                            <small id="jefe_turnonHelp" class="form-text text-muted">Escriba
                                                                el jefe de turno</small>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="turno">Turno</label>
                                                            <select class="form-control" name="id_turno" id="id_turno">
                                                                @foreach($turno as $t)
                                                                    <option value="{{$t['id'] }}">{{$t['descripcion']}} </option>
                                                                @endforeach

                                                            </select>
                                                            <small id="turnoHelp" class="form-text text-muted">Escriba el turno</small>
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

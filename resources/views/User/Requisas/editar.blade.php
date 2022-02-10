@extends('layouts.main')
@section('metodosjs')
@include('jsViews.js_requisas')
<style>
    a {
        cursor: pointer;
        color: rgb(49, 116, 199);
        text-decoration: none;
    }
</style>
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
                                        <form id="frmRequisas">
                                            <div class="row">
                                                <!-- method="post" action="{{url('requisas')}}" -->
                                                {{ csrf_field() }}
                                                @foreach ($requisa as $req)
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" readonly class="form-control" name="numOrden" id="numOrden" value="{{ $req->numOrden }}">
                                                        <small id="numOrdenHelp" class="form-text text-muted">Número de Orden</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="codigo_req" id="codigo_req" value="{{$req->codigo_req}}" readonly>
                                                        <small id="codigo_reqHelp" class="form-text text-muted">codigo de la requisa</small>
                                                    </div>
                                                </div>
                                                @endforeach

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <select class="form-control" name="jefe_turno" id="jefe_turno">
                                                            @foreach($jefe as $j)
                                                            <option value="{{$j->id }}">{{$j->nombres}} </option>
                                                            @endforeach
                                                        </select>
                                                        <small id="jefe_turnonHelp" class="form-text text-muted">jefe de turno</small>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <select class="form-control" name="id_turno" id="id_turno">
                                                            @foreach($turno as $t)
                                                            <option value="{{$t['id'] }}">{{$t['descripcion']}} </option>
                                                            @endforeach

                                                        </select>
                                                        <small id="turnoHelp" class="form-text text-muted">Escriba el turno</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    @foreach($requisa as $req)
                                                    @if($req['tipo'] == 1 )
                                                    <select class="form-control" name="tipo_requisa" id="tipo_requisa" disabled>
                                                        <option name="flexRadioDefault" id="Fibra" value="1" selected>Fibra</option>
                                                    </select>
                                                    @else
                                                    <select class="form-control" name="tipo_requisa" id="tipo_requisa" disabled>
                                                        <option name="flexRadioDefault" id="Quimico" value="2" selected>Quimico</option>
                                                    </select>
                                                    @endif
                                                    @endforeach
                                                    <small id="tipoRequisa" class="form-text text-muted">Tipo de Requisa</small>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mt-1  d-flex justify-content-end ">
                                                        <button class="btn btn-primary" id="btnActualizar"> Actualizar</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="id_req" value="{{$requisa[0]['id']}}">
                                        </form>
                                        <!-- TABLA DE REQUISAS -->
                                        <div class="mt-1  d-flex justify-content-center ">
                                            <div class="card border  px-5 py-5 " id="cont_R" style="width: 100% !important;">
                                                <div id="example_wrapper" class="dataTables_wrapper">
                                                    <div class="card-title text-center m-0 p-0 mb-2">
                                                        <span class="font-weight-bold text-info" id="title_Req" style="font-size: 1.5rem !important;font-weight: 1.5rem !important;"></span>
                                                    </div>
                                                    <div class="input-group mb-2" style="width: 30%" id="cont_search_Req">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                                                        </div>
                                                        <input type="text" id="SearchReq" class="form-control bg-white" placeholder="Buscar..." aria-label="Username" aria-describedby="basic-addon1">
                                                    </div>
                                                    <div class="card-block table-border-style border">
                                                        <div class="table-responsive">
                                                            <div class="table-responsive mt-3 mb-2">
                                                                <table class="table table-lg-responsive table-hover" id="tblDetalleReq" style="width: 100% !important;">
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END TABLA -->
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
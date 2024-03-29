@extends('layouts.main')
@section('metodosjs')
@include('jsViews.js_requisas')
<style>
    a {
        cursor: pointer;
        color: #5E5E5E;
        text-decoration: none;
    }

    .dataTables_paginate {
        display: flex;
        align-items: center;
        padding-top: 20px;

    }

    .dataTables_paginate a {
        padding: 0 10px;
        /*border:1px solid #979797;*/
        /* background: linear-gradient(to bottom, white 0%, #0F85FC 100%);*/
        margin-inline: 5px;
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
                                    <h5 class="m-b-10">Nueva Requisa</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <!--<li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>-->
                                    <li class="breadcrumb-item"><a href="{{url('/requisas')}}">Requisas</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:">Nueva</a></li>
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
                                        <form>
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-xl-2" hidden>
                                                    <div class="form-group row">
                                                        <div class="col-sm-7">
                                                            <select class="form-control" name="numOrden" id="numOrden">
                                                                @foreach($orden as $o)
                                                                    <option value="{{$o['numOrden'] }}">{{$o['numOrden']}} </option>
                                                                @endforeach
                                                            </select>
                                                            <small id="numOrdenHelp" class="ml-2 form-text text-muted">Escriba
                                                                el # de Orden</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" name="codigo_req" id="codigo_req" value="{{old('codigo_req')}}">
                                                            <small id="codigo_reqHelp" class="form-text text-muted">Escriba
                                                                el codigo de la nueva requisa</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <select class="form-control" name="jefe_turno" id="jefe_turno">
                                                                @foreach($jefe as $j)
                                                                <option value="{{$j->id }}">{{$j->nombres}} </option>
                                                                @endforeach
                                                            </select>
                                                            <small id="jefe_turnonHelp" class="form-text text-muted">Escriba
                                                                el jefe de turno</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <select class="form-control" name="id_turno" id="id_turno">
                                                                @foreach($turno as $t)
                                                                    <option value="{{$t['id'] }}">{{$t['turno']}} </option>
                                                                @endforeach
                                                            </select>
                                                            <small id="turnoHelp" class="form-text text-muted">Escriba el turno</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2">
                                                    <div class="form-group row pr-0">
                                                        <div class="col-sm-12">
                                                            <select class="form-control" name="id_tipo" id="id_tipo">
                                                                <option name="flexRadioDefault">Seleccione un tipo</option>
                                                                <option name="flexRadioDefault" id="Fibra" value="1">Fibra</option>
                                                                <option name="flexRadioDefault" id="Quimico" value="2">Quimico</option>
                                                            </select>
                                                            <small id="turnoHelp" class="form-text text-muted">Escriba la opción</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-2">
                                                    <button class="btn btn-primary" id="btnGuardarDR"> Guardar</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>


                                <!-- TABLA DE QUIMICOS -->
                                <div class="mt-1 d-flex justify-content-center ">
                                    <div class="card border  px-5 py-5" id="cont_quimico" style="width: 100% !important;">
                                        <div id="example_wrapper" class="dataTables_wrapper">
                                            <div class="card-title text-center m-0 p-0 mb-2">
                                                <span class="font-weight-bold text-info" id="title_material" style="font-size: 1.5rem !important;font-weight: 1.5rem !important;"></span>
                                            </div>
                                            <div class="input-group mb-2" style="width: 50%" id="cont_search">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                                                </div>
                                                <input type="text" id="InputBuscar" class="form-control bg-white" placeholder="Buscar..." aria-label="Username" aria-describedby="basic-addon1">
                                            </div>
                                            <div class="card-block table-border-style border">
                                                <div class="table-responsive">
                                                    <div class="table-responsive mt-3 mb-2">
                                                        <table class="table  table-lg-responsive table-hover" id="tblQuimicos" style="width: 100% !important;">
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END TABLA -->
                                <!-- TABLA DE FIBRAS -->
                                <div class="mt-1  d-flex justify-content-center ">
                                    <div class="card border  px-5 py-5 " id="cont_fibra" style="width: 100% !important;">
                                        <div id="example_wrapper" class="dataTables_wrapper">
                                            <div class="card-title text-center m-0 p-0 mb-2">
                                                <span class="font-weight-bold text-info" id="title_material_fb" style="font-size: 1.5rem !important;font-weight: 1.5rem !important;"></span>
                                            </div>
                                            <div class="input-group mb-2" style="width: 50%" id="cont_search_fib">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                                                </div>
                                                <input type="text" id="InputBuscarFibras" class="form-control bg-white" placeholder="Buscar..." aria-label="Username" aria-describedby="basic-addon1">
                                            </div>
                                            <div class="card-block table-border-style border">
                                                <div class="table-responsive">
                                                    <div class="table-responsive mt-3 mb-2">
                                                        <table class="table table-lg-responsive table-hover" id="tblFibras" style="width: 100% !important;">
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END TABLA -->
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

<!-- [ Main Content ] end -->
@endsection

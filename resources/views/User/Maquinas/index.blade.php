@extends('layouts.main')
@section('metodosjs')
  @include('jsViews.js_maquinas')
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
                            <div class="col-md-10">
                                <div class="page-header-title">
                                    <h5 class="m-b-10">Maquinas</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:">Maquinas</a></li>
                                </ul>
                            </div>
                            <div class="col-md-2">
                                <a href="{{url('maquina/nueva')}}" class="btn btn-primary btn-sm  float-right">Nueva Maquina</a>
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
                                        <h5>Lista de Maquinas</h5>
                                    </div>  
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="dtFibras">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>ID</th>
                                                        <th>NOMBRE</th>
                                                        <th>ESTADO</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($maquinas as $key => $maq)
                                                    <tr class="unread">
                                                        <td class="dt-center">{{ $key+1 }}</td>
                                                        <td class="dt-left">{{ strtoupper($maq->nombre) }}</td>
                                                        <td class="dt-center">
                                                            @if ( $maq->estado )
                                                            <span class="badge badge-success">Activo</span>
                                                            @else
                                                            <span class="badge badge-danger">Inactivo</span>
                                                            @endif
                                                        </td>                                                        
                                                        <td class="dt-center">
                                                            <a href="#!" onclick="deleteMaquina({{$maq->idMaquina}})"><i class="feather icon-x-circle text-c-red f-30 m-r-10"></i></a>
                                                            <a href="maquina/editar/{{ $maq->idMaquina }}"><i class="feather icon-edit text-c-blue f-30 m-r-10"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
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
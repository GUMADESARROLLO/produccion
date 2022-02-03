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
                                <div class="col-md-10">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Lista de Requisas</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <!--<li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>-->
                                        <li class="breadcrumb-item"><a href="javascript:">Lista de Requisas</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-2">
                                    <a href="{{url('requisas/create')}}" class="btn btn-primary btn-sm  float-right">Nuevo
                                        Requisa</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ breadcrumb ] start -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">

                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>LISTA DE REQUISAS</h5>
                                        </div>
                                        <div class="card-block table-border-style">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>#</th>
                                                            <th>No. Orden</th>
                                                            <th>Codigo</th>
                                                            <th>Turno</th>
                                                            <th>Fecha Creacion</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach ($requisas as $key)
                                                        <tr class="unread">
                                                            <td class="dt-center">
                                                                <h6>{{ $key['id'] }}</h6>
                                                            </td>
                                                            <td class="dt-center">
                                                                <h6>{{ $key['numOrden'] }}</h6>
                                                            </td>
                                                            <td class="dt-center">
                                                                <h6>{{ $key['codigo_req'] }}</h6>
                                                            </td>
                                                            <td class="dt-center">
                                                                <h6>{{ $key['turno'] }}</h6>
                                                            </td>
                                                            <td class="dt-center">
                                                                <h6>{{ strtoupper(date('d.m.y g:i a', strtotime($key->created_at)))}}</h6>
                                                            </td>
                                                            <td class="dt-center">
                                                                <a href="#!" onclick="deleteTurno()"><i class="feather icon-x-circle text-c-red f-30 m-r-10"></i></a>
                                                                <a href="requisas/{{ $key['id'] }}/edit"><i class="feather icon-edit text-c-blue f-30 m-r-10"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- [ Tabla ] end -->
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection

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
                
                <!-- [ breadcrumb ] start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <!-- [ Tabla Categorias ] start -->
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header border-secondary">
                                        <h5><b>TURNOS</b></h5>
                                        <a href="{{url('turnos/create')}}"><i class="float-right fa fa-plus-circle" style="font-size:20px; color:purple"></i></a>
                                    </div>

                                    <div class="card-body col-sm-12 p-0 mb-2">	
                                        <div class="p-0 px-car">
                                            <div class="flex-between-center scrollbar border border-1 border-300 rounded-2">
                                            <table class="table table-striped table-bordered table-sm mt-3 fs--1" id="tbl_turno">
                                                    <thead>
                                                        <tr class="text-light text-center" style="background-color: purple;">
                                                            <th>ID</th>
                                                            <th>TURNO</th>
                                                            <th>HORA INICIO</th>
                                                            <th>HORA FINALIZA</th>
                                                            <th>DESCRIPCION</th>
                                                            <th>ACCION</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($turnos as $tur)
                                                        <tr class="unread">
                                                            <td class="dt-center">{{ $tur['id'] }}</td>
                                                            <td class="dt-center">{{ strtoupper($tur['turno']) }}</td>
                                                            <td class="dt-center">{{ strtoupper(date('g:i a', strtotime($tur->horaInicio))) }}</td>
                                                            <td class="dt-center">{{ strtoupper(date('g:i a', strtotime($tur->horaFinal))) }}</td>
                                                            <td class="dt-center">{{ strtoupper($tur['descripcion']) }}</td>
                                                            <td class="dt-center">
                                                                <a href="#!" onclick="deleteTurno({{$tur['id']}})"><i class="far fa-trash-alt text-c-red f-20 m-r-10"></i></a>
                                                                <a href="turnos/{{ $tur['id'] }}/edit"><i class="far fa-edit text-c-blue f-20 m-r-10"></i></a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
											    </table>
                                            </div>
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

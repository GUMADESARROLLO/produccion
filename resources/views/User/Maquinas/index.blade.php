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
                <!-- [ breadcrumb ] start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <!-- [ Tabla Categorias ] start -->
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header border-secondary">
                                        <h5><b>MAQUINAS</b></h5>
                                        <a href="{{url('maquina/nueva')}}"><i class="float-right fa fa-plus-circle" style="font-size:20px; color:purple"></i></a>
                                    </div>
                                    <div class="card-body col-sm-12 p-0 mb-2">	
                                        <div class="p-0 px-car">
                                            <div class="flex-between-center scrollbar border border-1 border-300 rounded-2">
                                                <table class="table table-striped table-bordered table-sm mt-3 fs--1" id="tbl_maquinas">
                                                    <thead>
                                                        <tr class="text-light text-center" style="background-color: purple;">
                                                            <th width="140px">ID</th>
                                                            <th>NOMBRE</th>
                                                            <th width="160px">ACCION</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($maquinas as $key => $maq)
                                                        <tr class="unread">
                                                            <td class="dt-center">{{ $key+1 }}</td>
                                                            <td class="dt-left">{{ strtoupper($maq->nombre) }}</td>
                                                            <td class="dt-center">
                                                                <a href="#!" onclick="deleteMaquina({{$maq->idMaquina}})"><i class="far fa-trash-alt text-c-red f-20 m-r-10"></i></a>
                                                                <a href="maquina/editar/{{ $maq->idMaquina }}"><i class="far fa-edit text-c-blue f-20 m-r-10"></i></a>
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

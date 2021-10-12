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
                                    <h5 class="m-b-10">Orden de Producción</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:">Orden de Producción</a></li>
                                </ul>
                            </div>
                            <div class="col-md-2">
                                <a href="{{url('orden-produccion/nueva')}}" class="btn btn-primary btn-sm  float-right">Nueva Orden</a>
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
                                        <h5>Orden de Produccion</h5>
                                    </div>  
                                    <div class="card-block px-0 py-3">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>NO. ORDEN</th>
                                                        <th>PRODUCTO</th>
                                                        <th>FECHA INICIO</th>
                                                        <th>FECHA FINAL</th>
                                                        <th>HORA INICIO</th>
                                                        <th>HORA FINAL</th>
                                                        <th>ESTADO</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($array as $key)
                                                    <tr class="unread">
                                                        <td class="dt-center">
                                                            <h6>{{ $key['numOrden'] }}</h6>
                                                        </td>
                                                        <td class="dt-center">
                                                            <h6>{{ $key['producto'] }}</h6>
                                                        </td>
                                                        <td class="dt-center">
                                                            <h6>{{ $key['fechaInicio'] }}</h6>
                                                        </td>
                                                        <td class="dt-center">
                                                            <h6>{{ $key['fechaFinal'] }}</h6>
                                                        </td>
                                                        <td class="dt-center">
                                                            <h6>{{ $key['horaInicio'] }}</h6>
                                                        </td>
                                                        <td class="dt-center">
                                                            <h6>{{ $key['horaFinal'] }}</h6>
                                                        </td>
                                                        <td class="dt-center">
                                                            @if ( $key['estado'] )
                                                            <span class="badge badge-success">Activo</span>
                                                            @else
                                                            <span class="badge badge-danger">Inactivo</span>
                                                            @endif
                                                        </td>  
                                                        <td class="dt-center">
                                                            <a href="orden-produccion/reporte/{{ $key['numOrden'] }}"><i class="feather icon-edit-1 text-c-red f-30 m-r-10"></i></a>
                                                            <a href="orden-produccion/editar/{{ $key['numOrden'] }}"><i class="feather icon-edit text-c-blue f-30 m-r-10"></i></a>
                                                            <a href="orden-produccion/detalle/{{ $key['numOrden'] }}"><i class="feather icon-eye text-c-black f-30 m-r-10"></i></a>
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
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
                <!-- [ breadcrumb ] start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <!-- [ Tabla Categorias ] start -->
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header border-secondary">
                                        <h5><b>ROL</b></h5>
                                        <a href="{{url('rol/crear')}}"><i class="float-right fa fa-plus-circle" style="font-size:20px; color:purple"></i></a>
                                   </div>  
                                    <div class="card-body col-sm-12 p-0 mb-2">	
                                        <div class="p-0 px-car">
                                            <div class="flex-between-center scrollbar border border-1 border-300 rounded-2">
                                                <table class="table table-striped table-bordered table-sm mt-3 fs--1" id="tbl_rol">
                                                    <thead>
                                                    <tr class="text-light text-center" style="background-color: purple;">
                                                            <th width="140px">COD. ROL</th>
                                                            <th>DESCRIPCION</th>
                                                            <th width="140px">ACCION</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($roles as $rol)
                                                        <tr class="unread">
                                                            <td class="text-center">{{ $rol['id'] }}</td>
                                                            <td>{{ $rol['descripcion'] }}</td>
                                                            <td class="text-center">
                                                                <!-- <a href="rol/{{ $rol['id'] }}"><i class="feather icon-eye text-c-green f-30 m-r-10"></i></a> -->
                                                                <a href="rol/edit/{{$rol['id']}}"><i class="far fa-edit text-c-blue f-20 m-r-10"></i></a>
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
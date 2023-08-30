@extends('layouts.main')
@section('metodosjs')
@include('jsViews.js_costo_orden')
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
                        </div>
                    </div>
                    <!-- [ breadcrumb ] start -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <!-- [ Tabla Categorias ] start -->
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header border-secondary">
                                            <h5><b>LISTA DE COSTOS</b></h5>
                                            <a href="{{url('costos/nuevo')}}"><i class="float-right fa fa-plus-circle" style="font-size:20px; color:purple"></i></a>
                                        </div>
                                        <div class="card-body col-sm-12 p-0 mb-2">	
                                            <div class="p-0 px-car">
                                                <div class="flex-between-center scrollbar border border-1 border-300 rounded-2">
                                                    <table class="table table-striped table-bordered table-sm mt-3 fs--1" id="dtOrder">
                                                        <thead>
                                                            <tr class="text-light text-center" style="background-color: purple;">
                                                                <th>CODIGO</th>
                                                                <th>DESCRIPCION</th>
                                                                <th>U/M</th>
                                                                <th>DETALLE</th>
                                                            </tr>
                                                        </thead>
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

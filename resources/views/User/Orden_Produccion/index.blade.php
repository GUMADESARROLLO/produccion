@extends('layouts.main')
@section('metodosjs')
@include('jsViews.js_ordenproduccionindex')
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
                                    <div class="card-header border-secondary">
                                        <h5><b>ORDEN DE PRODUCCION</b></h5>
                                        <a href="{{url('orden-produccion/nueva')}}"><i class="float-right fa fa-plus-circle" style="font-size:20px; color:purple"></i></a>
                                    </div>
                                    <div class="input-group mt-4 ml-2" style="width: 98%;" id="cont_search">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                                        </div>
                                        <input type="text" id="InputBuscar" class="form-control bg-white" placeholder="Buscar..." aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                    <div class="card-body col-sm-12 p-0 mb-2">	
                                        <div class="p-0 px-car">
                                            <div class="flex-between-center scrollbar border border-1 border-300 rounded-2">
                                                <table class="table table-striped table-bordered table-sm mt-3 fs--1" id="tblOrder_produccion">
                                                    <thead>
                                                        <tr class="text-light text-center" style="background-color: purple;">
                                                            <th width="100px">N° ORDEN</th>
                                                            <th>PRODUCTO</th>
                                                            <th width="120px">FECHA INICIO</th>
                                                            <th width="120px">FECHA FINAL</th>
                                                            <th width="120px">PROD. REAL(kg)</th>
                                                            <th width="120px">PROD. TOTAL(kg)</th>
                                                            <th width="100px">OPCIONES</th>
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

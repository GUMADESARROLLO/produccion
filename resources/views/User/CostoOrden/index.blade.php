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
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->

                        <!-- [ Main Content ] end -->

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header border-secondary">
                                        <h5 class="mt-2"><b>LISTA DE ORDENES</b></h5>
                                        <div class="input-group float-right" style="width: 500px;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                                        </div>								
                                        <input type="text" id="InputBuscar" class="form-control" placeholder="Buscar...">
                                    </div>
                                    </div>
                                    <div class="card-body col-sm-12 p-0 mb-2">	
                                        <div class="p-0 px-car">
                                            <div class="flex-between-center scrollbar border border-1 border-300 rounded-2">
                                                <table class="table table-striped table-bordered table-sm mt-3 fs--1" id="dtCostoOrden">
                                                    <thead>
                                                        <tr class="text-light text-center" style="background-color: purple;">
                                                            <th width="120px">N° DE ORDEN</th>
                                                            <th>PRODUCTO</th>
                                                            <th width="120px">FECHA INICIO</th>
                                                            <th width="120px">FECHA FINAL</th>
                                                            <th width="120px">DETALLE</th>
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
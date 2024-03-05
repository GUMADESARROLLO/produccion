@extends('layouts.main')
@section('metodosjs')
@include('jsViews.js_proceso_conversion')
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
        margin-inline: 5px;
    }
    .icon-btn {
        padding: 10px 12px 1px 20px;
        border-radius:10px;
    }
</style>
@endsection
@section('content')
<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <!-- [ Tabla Categorias ] start -->
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header border-secondary">
                                        <h5><b>PROCESO DE CONVERSION</b></h5>
                                        <a href="#" id='btnAdd'><i class="float-right fa fa-plus-circle" style="font-size:20px; color:purple"></i></a>
                                    </div>
                                    <div class="form-row mr-3 ml-3 mt-3">
                                        
                                    <div class="form-group col-md-7">
                                            <div class="input-group" style="width: 100%;" id="cont_search">
                                                <input type="text" id="InputBuscar" class="form-control bg-white" placeholder="Buscar..." aria-label="Username" aria-describedby="basic-addon1">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <div class="input-group ">                                            
                                                <input type="date" class="form-control" id="id_fecha_desde">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <div class="input-group ">                                            
                                                <input type="date" class="form-control" id="id_fecha_hasta">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group col-md-1 mt-2" > 
                                            <a class="icon-btn bg-transparent" href="#" id="id_search">                                                
                                                <i class="material-icons text-black">search</i>
                                            </a>
                                            
                                        </div>
                                            
                                        

                                    </div>
                                    
                                    <div class="card-body col-sm-12 p-0 mb-2">	
                                        <div class="p-0 px-car">
                                            <div class="flex-between-center scrollbar border border-1 border-300 rounded-2">
                                                <table class="table table-striped table-bordered table-sm mt-3 fs--1" id="tblConversion">
                                                    <thead>
                                                        <tr class="text-light text-center" style="background-color: purple;">
                                                            <th>INDEX</th>
                                                            <th width="80px">N° ORDEN</th>
                                                            <th>PRODUCTO</th>
                                                            <th>FECHA INICIAL</th>
                                                            <th>FECHA FINAL</th>
                                                            <th width="90px">HORAS TRABAJADAS</th>
                                                            <th>PESO %</th>
                                                            <th width="100px">TOTAL DE BULTOS (UNDS)</th>
                                                            <th width="80px">ACCIONES</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="modal fade modal-fullscreen" id="mdlAddOrden" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Información de la Orden de Producción</h5> <span id="id_row"></span>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <p class="text-muted m-2">Orden de Producción No. </p>
                                                        <input type="text" class="form-control" id="num_orden" placeholder="C-0000-00">
                                                        <small class="">Digite el número de orden</small>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <p class="text-muted">Producto</p>
                                                        <select class="form-control" id="id_select_producto">
                                                            <option value="0">...</option>
                                                            <option value="13">PAPEL HIGIENICO ECOPLUS</option>
                                                            <option value="35">PAPEL HIGIENICO GENERICO</option>
                                                            <option value="50">PAPEL HIGIENICO VUENO</option>
                                                        </select>
                                                        <small class="">Seleccione el tipo de producto</small>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <p class="text-muted m-2">Fecha Inicial</p>
                                                        <input type="date" class="input-fecha form-control" id="fecha_inicial" >
                                                        <small class="">Indique la fecha en que inicia</small>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <p class="text-muted m-2">Hora Inicial</p>
                                                        <input type="time" class="form-control" id="hora_inicial">
                                                        <small class="">Indique la hora en que inicia</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a class="btn icon-btn btn-primary" href="#" id="btnSave">                                                
                                                    <i class="material-icons text-white">save</i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
    @endsection
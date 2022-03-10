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
        /*border:1px solid #979797;*/
        /* background: linear-gradient(to bottom, white 0%, #0F85FC 100%);*/
        margin-inline: 5px;
    }
</style>
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
                                    <h5 class="m-b-10">Proceso de Conversión</h5>
                                </div>
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
                                        <h5>Lista de ordenes</h5>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="input-group" style="width: 100%;" id="cont_search">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="material-icons text-black ml-1">search</i>
                                            </span>
                                            <input type="text" id="InputBuscar" class="form-control bg-white" placeholder="Buscar..." aria-label="Username" aria-describedby="basic-addon1">
                                            <div class="input-group-prepend" id="btnAdd">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="material-icons icon-blue ml-1">add</i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="tblConversion" width="99%">

                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- [ modal proceso conversión] end -->

                                <div class="modal fade modal-fullscreen" id="mdlAddOrden" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Nueva orden de produccion</h5> <span id="id_row"></span>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <p class="text-muted m-2">Orden de Producción No. </p>
                                                        <input type="text" class="form-control" id="num_orden">
                                                        <small class="">Digite el número de orden</small>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <p class="text-muted">Producto</p>
                                                        <select class="form-control" id="id_select_producto">
                                                            <option value="0">...</option>
                                                            <option value="13">ROLLO JUMBO ECOPLUS (KG)</option>
                                                            <option value="35">ROLLO JUMBO GENERICO (KG)</option>
                                                        </select>
                                                        <small class="">Seleccione el tipo de producto</small>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <p class="text-muted m-2">Fecha Inicial</p>
                                                        <input type="text" class="input-fecha form-control" id="fecha_inicial">
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
                                                <button type="button" class="btn btn-info" id="btnSave">
                                                    <i class="material-icons text-white ml-2">save</i>
                                                </button>
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
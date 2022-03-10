@extends('layouts.main')
@section('metodosjs')
<link rel="stylesheet" type="text/css" href="{{ asset('css/detailStyle.css') }}">
@include('jsViews.js_doc')
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
                                ORDEN PRODUCCION No. <h5 class="m-b-10" id="id_num_orden">{{$Orden}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] start -->
                <div class="main-body mt-3">
                    <div class="page-wrapper">
                    <div class="row g-gs ">
                        <div class="col-lg-3">
                            <div class="row g-gs">
                                <div class="col-md-6 col-lg-12">
                                    <div class="card card-bordered ">
                                        <div class="card-inner ">
                                            <div class="card-title-group align-start mb-0">
                                                <div class="card-title">
                                                    <h6 class="title">PESO %</h6>
                                                </div>
                                            </div>
                                            <div class="card-amount">
                                                <span class="amount"> <span class="currency" id="id_peso_porcent"> 0 </span>
                                            </span>
                                            </div>
                                            <div class="amount-sm">- <small>-</small></div>
                                            <div class="card-stats">
                                                <div class="card-stats-group g-2">
                                                    <div class="card-stats-data">
                                                        <div class="title">FECHA INICIAL</div>
                                                        <div class="amount" id="id_fecha_inicial"> 0</div>
                                                    </div>
                                                    <div class="card-stats-data">
                                                        <div class="title">HORA INICIAL</div>
                                                        <div class="amount" id="id_hora_inicial">0</div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="row g-gs">
                                <div class="col-md-6 col-lg-12">
                                    <div class="card card-bordered ">
                                        <div class="card-inner ">
                                            <div class="card-title-group align-start mb-0">
                                                <div class="card-title">
                                                    <h6 class="title">JR TOTAL (KG)</h6>
                                                </div>
                                            </div>
                                            <div class="card-amount">
                                                <span class="amount"> <span class="currency" id="id_jr_total"> 0.00 </span></span>
                                            </div>
                                            <div class="amount-sm">- <small>-</small></div>
                                            <div class="card-stats">
                                                <div class="card-stats-group g-2">
                                                    <div class="card-stats-data">
                                                        <div class="title">FECHA FINAL</div>
                                                        <div class="amount" id="id_fecha_final"> 0</div>
                                                    </div>
                                                    <div class="card-stats-data">
                                                        <div class="title">HORA FINAL</div>
                                                        <div class="amount" id="id_hora_final"> 0</div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="row g-gs">
                                <div class="col-md-6 col-lg-12">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="card-title-group align-start mb-0">
                                                <div class="card-title">
                                                    <h6 class="title">HORAS TRABAJADAS</h6>
                                                </div>
                                            </div>

                                            <div class="card-amount">
                                                <!--<span class="amount">-->
                                                <span class="amount" style="color: red" id="id_hrs_trabajadas"> 0.00 </span>
                                                <div class="amount-sm">- <small>-</small></div>
                                            <!--</span>-->
                                            </div>
                                            <div class="card-stats">
                                                <div class="card-stats-group g-2">
                                                    <div class="card-stats-data">
                                                        <div class="title"></div>
                                                        <div class="amount"> </div>
                                                    </div>
                                                    <div class="card-stats-data">
                                                        <div class="title"></div>
                                                        <div class="amount"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="row g-gs">
                                <div class="col-md-6 col-lg-12">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="card-title-group align-start mb-0">
                                                <div class="card-title">
                                                    <h6 class="title">TOTAL DE BULTOS (UNDS)</h6>
                                                </div>
                                            </div>
                                            <div class="card-amount">
                                                <span class="amount"> <span class="currency" id="id_total_bultos_und">0.00</span>
                                                </span>
                                                <div class="amount-sm"> <small></small></div>
                                            </div>
                                            <div class="card-stats">
                                                <div class="card-stats-group g-2">
                                                    <div class="card-stats-data">
                                                        <div class="title">  </div>
                                                        <div class="amount-sm">- <small>-</small></div>
                                                    </div>
                                                    <div class="card-stats-data">
                                                        <div class="title"></div>
                                                        <!--<div class="amount">-->
                                                        <div class="amount" style="color: red"></div>
                                                    <!--</div>-->
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
                        <div class="row">
                            <!-- [ Tabla Categorias ] start -->
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="input-group" style="width: 100%;" id="cont_search">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="material-icons text-black ml-1">search</i>
                                            </span>
                                            <input type="text" id="tbl_search_producto" class="form-control bg-white" placeholder="Buscar..." aria-label="Username" aria-describedby="basic-addon1">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="tblProductos" width="99%">

                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h5>MATERIA PRIMA</h5>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="input-group" style="width: 100%;" id="cont_search">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="material-icons text-black ml-1">search</i>
                                            </span>
                                            <input type="text" id="tbl_search_materia_prima" class="form-control bg-white" placeholder="Buscar..." aria-label="Username" aria-describedby="basic-addon1">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="tblMateriaPrima" width="99%">

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
                                                        <input type="text" class="form-control" id="num_orden" placeholder="C-0000-00">
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
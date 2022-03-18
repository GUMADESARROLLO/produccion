@extends('layouts.main')
@section('metodosjs')
<link rel="stylesheet" type="text/css" href="{{ asset('css/detailStyle.css') }}">
@include('jsViews.js_doc')
@include('jsViews.js_doc_mp')
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

    .custom {
        min-width: 70%;
        min-height: 100%;
    }
    .color-focus{
        color: #0894ff !important;
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
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                ORDEN PRODUCCION No.<h3 class="nk-block-title page-title" id="id_num_orden">{{$Orden}}</h3>
                                <div class="nk-block-des text-soft">
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{url('/conversion')}}">Ordenes Conversion</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Detalle</a></li>
                                    </ul>
                                </div>

                            </div>
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title text-right" id="id_nombre_articulos"> - </h3>
                                <div class="nk-block-des text-right text-soft ">
                                    <span id="id_fecha_inicial"> 0</span> - <span id="id_hora_inicial">0</span> al
                                    <a href="#"  class="text-soft" id='fecha_hora_final'><span id="id_fecha_final"> 0</span> - <span id="id_hora_final">0</span></a> 
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- [ breadcrumb ] start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row g-gs ">
                            <div class="col-lg-3 dBorder">
                                <div class="row g-gs ">
                                    <div class="col-md-12 col-lg-12 ">
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
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="col-lg-3">
                                <div class="row g-gs">
                                    <div class="col-md-12 col-lg-12">
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
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="col-lg-3">
                                <div class="row g-gs">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <div class="card-title-group align-start mb-0">
                                                    <div class="card-title">
                                                        <h6 class="title">HORAS TRABAJADAS</h6>
                                                    </div>
                                                </div>

                                                <div class="card-amount">
                                                    <span class="amount" style="color: red" id="id_hrs_trabajadas"> 0.00 </span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="col-lg-3">
                                <div class="row g-gs">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="card card-bordered">
                                            <div class="card-inner">
                                                <div class="card-title-group align-start mb-0">
                                                    <div class="card-title">
                                                        <h6 class="title">TOTAL DE BULTOS (UNDS)</h6>
                                                    </div>
                                                </div>
                                                <div class="card-amount">
                                                    <span class="amount"> <span class="currency" id="id_total_bultos_und">0.00</span>

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
                                <div class="card" >
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
                                    <div class="form-group col-md-12 mb-3">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="tblProductos" width="100%"></table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card" >
                                    <div class="card-header" >
                                        <h5>MATERIA PRIMA DIRECTA (M.P)</h5>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="input-group" style="width: 100%;" id="cont_search">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="material-icons text-black ml-1">search</i>
                                            </span>
                                            <input type="text" id="tbl_search_materia_prima" class="form-control bg-white" placeholder="Buscar..." aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 mb-3">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="tblMateriaPrima" width="100%"></table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header ">
                                        <h5>TIEMPOS PAROS</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id='id_btn_add_hrs_paro'>+</button>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="input-group" style="width: 100%;" id="cont_search">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="material-icons text-black ml-1">search</i>
                                            </span>
                                            <input type="text" id="tbl_search_materia_prima" class="form-control bg-white" placeholder="Buscar..." aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 mb-3">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="tblTiemposParos" width="100%"></table>
                                        </div>
                                    </div>
                                </div>

                                <!-- [ modal proceso conversión] end -->

                                <div class="modal fade modal-fullscreen" id="mdlHorasParo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="id_articulo_descripcion"> INGRESO DE TIEMPOS PARO </h5> <span id=""> </span>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                            <table class="table table-hover" id="tbl_modal_TiemposParos" width="100%"></table>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="modal fade" id="mdlMatPrima" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog custom">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="id_descripcion"></h5> <span id="id_articulo"></span>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6" hidden>
                                                        <input type="text" class="form-control" id="num_orden" value="{{$Orden}}">
                                                        <input class="form-control" id="id_elemento">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <p class="text-muted m-2">LP Inicial </p>
                                                        <input type="text" class="form-control" id="lp_inicial" onkeypress="soloNumeros(event.keyCode, event, $(this).val())">
                                                        <small class="">Indique la cantidad</small>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <p class="text-muted m-2">LP Final </p>
                                                        <input type="text" class="form-control" id="lp_final" onkeypress="soloNumeros(event.keyCode, event, $(this).val())">
                                                        <small class="">Indique la cantidad</small>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <p class="text-muted m-2">Merma </p>
                                                        <input type="text" class="form-control" id="merma" onkeypress="soloNumeros(event.keyCode, event, $(this).val())">
                                                        <small class="">Indique la cantidad</small>
                                                    </div>
                                                </div>
                                                <div class="container-fluid m-0 p-0">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-11">
                                                            <h5 class="text-center">Lista de requisas</h5>
                                                        </div>
                                                        <div class="form-group col-md-1">
                                                            <div class="container justify-content-end d-flex m-0 p-0">
                                                                <button class="btn btn-primary" id="btnAddReq"><i class="fas fa-plus ml-2"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <table class="table table-bordered" id="tbRequisas" width="100%">
                                                    </table>
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
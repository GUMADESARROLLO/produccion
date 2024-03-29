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

    .custom {
        min-width: 70%;
        min-height: 100%;
    }

    .custom_detail {
        min-width: 80%;
        min-height: 100%;
    }

    u.dotted {
        border-bottom: 1px dashed #999;
        text-decoration: none;
    }

    .dBorder {
        border: 1px solid #ccc !important;
    }

    .text-primary {
        color: #4e73df !important;
    }

    .text-success {
        color: #1cc88a !important;
    }

    .text-info {
        color: #36b9cc !important;
    }

    .text-warning {
        color: #f6c23e !important;
    }

    .border-left-primary {
        border-left: .25rem solid #4e73df !important;
    }

    .border-left-success {
        border-left: .25rem solid #1cc88a !important;
    }

    .border-left-info {
        border-left: .25rem solid #36b9cc !important;
    }

    .border-left-warning {
        border-left: .25rem solid #f6c23e !important;
    }

    .color-focus {
        color: #0894ff !important;
    }

    .nav-tabs>.nav-item {
        padding-left: 3.25rem;
    }

    @media (min-width: 768px) {
        .nav-tabs .nav-item {
            padding-left: 1.5rem;
        }
    }

    @media (min-width: 992px) {
        .nav-tabs .nav-item {
            padding-left: 1.75rem;
        }
    }

    @media (min-width: 1200px) {
        .nav-tabs .nav-item {
            padding-left: 2.25rem;
        }
    }

    .swal2-shown {
        padding-right: 0px !important;
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
                            <div class="nk-block-head-content ">
                                ORDEN PRODUCCION No.<a href="../doc_printer/{{$Orden}}"><i class="material-icons text-danger">picture_as_pdf</i></a>
                                <h3 class="nk-block-title page-title" id="id_num_orden">{{$Orden}}</h3>
                                <div class="nk-block-des text-soft">
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{url('/conversion')}}">Ordenes Conversion</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:" id="id_temp">Ver Detalles</a></li>
                                    </ul>
                                </div>

                            </div>
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title text-right" id="id_nombre_articulos"> </h3>
                                <div class="nk-block-des text-right text-soft ">
                                    <u class="dotted">
                                        <a href="#" class="text-soft" id='fecha_hora_inicial'> <span id="id_fecha_inicial"> 0</span> <span id="id_hora_inicial">0</span></a>
                                    </u>al
                                    <u class="dotted">
                                        <a href="#" class="text-soft" id='fecha_hora_final'><span id="id_fecha_final"> 0</span> <span id="id_hora_final">0</span></a>
                                    </u>
                                </div>
                                <div class="nk-block-des text-right text-soft ">
                                    <span id=""> Hrs Trabajadas</span> : <span id="id_hrs_total_trabajadas">00:00:00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- [ breadcrumb ] start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row g-gs ">
                            <div class="col-lg-3">
                                <div class="row g-gs ">
                                    <div class="col-md-12 col-lg-12 ">
                                        <div class="card card-bordered border-left-primary">

                                            <div class="card-inner">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="card-title-group align-start mb-0">
                                                            <div class="card-title">
                                                                <h6 class="text-xs  text-primary text-uppercase mb-1">PESO %</h6>
                                                            </div>
                                                        </div>

                                                        <div class="card-amount">
                                                            <span class="amount" id=""><span class="currency" id="id_peso_porcent">0.00</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-info-circle  fa-2x text-gray-300" id="id_icon_info"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="col-lg-3">
                                <div class="row g-gs">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="card card-bordered border-left-success">
                                            <div class="card-inner">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="card-title-group align-start mb-0">
                                                            <div class="card-title">
                                                                <h6 class="text-xs font-weight-bold text-success text-uppercase mb-1">JR TOTAL (KG)</h6>
                                                            </div>
                                                        </div>
                                                        <div class="card-amount">
                                                            <span class="amount" id=""><span class="currency" id="id_jr_total">0.00</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-info-circle fa-2x text-gray-300" id="id_icon_info_2"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="col-lg-3">
                                <div class="row g-gs">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="card card-bordered border-left-info">
                                            <div class="card-inner">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="card-title-group align-start mb-0">
                                                            <div class="card-title">
                                                                <h6 class="text-xs font-weight-bold text-info text-uppercase mb-1"> HORAS TRABAJADAS</h6>
                                                            </div>
                                                        </div>
                                                        <div class="card-amount">
                                                            <span class="amount" style="color: red" id="id_hrs_trabajadas"> 0.00 </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-calendar fa-2x text-gray-300" id="icon_fecha_final"></i>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="col-lg-3">
                                <div class="row g-gs">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="card card-bordered border-left-warning">
                                            <div class="card-inner">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="card-title-group align-start mb-0">
                                                            <div class="card-title">
                                                                <h6 class="text-xs font-weight-bold text-warning text-uppercase mb-1">TOTAL DE BULTOS (UNDS)</h6>
                                                            </div>
                                                        </div>
                                                        <div class="card-amount">
                                                            <span class="amount"><span class="currency" id="id_total_bultos_und">0.00</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-flag fa-2x text-gray-300"></i>
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
                                        <h5>PRODUCCION</h5>
                                    </div>
                                    <div class="form-group col-md-12" style="display:none">
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

                                <div class="card">
                                    <div class="card-header">
                                        <h5>MATERIA PRIMA DIRECTA (M.P)</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id='btnInfo'>
                                            <i class="material-icons text-black">info</i>
                                        </button>
                                    </div>
                                    <div class="form-group col-md-12" style="display:none">
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

                                <div class="row g-gs">
                                    <div class="col-lg-7">
                                        <div class="row g-gs ">
                                            <div class="col-md-12 col-lg-12 ">
                                                <div class="card">
                                                    <div class="card-header ">
                                                        <h5>TIEMPOS PAROS</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id='id_btn_add_hrs_paro'>
                                                            <i class="material-icons text-blue">add_circle</i>
                                                        </button>
                                                    </div>
                                                    <div class="form-group col-md-12" style="display:none">
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

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="row g-gs ">
                                            <div class="col-md-12 col-lg-12 ">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>COMENTARIOS</h5>
                                                        <button type="submit" class="close" data-dismiss="modal" aria-label="Close" id='btn_guardar_comment'>
                                                            <i class="material-icons text-info">save</i>
                                                        </button>
                                                    </div>
                                                    <div class="card-block pt-2">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <textarea class="form-control" placeholder="Ingrese su comentario" name="comentario" id="comentario" rows="4"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="modal fade " id="mdlDetallesOrdes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog custom">
                                        <div class="modal-content ">
                                            <div class="modal-header bg-primary text-white">
                                                <div class="container ">
                                                    <h5 class="modal-title d-flex justify-content-center" id="">Proceso de Conversión - Detalles de la Orden</h5>
                                                    <h5 class="modal-title d-flex justify-content-center" id="periodo"> </h5>
                                                </div>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <!-- Tabs de la orden de produccion -->
                                            <div class="modal-body">
                                                <nav>
                                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                        <a class="nav-item nav-link active" id="navMP" data-toggle="tab" href="#nav-mp" role="tab" aria-controls="nav-mp" aria-selected="true">MATERIA PRIMA</a>
                                                        <a class="nav-item nav-link" id="navSbrEmpq" data-toggle="tab" href="#nav-se" role="tab" aria-controls="nav-se" aria-selected="false">SOBRE EMPAQUE</a>
                                                        <a class="nav-item nav-link" id="navEP" data-toggle="tab" href="#nav-ep" role="tab" aria-controls="nav-ep" aria-selected="false">EMPAQUE PRIMARIO</a>
                                                        <a class="nav-item nav-link" id="navQuimicos" data-toggle="tab" href="#nav-quimicos" role="tab" aria-controls="nav-quimicos" aria-selected="false">QUIMICOS</a>
                                                    </div>
                                                </nav>
                                                <div class="tab-content  pt-1 overflow-auto" id="nav-tabContent">
                                                    <div class="tab-pane fade show active" id="nav-mp" role="tabpanel" aria-labelledby="navMP">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <table id="tblMP" class="table table-hover table-bordered mt-3 border-top-0 border-bottom-0 border-right-0">
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="nav-se" role="tabpanel" aria-labelledby="navSbrEmpq">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <table id="tblSbrEmpq" class="table table-hover table-bordered mt-3">
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="nav-ep" role="tabpanel" aria-labelledby="navEP">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <table id="tblEP" class="table table-hover table-bordered mt-3">
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane fade" id="nav-quimicos" role="tabpanel" aria-labelledby="navQuimicos">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <table id="tblQuimicos" class="table table-hover table-bordered mt-3">
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- [ modal proceso conversión] end -->

                                <div class="modal fade" id="mdlHorasParo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog custom">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="id_articulo_descripcion"> INGRESO DE TIEMPOS PARO </h5> <span id=""> </span>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body overflow-auto">
                                                <table class="table table-hover" id="tbl_modal_TiemposParos" width="100%"></table>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="modal fade " id="mdlMatPrima" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                    <table class="table table-hover" id="tbRequisas" width="100%">
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
        <!-- [ Main Content ] end -->

        @endsection
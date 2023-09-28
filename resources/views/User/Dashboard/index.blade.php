@extends('layouts.main')
@section('metodosjs')
<link rel="stylesheet" type="text/css" href="{{ asset('css/detailStyle.css') }}">
@include('jsViews.js_dashboard')
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
        font-size: 1.3em;
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
    .nav-tabs > .nav-item {
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
    .DateRange {
        border: 2px solid #f6c23e !important;
    }
    .sizebadge{
        font-size: 1.2em;
    }
</style>
@endsection
@section('content')
<!-- [ Main Content ] start -->
<div class="pcoded-main-container" style="background-color:white;">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content mt-1 ">
                                RESUMEN DE PRODUCCION<a href=""></a>
                                <h3 class="nk-block-title page-title " id="id_name_month">TITULO</h3>
                            </div>
                            
                            <div class="nk-block-head-content ">
                                <h3 class="nk-block-title page-title text-right" id="id_nombre_articulos"> </h3>

                                <div class="form-row ">
                                    <div class="form-group col-md-5 ml-5">
                                        <div class="input-group ">   
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="material-icons text-black">event</i></div>
                                            </div>                            
                                            <input type="text" class="input-fecha form-control" id="fecha_hora_inicial">
                                        </div>
                                    </div>

                                    <div class="form-group col-md-5">
                                        <div class="input-group "> 
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="material-icons text-black">event</i></div>
                                            </div>                                            
                                            <input type="text" class="input-fecha form-control" id="fecha_hora_final">                                            
                                        </div>
                                    </div>
                                    
                                    <div class="form-group col-md-1 " > 
                                        <div class="input-group-prepend" id="id_search">
                                            <div class="input-group-text "><i class="material-icons text-black">search</i></div>
                                        </div> 
                                    </div>
                                </div>                                
                                
                                <div class="nk-block-des text-right text-soft mt-1">                                    
                                    <span id="R1" class="badge sizebadge badge-pill badge-light DateRange" onClick="getRange('R1')">1 m </span>
                                    <span id="R3" class="badge sizebadge badge-pill badge-light" onClick="getRange('R3')">3 m </span>
                                    <span id="R6" class="badge sizebadge badge-pill badge-light" onClick="getRange('R6')">6 m </span>
                                    <span id="R12" class="badge sizebadge badge-pill badge-light" onClick="getRange('R12')">1 y </span>
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
                                        <div class="card card-bordered border-left-success">

                                            <div class="card-inner shadow-lg">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="card-title-group align-start mb-0">
                                                            <div class="card-title">
                                                                <h6 class="text-xs  text-success text-uppercase mb-1">HORAS TRABAJADAS</h6>
                                                            </div>
                                                        </div>

                                                        <div class="card-stats">
                                                            <div class="card-stats-group g-2">
                                                                <div class="card-stats-data">
                                                                    <div class="title">PROCESO HUMEDO</div>
                                                                    <div class="amount" id="id_card_hrs_trab_humedo"> 0.00</div>
                                                                </div>
                                                                <div class="card-stats-data">
                                                                    <div class="title">CONVERSION</div>
                                                                    <div class="amount" id="id_card_hrs_trab_conversion">0.00</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-info-circle  fa-2x text-secondary" id="id_icon_info"></i>
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
                                        <div class="card card-bordered border-left-primary">
                                            <div class="card-inner shadow-lg">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="card-title-group align-start mb-0">
                                                            <div class="card-title">
                                                                <h6 class="text-xs font-weight-bold text-primary text-uppercase mb-1">COSTOS TOTALES</h6>
                                                            </div>
                                                        </div>                                                       
                                                        <div class="card-stats">
                                                            <div class="card-stats-group g-2">
                                                                <div class="card-stats-data">
                                                                    <div class="title">TOTAL C$</div>
                                                                    <div class="amount" id="id_card_total_cordoba"> 0.00</div>
                                                                </div>
                                                                <div class="card-stats-data">
                                                                    <div class="title">TOTAL $</div>
                                                                    <div class="amount" id="id_card_total_dolares">0.00</div>
                                                                </div>
                                                                <div class="card-stats-data">
                                                                    <div class="title">TOTAL TON. $</div>
                                                                    <div class="amount" id="id_card_total_tonelada_dolares">0.00</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-info-circle fa-2x text-secondary" id="id_icon_info_2"></i>
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
                                            <div class="card-inner shadow-lg">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="card-title-group align-start">
                                                            <div class="card-title">
                                                                <h6 class="text-xs font-weight-bold text-info text-uppercase mb-1"> PROCESO HUMEDO</h6>
                                                            </div>
                                                        </div>
                                                        <div class="card-stats">
                                                            <div class="card-stats-group g-2">
                                                                <div class="card-stats-data">
                                                                    <div class="title">PRODUCCION REAL</div>
                                                                    <div class="amount" id="id_card_pro_real"> 0.00</div>
                                                                </div>
                                                                <div class="card-stats-data">
                                                                    <div class="title">PRODUCCION TOTAL</div>
                                                                    <div class="amount" id="id_card_pro_total">0.00</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-calendar fa-2x text-secondary" id="icon_fecha_final"></i>

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
                                            <div class="card-inner shadow-lg">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="card-title-group align-start mb-0">
                                                            <div class="card-title">
                                                                <h6 class="text-xs font-weight-bold text-warning text-uppercase mb-1">CONVERSION</h6>
                                                            </div>
                                                        </div>
                                                        <div class="card-stats">
                                                            <div class="card-stats-group g-2">
                                                                <div class="card-stats-data">
                                                                    <div class="title">JR TOTAL (KG)</div>
                                                                    <div class="amount" id="id_card_jr_total_kg"> 0.00</div>
                                                                </div>
                                                                <div class="card-stats-data">
                                                                    <div class="title">TOTAL DE BULTOS (UNDS)</div>
                                                                    <div class="amount" id="id_card_total_bultos_unds">0.00</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-flag fa-2x text-secondary"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row g-gs shadow-lg">
                            <div class="col-lg-12">
                                <div class="row g-gs ">
                                    <div class="col-md-12 col-lg-12 ">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5><b>ORDENES PROCESO HUMEDO</b></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id='id_btn_add_hrs_paro'>
                                                    <div class="input-group "> 
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text bg-gray"><i class="material-icons text-black">search</i></div>
                                                        </div>                                            
                                                        <input type="text" id="tbl_search_humedo" class="form-control bg-gray" >
                                                    </div>
                                                </button>
                                                
                                            </div>
                                            
                                            <div class="form-group col-md-12 mb-3 shadow-lg">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-secondary" id="tblProcesoHumedo" width="99%">
                                                        <thead>
                                                            <tr class="text-light text-center" style="background-color: purple;">
                                                                <th ></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th ></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 shadow-lg">
                                <div class="row g-gs ">
                                    <div class="col-md-12 col-lg-12 ">
                                        <div class="card">
                                            <div class="card-header  ">
                                                <h5><b>ORDENES CONVERSION</b></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id='id_btn_add_hrs_paro'>
                                                    <div class="input-group"> 
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text bg-gray"><i class="material-icons text-black">search</i></div>
                                                        </div>                                            
                                                        <input type="text" id="tbl_search_conversion" class="form-control bg-gray"  aria-label="Username" aria-describedby="basic-addon1">
                                                    </div>
                                                </button>
                                            </div>                                            
                                            <div class="form-group col-md-12 mb-3 shadow-lg">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-secondary" id="tblConversion" width="99%">
                                                    <thead>
                                                            <tr class="text-light text-center" style="background-color: purple;">
                                                                <th ></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                
                                                            </tr>
                                                        </thead>
                                                    </table>
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
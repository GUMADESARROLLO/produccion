@extends('layouts.main')
@section('metodosjs')
@include('jsViews.js_index_requisas')
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
                <!-- [ breadcrumb ] start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header border-secondary">
                                        <h5><b>REQUISAS</b></h5>
                                        <!--<a href="{{url('requisas/nuevo')}}"><i class="float-right fa fa-plus-circle" style="font-size:20px; color:purple"></i></a>-->
                                    </div>
                                    <div class="input-group mt-4 ml-2" style="width: 98%;" id="cont_search">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                                        </div>
                                        <input type="text" id="InputBuscar" class="form-control bg-white" placeholder="Buscar..." aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="tblRequisas">
                                                <thead>
                                                    <tr class="text-light text-center" style="background-color: purple;">
                                                        <th>#</th>
                                                        <th>N° ORDEN</th>
                                                        <th>CODIGO</th>
                                                        <th>TIPO</th>
                                                        <th>TURNO</th>
                                                        <th>FECHA CREACION</th>
                                                        <th>ACCIONES</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-dark">


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Tabla ] end -->
                        </div>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->
@endsection
@extends('layouts.main')
@section('metodosjs')
@include('jsViews.js_home')
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
                        <div class="row">

                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>RESUMEN DE ORDENES DE PRODUCCIÓN</h5>
                                    </div>
                                    <div class="input-group mt-4 ml-2" style="width: 98%;" id="cont_search">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                                        </div>
                                        <input type="text" id="InputBuscar" class="form-control bg-white" placeholder="Buscar..." aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive" >
                                            <table class="table table-hover" id="tblHome">
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Tabla Categorias ] end -->
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
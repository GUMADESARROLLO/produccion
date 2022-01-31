@extends('layouts.main')
@section('metodosjs')
  @include('jsViews.js_crearturno')
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
                            <div class="col-md-12">
                                <div class="page-header-title">
                                    <h5 class="m-b-10">Configuraciones</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:">Configuración</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <!-- [ start configuraciones ] start -->
                            <div class="col-xl-12 col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Configuraciones</h5>
                                    </div>
                                    <div class="card-block border-bottom text-center font-weight-bold">
                                        <div class="row align-items-center">

                                            <div class="col-sm-2">
                                            <a href="{{url('/turno')}}" class="text-dark">
                                                <i class="far fa-clock text-c-blue f-60"></i>
                                                <span class="d-block text-uppercase mt-4 text-c-danger">Turnos</span>
                                            </a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ start configuraciones ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->



















@endsection

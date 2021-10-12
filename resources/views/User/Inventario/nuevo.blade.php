@extends('layouts.main')
@section('metodosjs')
  @include('jsViews.js_nuevoinventario')
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
                                    <h5 class="m-b-10">Nuevo Inventario</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:">Nuevo Inventario</a></li>
                                </ul>
                            </div>
                            <div class="col-md-2">
                                <a href="#!" class="btn btn-primary btn-sm  float-right" id="btnactualizar">Actualizar</a>
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
                                        <h5>Agrege las cantidades</h5>
                                    </div>  
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="dtInventario">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>CODIGO</th>
                                                        <th>DESCRIPCIÓN</th>
                                                        <th>UND. MEDIDA</th>
                                                        <th>TOTAL FISICO</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($insumos as $ins)
                                                    <tr class="unread">
                                                        <td class="dt-center">{{ strtoupper($ins['codigo']) }}</td>
                                                        <td class="dt-left">{{ strtoupper($ins['descripcion']) }}</td>
                                                        <td class="dt-center" width="20%">
                                                            <select class="form-control">
                                                                <option selected>KG</option>
                                                            </select>
                                                        </td>
                                                        <td class="dt-center" width="20%">
                                                            <input type="number" class="form-control">
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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
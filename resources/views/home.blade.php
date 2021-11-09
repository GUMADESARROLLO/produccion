@extends('layouts.main')
@section('metodosjs')

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

                            <!-- [ Tiempo de Pulpeo ] start -->
                            <div class="col-xl-6 col-md-6">
                                <div class="card card-event">
                                    <div class="card-block border-bottom">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col">
                                                <h5 class="m-0">Tiempo de Pulpeo</h5>
                                            </div>
                                            <div class="col-auto">
                                                <label class="label theme-bg2 text-white f-14 f-w-400 float-right">45</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block table-border-style">
                                        <h6 class="text-uppercase text-center">No. de Bachadas en el pulper</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="dtFibras">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>FECHA</th>
                                                        <th>DIA</th>
                                                        <th>NOCHE</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="unread">
                                                        <td class="dt-center"></td>
                                                        <td class="dt-left"></td>
                                                        <td class="dt-center"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Tiempo de Pulpeo ] end -->

                            <!-- [ Tiempo de Lavado ] start -->
                            <div class="col-xl-6 col-md-6">
                                <div class="card card-event">
                                    <div class="card-block border-bottom">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col">
                                                <h5 class="m-0">Tiempo de Lavado</h5>
                                            </div>
                                            <div class="col-auto">
                                                <label class="label theme-bg2 text-white f-14 f-w-400 float-right">45</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block table-border-style">
                                        <h6 class="text-uppercase text-center">No. de Batch en el lavadora Tetrapack</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="dtFibras">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>FECHA</th>
                                                        <th>DIA</th>
                                                        <th>NOCHE</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="unread">
                                                        <td class="dt-center"></td>
                                                        <td class="dt-left"></td>
                                                        <td class="dt-center"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Tiempo de Lavado ] end -->

                        </div>
                        <div class="row">
                            <!-- [ Resumen de costo ] start -->
                            <div class="col-xl-12 col-md-12">
                                <div class="card card-event">
                                    <div class="card-block border-bottom">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col text-center">
                                                <h5 class="m-0">
                                                    <strong>
                                                        RESUMEN DE ORDENES
                                                    </strong>
                                                </h5>
                                            </div>
                                            <div class="col-auto">
                                                <label class="label theme-bg2 text-white f-14 f-w-400 float-right">1</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block table-border-style">
                                        <h6 class="text-uppercase text-center">No. de ordenes terminadas</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="dtFibras">
                                                <thead >
                                                    <tr class="text-center border border-success">  
                                                        <th>ORDEN</th>
                                                        <th>PRODUCTO</th>
                                                        <th>TOTAL PRODUCIDO</th>
                                                        <th>COSTO TOTAL</th>
                                                        <th>VER</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="unread">
                                                        <td class="dt-center">4448</td>
                                                        <td class="dt-center">Papel higienico generico</td>
                                                        <td class="dt-center"> 7,765.00</td>
                                                        <td class="dt-center">C$ 225,518.64</td>
                                                        <td class="dt-center">
                                                            <a href="orden-produccion/detalle/4448"><i class="feather icon-eye text-c-black f-30 m-r-10"></i></a>
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Tiempo de Pulpeo ] end -->
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
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
                            <!-- <div class="col-xl-6 col-md-6">
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
                            </div> -->
                            <!-- [ Tiempo de Pulpeo ] end -->

                            <!-- [ Tiempo de Lavado ] start -->
                            <!-- <div class="col-xl-6 col-md-6">
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
                            </div>-->
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>DETALLE DE ORDENES</h5>
                                    </div>
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>ID</th>
                                                        <th># Orden</th>
                                                        <th>Nombre</th>
                                                        <th>Total Producido</th>
                                                        <th>Costo total</th>
                                                        <th>Ver</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($detalle_orden as $key => $d)
                                                    <tr class="unread">
                                                        <td class="dt-center">{{ $key+1 }}</td>
                                                        <td class="dt-center">{{ $d->numOrden }}</td>
                                                        <td class="dt-center">{{ strtoupper($d->nombre) }}</td>
                                                        <td class="dt-center">{{ $d->prod_real }}</td>
                                                        <td class="dt-center">{{ $d->costo_total }}</td>
                                                        <td class="dt-center">
                                                            <a href="home/detalle/{{ $d->numOrden }}" target="_blank"><i class="feather icon-eye text-c  f-30 m-r-10"></i></a>
                                                            <a href="detalleOrdenPDF/{{$d->numOrden}}" target="_blank"><i class="far fa-file-pdf text-c-red f-30 m-r-10"></i></a>
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

                            <div class="row">
                                <div class="col-4">
                                    <table class="table table-sm table-bordered" style="border: 2px solid black; ">
                                        <tr>
                                            <th class="cell-color ">NO ORDEN PROD.</th>
                                            <td class="font-weight-bold">4082</td>
                                        </tr>
                                        <tr>
                                            <th class="cell-color">CODIGO</th>
                                            <td>M01</td>
                                        </tr>
                                        <tr>
                                            <th class="cell-color">NOMBRE DEL PRODUCTO</th>
                                            <td class="text-uppercase">PAPEL HIGIENICO GENERICO</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-6">
                                    <table class="table table-sm table-bordered problem-table" style="border: 2px solid black; width:450px !important">
                                        <tr class="cell-border">
                                            <th class="cell-border text-right" colspan="2">Razon MP vs Producto Terminado</th>
                                            <th class="cell-border text-right" style="background-color:#F4CCCC; color:red;">1.51</th>
                                        </tr>
                                        <tr>
                                            <th WIDTH="170px" class="cell-border cell-color text-center">PRODUCCIÓN</th>
                                            <th WIDTH="100px" class="cell-border cell-color text-center">TOTAL</th>
                                            <th WIDTH="100px" class="cell-border cell-color text-center">No.DE BOBINAS</th>
                                        </tr>
                                        <tbody>
                                            <tr>
                                                <td class="text-uppercase text-left">PAPEL HIGIENICO GENERICO</td>
                                                    <td class="text-right">12,843.00</td>
                                                    <td></td>
                                            </tr>
                                            <tr>
                                                <td class="cell-color text-right">TOTAL</td>
                                                <td class="text-right">12,843.00</td>
                                                <td class="text-right">100%</td>
                                            </tr>
                                            <tr>
                                                <td class="cell-color text-right">MERMA</td>
                                                <td class="text-right"> 12,843.00</td>
                                                <td class="text-right">16</td>
                                            </tr>
                                            <tr>
                                                <td class="cell-color text-right">TOTAL PRODUCIDO</td>
                                                <td class="text-right"> 12,843.00</td>
                                                <td class="text-right">100%</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
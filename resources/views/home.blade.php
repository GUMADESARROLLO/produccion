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

                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>RESUMEN DE ORDENES DE PRODUCCIÓN</h5>
                                    </div>
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th># Orden</th>
                                                        <th>Nombre</th>
                                                        <th>PROD.REAL KG</th>
                                                        <th>PROD.REAL TON.</th>
                                                        <th>COSTO TOTAL C$</th>
                                                        <th>T.C.</th>
                                                        <th>COSTO TOTAL $</th>
                                                        <th>COSTO TON. $</th>
                                                        <th>Ver</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($detalle_orden as $key => $d)
                                                    <tr class="unread">
                                                        <td class="dt-center">{{ $d->numOrden }}</td>
                                                        <td class="dt-center">{{ strtoupper($d->nombre) }}</td>
                                                        <td class="dt-center">{{ number_format($d->prod_real,2 )}}</td>
                                                        <td class="dt-center">{{ number_format(($d->prod_real/1000),2)}}</td>
                                                        <td class="dt-center">C$ {{ number_format($d->costo_total,2)}}</td>
                                                        <td class="dt-center">C$ {{ number_format($d->tipo_cambio,4)}}</td>
                                                        @if ($d->tipo_cambio == 0)
                                                            <td class="dt-center">$ {{ number_format(0,4)}}</td>
                                                            <td class="dt-center">$ {{ number_format(0,4)}}</td>
                                                        @else
                                                            <td class="dt-center">$ {{ number_format(($d->costo_total/$d->tipo_cambio),4)}}</td>
                                                            <td class="dt-center">$ {{ number_format((($d->costo_total/$d->tipo_cambio)/($d->prod_real/1000)),4) }}</td>
                                                        @endif

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

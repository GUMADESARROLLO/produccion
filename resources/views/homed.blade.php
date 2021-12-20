@extends('layouts.main')
@section('metodosjs')

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
                                    <h5 class="m-b-10">Resumen de la Orden de Producción</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:">Resumen de Costos</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <!-- [ Header orden produccion ] start -->
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-header">
                                            <h5>Orden de Produccion N°: {{ $detalle_orden->numOrden }} </h5>
                                            <h6>Codigo de Producto:   {{ $detalle_orden->codigo }} -  {{ $detalle_orden->nombre }}</h6>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                              <div class="form-group row">
                                                <label for="fechaInicio" class="col-sm-6 col-form-label">Fecha Inicio:</label>
                                                <div class="col-sm-6">
                                                  <input type="text" readonly class="form-control-plaintext" id="fechaInicio" value="{{ $detalle_orden->fechaInicio }}">
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-md-3">
                                              <div class="form-group row">
                                                <label for="fechaFinal" class="col-sm-6 col-form-label">Fecha Final:</label>
                                                <div class="col-sm-6">
                                                  <input type="text" readonly class="form-control-plaintext" id="fechaFinal" value="{{ $detalle_orden->fechaFinal }}">
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label for="merma-yankee-dry" class="col-sm-6 col-form-label">Merma Yankee Dry:</label>
                                                    <div class="col-sm-6">
                                                        <h6 class="mt-2">{{ number_format($detalle_orden->merma_total,2) }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 ">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-6 col-form-label">Horas Trabajadas</label>
                                                    <div class="col-sm-6">
                                                        <h6 class="mt-2 text-left">{{ $detalle_orden->hrsTrabajadas }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                              <div class="form-group row">
                                                <label for="produccionNeta" class="col-sm-6 col-form-label">Hora Inicio:</label>
                                                <div class="col-sm-6">
                                                  <input type="text" readonly class="form-control-plaintext" id="produccionNeta" value="{{ $detalle_orden->horaInicio }}">
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-md-3">
                                              <div class="form-group row">
                                                <label for="horaFinal" class="col-sm-6 col-form-label">Hora Final:</label>
                                                <div class="col-sm-6">
                                                  <input type="text" readonly class="form-control-plaintext" id="horaFinal" value="{{ $detalle_orden->horaFinal }}">
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label for="residuos-pulper" class="col-sm-6 col-form-label">Residuos del Pulper:</label>
                                                    <div class="col-sm-6">
                                                        <h6 class="mt-2">{{ number_format($detalle_orden->residuo_total,2) }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label for="factorFibral" class="col-sm-6 col-form-label">Factor fibral</label>
                                                    <div class="col-sm-6">
                                                        <h6 class="mt-2 text-left">{{ number_format($detalle_orden->factor_fibral,2)}} %</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                              <div class="form-group row">
                                                <label for="produccionNeta" class="col-sm-6 col-form-label">PROD. REAL (unds y kg):</label>
                                                <div class="col-sm-6">
                                                  <input type="text" readonly class="form-control-plaintext" id="produccionNeta" value="{{ number_format($detalle_orden->prod_real,2) }}">
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label for="lav-tetrapack" class="col-sm-6 col-form-label">Lavadora de Tetrapack:</label>
                                                    <div class="col-sm-6">
                                                        <h6 class="mt-2">{{ number_format($detalle_orden->lavadora_total,2) }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                            </div>
                                            <div class="col-md-3">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Header orden produccion ] end -->
                        </div>
                        <div class="row">
                            <!-- [ Consumo Electricidad ] start -->
                            <div class="col-xl-6 col-md-6">
                                <div class="card card-social">
                                    <div class="card-block border-bottom">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-auto">
                                                 <h4 class="mb-0">Consumo Elec. C$</h4>
                                            </div>
                                            <div class="col text-right">
                                                <h4>{{ number_format($detalle_orden->electricidad_total_cord,2)}} C$</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="card card-social">
                                    <div class="card-block border-bottom">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-auto">
                                                <h4 class="mb-0">Consumo Elec. kw/Hrs</h4>
                                            </div>
                                            <div class="col text-right">
                                                <h4>{{ number_format($detalle_orden->electricidad_total_unid,2)}} kw/Hrs</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Consumo Electricidad ] end -->

                            <!-- [ Consumo Agua ] start -->
                            <div class="col-xl-6 col-md-6">
                                <div class="card card-social">
                                    <div class="card-block border-bottom">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-auto">
                                                 <h4 class="mb-0">Consumo Agua m<sup>3</sup></h4>
                                            </div>
                                            <div class="col text-right">
                                                <h4>{{ number_format($detalle_orden->agua_total,2) }} m<sup>3</sup></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Consumo Agua ] end -->

                            <!-- [ Consumo Gas ] start -->
                            <div class="col-xl-6 col-md-6">
                                <div class="card card-social">
                                    <div class="card-block border-bottom">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-auto">
                                                <h4 class="mb-0">Consumo Gas Glns</h4>
                                            </div>
                                            <div class="col text-right">
                                                <h4>{{ number_format($detalle_orden->gas_total,2)}} Glns</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Consumo Gas ] end -->
                        </div>
                         <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>DETALLE DE COSTOS POR ORDEN</h5>
                                    </div>
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr class="text-center">

                                                        <th>Codigo</th>
                                                        <th>Nombre</th>
                                                        <th>Unidad de Medidad</th>
                                                        <th>Cantidad</th>
                                                        <th>Costo Unitario C$</th>
                                                        <th>Subtotal C$</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($detalle_costo_subtotal as $key => $dcs)
                                                    <tr class="unread">

                                                        <td class="dt-center">{{ $dcs->codigo }}</td>
                                                        <td class="dt-center">{{ $dcs->descripcion}}</td>
                                                        <td class="dt-center">{{ $dcs->unidad_medida }}</td>
                                                        <td class="dt-center">{{ number_format($dcs->cantidad,2)}}</td>
                                                        <td class="dt-center">{{ number_format($dcs->costo_unitario,2) }}</td>
                                                        <td class="dt-center">{{ number_format($dcs->subtotal,2) }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         </div>
                         <div class="row">
                            <div class="col-xl-6 col-md-6">

                            </div>
                            <div class="col-xl-6 col-md-6">
                                <div class="card card-social">
                                    <div class="card-block border-bottom">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-auto">
                                                 <h5 class="mb-0">Costo Total en C$</h5>
                                            </div>
                                            <div class="col text-right">
                                                <h3>{{ number_format($detalle_orden->costo_total,2) }} C$</h3>
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
</div>
<!-- [ Main Content ] end -->
@endsection

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
                                        <h5 class="m-b-10">Detalle de Orden de Producción</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>
                                        <li class="breadcrumb-item"><a href="{{url('/orden-produccion')}}">Ordenes
                                                Produccion</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Detalle</a></li>
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
                                            <div class="card-header d-flex justify-content-center align-items-center">
                                                <h5>Orden de Produccion N°: {{ $orden->numOrden }}
                                                    - {{ $orden->producto }}</h5>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group row">
                                                        <div class="col-sm-6">
                                                            <label for="fechaInicio">Fecha
                                                                Inicio:</label>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <input type="text" readonly class="form-control-plaintext" id="fechaInicio" value="{{ $orden->fechaInicio }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group row">
                                                        <label for="fechaFinal" class="col-sm-6 col-form-label">Fecha
                                                            Final:</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" readonly class="form-control-plaintext" id="fechaFinal" value="{{ $orden->fechaFinal }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group row">
                                                        <label for="merma-yankee-dry" class="col-sm-6 col-form-label">Merma
                                                            Yankee Dry (kg):</label>
                                                        <div class="col-sm-6">
                                                            <h6 class="mt-2">{{ number_format($orden->mermaYankeeDry,2) }} kg<span class="float-right">{{ $orden->porcentMermaYankeeDry }} %</span>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 ">
                                                    <div class="form-group row">
                                                        <label for="" class="col-sm-6 col-form-label">Horas
                                                            Trabajadas</label>
                                                        <div class="col-sm-6">
                                                            <h6 class="mt-2 text-left">{{ $orden->hrsTrabajadas }} hrs</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group row">
                                                        <label for="produccionNeta" class="col-sm-6 col-form-label">Hora
                                                            Inicio:</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" readonly class="form-control-plaintext" id="produccionNeta" value="{{ $orden->horaInicio }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group row">
                                                        <label for="horaFinal" class="col-sm-6 col-form-label">Hora
                                                            Final:</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" readonly class="form-control-plaintext" id="horaFinal" value="{{ $orden->horaFinal }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group row">
                                                        <label for="residuos-pulper" class="col-sm-6 col-form-label">Residuos
                                                            del Pulper (kg):</label>
                                                        <div class="col-sm-6">
                                                            <h6 class="mt-2">{{ number_format($orden->residuosPulper,2) }} kg <span class="float-right">{{ $orden->porcentResiduosPulper }} %</span>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group row">
                                                        <label for="factorFibral" class="col-sm-6 col-form-label">Factor
                                                            fibral</label>
                                                        <div class="col-sm-6">
                                                            <h6 class="mt-2 text-left">{{ $orden->factorFibral }} %</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group row">
                                                        <label for="produccionNeta" class="col-sm-6 col-form-label">PROD.REAL (kg):</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                            id="produccionNeta" value="{{ number_format($orden->produccionNeta,2) }} kg">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group row">
                                                        <label for="produccionReal" class="col-sm-6 col-form-label">PROD.TOTAL (kg):</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" readonly class="form-control-plaintext"
                                                            id="produccionReal" value="{{ number_format($orden->produccionTotal,2) }} kg">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group row">
                                                        <label for="lav-tetrapack" class="col-sm-6 col-form-label">Lavadora
                                                            de Tetrapack (kg):</label>
                                                        <div class="col-sm-6">
                                                            <h6 class="mt-2">{{ number_format($orden->lavadoraTetrapack,2) }} kg <span class="float-right">{{ $orden->porcentLavadoraTetrapack }} %</span>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- [ Header orden produccion ] end -->
                            </div>

                            <section>
                                <div class="container-fluid">
                                    <div class="row">
                                        <!-- [ Consumo Agua ] start -->
                                        <div class="col-xl-4 col-md-4">
                                            <div class="card card-social">
                                                <div class="card-header text-center">
                                                    <h5 class="m-0">5. Agua</h5>
                                                </div>
                                                <div class="card-block border-bottom">
                                                    <div class="row align-items-center justify-content-center">
                                                        <div class="col-auto">
                                                            <h6 class="mb-0">Consumo en m<sup>3</sup></h6>
                                                        </div>
                                                        <div class="col text-right">
                                                            <h6>{{ $orden->consumoAgua['total']}} m<sup>3</sup></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-block">
                                                    <div class="row align-items-center justify-content-center card-active">
                                                        <div class="col-2 m-0 p-0">
                                                            <h6 class="text-left m-b-10"><span class="text-muted m-r-5">Inicial:</span>
                                                            </h6>
                                                        </div>
                                                        <div class="col-4 m-0 p-0">
                                                            <h6 class="text-right m-b-10"><span class="text-muted m-r-5"></span>{{ number_format($orden->consumoAgua['inicial'],2) }} m<sup>3</sup>
                                                            </h6>
                                                        </div>
                                                        <div class="col-2 m-0 p-0">
                                                            <h6 class="text-right m-b-10"><span class="text-muted m-r-5">Final:</span>
                                                            </h6>
                                                        </div>
                                                        <div class="col-4 m-0 p-0">
                                                            <h6 class="text-right  m-b-10"><span class="text-muted m-r-5"></span>{{ number_format($orden->consumoAgua['final'],2) }} m<sup>3</sup>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- [ Consumo Agua ] end -->
                                        <!-- [ Consumo Gas ] start -->
                                        <div class="col-xl-4 col-md-4">
                                            <div class="card card-social">
                                                <div class="card-header text-center">
                                                    <h5 class="m-0">7. Gas Butano</h5>
                                                </div>
                                                <div class="card-block border-bottom">
                                                    <div class="row align-items-center justify-content-center">
                                                        <div class="col-auto">
                                                            <h6 class="mb-0">Consumo Total</h6>
                                                        </div>
                                                        <div class="col text-right">
                                                            <h6>{{ $orden->consumoGas['total']}} Glns</h6>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center justify-content-center">
                                                        <div class="col-auto">
                                                            <h6 class="mb-0">Estandar Consumo de Gas por Ton:</h6>
                                                        </div>
                                                        <div class="col text-right">
                                                            <h6>145 Glns/Ton</h6>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center justify-content-center">
                                                        <div class="col-auto">
                                                            <h6 class="mb-0">Consumo Real de Gas por Ton:</h6>
                                                        </div>
                                                    <!--<div class="col text-right">
                                                    <h6>{{ number_format($orden->estandar_gas,2) }} Glns/Ton</h6>
                                                </div>-->
                                                        @if ($orden->estandar_electricidad > 145)
                                                            <div class="col text-right" >
                                                                <h6 style="color: red"> {{ number_format($orden->estandar_gas,2) }} Glns/Ton</h6>
                                                            </div>
                                                        @elseif ($orden->estandar_electricidad < 145)
                                                            <div class="col text-right">
                                                                <h6 style="color: green"> {{ number_format($orden->estandar_gas,2) }} Glns/Ton</h6>
                                                            </div>
                                                        @else
                                                            <div class="col text-right">
                                                                <h6> {{ number_format($orden->estandar_gas,2) }} Glns/Ton</h6>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- [ Consumo Gas ] end -->
                                        <!-- [ Consumo Electricidad ] start -->
                                        <div class="col-xl-4 col-md-4">
                                            <div class="card card-social">
                                                <div class="card-header text-center">
                                                    <h5 class="m-0">6. Electricidad</h5>
                                                </div>
                                                <div class="card-block">
                                                    <div class="row align-items-center justify-content-center card-active">
                                                        <div class="col-2 m-0 p-0">
                                                            <h6 class="text-left m-b-10"><span class="text-muted m-r-5">Inicial:</span>
                                                            </h6>
                                                        </div>
                                                        <div class="col-4 m-0 p-0">
                                                            <h6 class="text-right m-b-10"><span class="text-muted m-r-5"></span>{{ number_format($orden->electricidad['inicial'],2) }} Kwh
                                                            </h6>
                                                        </div>
                                                        <div class="col-2 m-0 p-0">
                                                            <h6 class="text-right m-b-10"><span class="text-muted m-r-5">Final:</span>
                                                            </h6>
                                                        </div>
                                                        <div class="col-4 m-0 p-0">
                                                            <h6 class="text-right m-b-10"><span class="text-muted m-r-5"></span>{{ number_format($orden->electricidad['final'],2) }} Kwh
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-block border-bottom">
                                                    <div class="row align-items-center justify-content-center">
                                                        <div class="col-auto">
                                                            <h6 class="mb-0">Factor de conversión: </h6>
                                                        </div>
                                                        <div class="col text-right">
                                                            <h6>560</h6>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center justify-content-center">
                                                        <div class="col-auto">
                                                            <h6 class="mb-0">Consumo energetico</h6>
                                                        </div>
                                                        <div class="col text-right">
                                                            <h6>{{ number_format($orden->electricidad['totalConsumo'],2) }} Kw</h6>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center justify-content-center">
                                                        <div class="col-auto">
                                                            <h6 class="mb-0">Consumo Real(80%)</h6>
                                                        </div>
                                                        <div class="col text-right">
                                                            <h6> {{ $orden->electricidad['totalProcesoH'] }} Kw/Hrs</h6>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center justify-content-center">
                                                        <div class="col-auto">
                                                            <h6 class="mb-0">Estandar de Consumo Kw/Ton:</h6>
                                                        </div>
                                                        <div class="col text-right">
                                                            <h6>740 Kw/Ton</h6>
                                                        </div>
                                                    </div>
                                                    <div class="row align-items-center justify-content-center">
                                                        <div class="col-auto">
                                                            <h6 class="mb-0">Consumo Real Kw/Ton:</h6>
                                                        </div>
                                                    <!--<div class="col text-right">
                                                    <h6> {{ number_format($orden->estandar_electricidad,2) }} Kw/Ton</h6>
                                                </div>-->
                                                        @if ($orden->estandar_electricidad > 740)
                                                            <div class="col text-right" >
                                                                <h6 style="color: red"> {{ number_format($orden->estandar_electricidad,2) }} Kw/Ton</h6>
                                                            </div>
                                                        @elseif ($orden->estandar_electricidad < 740)
                                                            <div class="col text-right">
                                                                <h6 style="color: green"> {{ number_format($orden->estandar_electricidad,2) }} Kw/Ton</h6>
                                                            </div>
                                                        @else
                                                            <div class="col text-right">
                                                                <h6> {{ number_format($orden->estandar_electricidad,2) }} Kw/Ton</h6>
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- [ Consumo Electricidad ] end -->
                                    </div>
                                </div>
                            </section>

                            <section>
                                <div class="container-fluid">
                                    <div class="row">
                                        <nav class="navbar  navbar-expand-lg  ">
                                            <div class="nav nav-tabs d-flex justify-content-center" id="nav-tab" role="tablist">
                                                <a class="nav-item nav-link active" id="navFibra" data-toggle="tab"
                                                   href="#nav-fib" role="tab" aria-controls="nav-bod" aria-selected="true">Fibra</a>
                                                <a class="nav-item nav-link" id="navMOD" data-toggle="tab" href="#nav-MOD"
                                                   role="tab" aria-controls="nav-MOD" aria-selected="false">Mano de obra
                                                    directa</a>
                                                <a class="nav-item nav-link" id="navQuimico" data-toggle="tab"
                                                   href="#nav-Quim" role="tab" aria-controls="nav-Quim"
                                                   aria-selected="false">Quimicos</a>
                                                <a class="nav-item nav-link" id="navCIF" data-toggle="tab" href="#nav-CIF"
                                                   role="tab" aria-controls="nav-Cif" aria-selected="false">Costos
                                                    indirectos de fabricación</a>

                                            </div>
                                        </nav>

                                    </div>
                                </div>

                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="nav-fib" role="tabpanel" aria-labelledby="navFibra">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card card-event">
                                                    <div class="card-header">
                                                        <h5 class="m-0">1. Materia Prima Directa (M. P.)</h5>
                                                    </div>
                                                    <div class="card-block table-border-style">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover" id="dtBachadasxdias">
                                                                <thead>
                                                                <tr class="text-center">
                                                                    <th class="text-center">MAQUINA</th>
                                                                    <th>DESCRIPCION</th>
                                                                    <th>CANTIDAD</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach ($mp_directa as $key => $mp)
                                                                    <tr class="unread">
                                                                        <td class="dt-center">{{ $mp->nombre }}</td>
                                                                        <td class="dt-center">{{ $mp->descripcion }}</td>
                                                                        <td class="dt-center">{{ number_format($mp->cantidad,2) }}
                                                                            kg
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-MOD" role="tabpanel" aria-labelledby="navMOD">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card card-event">
                                                    <div class="card-header">
                                                        <h5 class="m-0">2. Materia Prima Directa</h5>
                                                    </div>
                                                    <div class="card-block table-border-style">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover" id="dtBachadasxdias">
                                                                <thead>
                                                                <tr class="text-center">
                                                                    <th class="text-left">DESCRIPCION DE LA ACTIVIDAD</th>
                                                                    <th>DIA</th>
                                                                    <th>NOCHE</th>
                                                                    <th>TOTAL</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach ($mo_directa as $key)
                                                                    <tr class="unread">
                                                                        <td class="dt-left">{{ $key['actividad'] }}</td>
                                                                        <td class="dt-center">{{ $key['dia'] }} hrs</td>
                                                                        <td class="dt-center">{{ $key['noche'] }} hrs</td>
                                                                        <td class="dt-center">{{ number_format($key['total'],2) }}
                                                                            hrs
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-Quim" role="tabpanel" aria-labelledby="navQuimico">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card card-event">
                                                    <div class="card-header">
                                                        <h5 class="m-0">3. Quimicos</h5>
                                                    </div>
                                                    <div class="card-block table-border-style">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover" id="dtBachadasxdias">
                                                                <thead>
                                                                <tr class="text-center">
                                                                    <th class="text-center">MAQUINA</th>
                                                                    <th>DESCRIPCION</th>
                                                                    <th>CANTIDAD</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach ($quimico_maquina as $key => $qm)
                                                                    <tr class="unread">
                                                                        <td class="dt-center">{{ $qm->nombre }}</td>
                                                                        <td class="dt-center">{{ $qm->descripcion }}</td>
                                                                        <td class="dt-center">{{ $qm->cantidad }}</td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-CIF" role="tabpanel" aria-labelledby="navCIF">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card card-event">
                                                    <div class="card-header">
                                                        <h5 class="m-0">4. Costos indirectos de fabricación</h5>
                                                    </div>
                                                    <div class="card-block table-border-style">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover" id="dtBachadasxdias">
                                                                <thead>
                                                                <tr class="text-center">
                                                                    <th class="text-left">DESCRIPCION DE LA ACTIVIDAD</th>
                                                                    <th>HORAS</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach ($mo_directa as $key)
                                                                    <tr class="unread">
                                                                        <td class="dt-left">{{ $key['actividad'] }}</td>
                                                                        <td class="dt-center">{{ number_format($key['total'],2) }} hrs</td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection

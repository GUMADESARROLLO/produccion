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
                            <section class="m-1">
                                <div class="container-fluid">
                                    <div class="row">
                                        <!-- [ Header orden produccion ] start -->
                                        <div class="col-xl-12">
                                            <div class="card">
                                                <div class=" card-titled-flex justify-content-center align-items-center">
                                                    <h5 class="text-center align-self-center my-2"> N°: {{ $orden->numOrden }}
                                                        - {{ $orden->producto }}
                                                    </h5>
                                                    <h5 class="text-center align-self-center my-2"> {{ $orden->fechaInicio }} - {{ $orden->horaInicio }} -
                                                        {{ $orden->fechaFinal }} - {{ $orden->horaFinal }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- [ Header orden produccion ] end -->
                                    </div>
                                </div>
                            </section>

                            <section class="m-1">
                                <div class="container-fluid">
                                    <div class="row m-3">
                                        <div class="col-xl-3">
                                            <p class="text-muted">Merma Yankee Dry (kg)</p>
                                            <p class="font-weight-bolder" style="color: black; font-size: 1.2rem!important">{{ number_format($orden->mermaYankeeDry,2) }} kg</p>
                                        </div>
                                        <div class="col-xl-3">
                                            <p class="text-muted">Merma Yankee Dry (%)</p>
                                            <p class="font-weight-bolder" style="color: black; font-size: 1.2rem!important">{{ $orden->porcentMermaYankeeDry }} %</p>
                                        </div>
                                        <div class="col-xl-3">
                                            <p class="text-muted">Residuos del Pulper (kg):</p>
                                            <p class="font-weight-bolder" style="color: black; font-size: 1.2rem!important">{{ number_format($orden->residuosPulper,2) }} kg</p>
                                        </div>
                                        <div class="col-xl-3">
                                            <p class="text-muted">Residuos del Pulper (%):</p>
                                            <p class="font-weight-bolder" style="color: black; font-size: 1.2rem!important">{{ $orden->porcentResiduosPulper }} %</p>
                                        </div>
                                    </div>
                                    <div class="row m-3">
                                        <div class="col-xl-3">
                                            <p class="text-muted">Horas Trabajadas</p>
                                            <p class="font-weight-bolder" style="color: black; font-size: 1.2rem!important">{{ $orden->hrsTrabajadas }} hrs</p>
                                        </div>
                                        <div class="col-xl-3">
                                            <p class="text-muted">Factor fibral</p>
                                            <p class="font-weight-bolder" style="color: black; font-size: 1.2rem!important">{{ $orden->factorFibral }} %</p>
                                        </div>
                                        <div class="col-xl-3">
                                            <p class="text-muted">PROD.REAL (kg):</p>
                                            <p class="font-weight-bolder" style="color: black; font-size: 1.2rem!important"> {{ number_format($orden->produccionNeta,2) }} kg</p>
                                        </div>
                                        <div class="col-xl-3">
                                            <p class="text-muted">PROD.TOTAL (kg):</p>
                                            <p class="font-weight-bolder" style="color: black; font-size: 1.2rem!important"> {{ number_format($orden->produccionTotal,2) }} kg</p>
                                        </div>
                                    </div>
                                    <div class="row m-3">
                                        <div class="col-xl-3">
                                            <p class="text-muted">Lavadora de Tetrapack (kg):</p>
                                            <p class="font-weight-bolder" style="color: black; font-size: 1.2rem!important"> {{ number_format($orden->lavadoraTetrapack,2) }} kg</p>
                                        </div>
                                        <div class="col-xl-3">
                                            <p class="text-muted">Lavadora de Tetrapack (%):</p>
                                            <p class="font-weight-bolder" style="color: black; font-size: 1.2rem!important"> {{ $orden->porcentLavadoraTetrapack }} %</p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section class="m-1">
                                <div class="container-fluid">
                                    <div class="row">
                                        <!-- [ Consumo Agua ] start -->
                                        <div class="col-xl-4 col-md-4">
                                            <div class="card card-social">
                                                <div class="card-title text-center">
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
                                                <div class="card-title text-center">
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
                                                        @if ($orden->estandar_gas > 145)
                                                            <div class="col text-right" >
                                                                <h6 style="color: red"> {{ number_format($orden->estandar_gas,2) }} Glns/Ton</h6>
                                                            </div>
                                                        @elseif ($orden->estandar_gas < 145)
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
                                                <div class="card-title text-center">
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

                            <section class="m-1">
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

                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="nav-fib" role="tabpanel" aria-labelledby="navFibra">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="card card-event">
                                                        <div class="card-title">
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
                                                        <div class="card-title">
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
                                                        <div class="card-title">
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
                                                        <div class="card-title">
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

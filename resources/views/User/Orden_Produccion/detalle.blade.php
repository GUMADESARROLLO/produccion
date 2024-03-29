@extends('layouts.main')
@section('metodosjs')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/detailStyle.css') }}">
@endsection
@section('content')
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="nk-content ">
                <div class="container-fluid ">
                    <div class="nk-content-body">
                        <div class="nk-block-head nk-block-head-sm">
                            <div class="nk-block-between g-3">
                                <div class="nk-block-head-content">
                                    <h3 class="nk-block-title page-title">ORDEN NO.{{ $orden->numOrden }}</h3>
                                    <div class="nk-block-des text-soft">
                                        <ul class="breadcrumb">
                                            <!--<li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a></li>
                                            <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>-->
                                            <li class="breadcrumb-item"><a href="{{url('/orden-produccion')}}">Ordenes Produccion</a></li>
                                            <li class="breadcrumb-item"><a href="javascript:">Detalle</a></li>
                                        </ul>
                                    </div>

                                </div>
                                <div class="nk-block-head-content">
                                    <h3 class="nk-block-title page-title text-right">{{ $orden->producto }}</h3>
                                    <div class="nk-block-des text-right text-soft ">
                                    {{ $orden->fechaInicio }} - {{ $orden->horaInicio }} -{{ $orden->fechaFinal }} - {{ $orden->horaFinal }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- customizando la vista detalle -->
                    <div class="row g-gs">
                        <div class="col-lg-3">
                            <div class="row g-gs">
                                <div class="col-md-6 col-lg-12">
                                    <div class="card card-bordered ">
                                        <div class="card-inner ">
                                            <div class="card-title-group align-start mb-0">
                                                <div class="card-title">
                                                    <h6 class="title">AGUA</h6>
                                                </div>
                                            </div>
                                            <div class="card-amount">
                                            <span class="amount"> <span class="currency"> {{ $orden->consumo_agua['total'] }} m<sup>3</sup>
                                                </span>
                                            </span>
                                            </div>
                                            <div class="amount-sm">- <small>-</small></div>
                                            <div class="card-stats">
                                                <div class="card-stats-group g-2">
                                                    <div class="card-stats-data">
                                                        <div class="title">Inicial</div>
                                                        <div class="amount"> {{ number_format($orden->consumo_agua['inicial'],2) }}
                                                            m<sup>3</sup>
                                                        </div>
                                                    </div>
                                                    <div class="card-stats-data">
                                                        <div class="title">Final</div>
                                                        <div class="amount">{{ number_format($orden->consumo_agua['final'],2) }}
                                                            m<sup>3</sup>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="row g-gs">
                                <div class="col-md-6 col-lg-12">
                                    <div class="card card-bordered ">
                                        <div class="card-inner ">
                                            <div class="card-title-group align-start mb-0">
                                                <div class="card-title">
                                                    <h6 class="title">Electricidad</h6>
                                                </div>
                                            </div>
                                            <div class="card-amount">
                                                <span class="amount"> <span class="currency"> {{ $orden->electricidad['totalConsumo'] }} Kw/Hrs</span></span>
                                            </div>
                                            <div class="amount-sm"> <small>Factor de conversión</small></div>
                                            <div class="card-stats">
                                                <div class="card-stats-group g-2">
                                                    <div class="card-stats-data">
                                                        <div class="title">Inicial</div>
                                                        <div class="amount">{{ number_format($orden->electricidad['inicial'],2) }}</div>
                                                    </div>
                                                    <div class="card-stats-data">
                                                        <div class="title">Final</div>
                                                        <div class="amount"> {{ number_format($orden->electricidad['final'],2) }}</div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="row g-gs">
                                <div class="col-md-6 col-lg-12">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="card-title-group align-start mb-0">
                                                <div class="card-title">
                                                    <h6 class="title">Consumo Electricidad Kw/Ton</h6>
                                                </div>
                                            </div>

                                            <div class="card-amount">
                                                <!--<span class="amount">-->
                                                @if ($orden->estandar_electricidad > 740)
                                                    <span class="amount" style="color: red">{{ number_format($orden->estandar_electricidad,2) }} Kw/Ton</span>
                                                @elseif ($orden->estandar_electricidad> 0 && $orden->estandar_electricidad < 740)
                                                    <span class="amount" style="color: green">{{ number_format($orden->estandar_electricidad,2) }} Kw/Ton</span>
                                                @else
                                                    <span class="amount" style="color: black">{{ number_format($orden->estandar_electricidad,2) }} </span>
                                                @endif
                                                <div class="amount-sm">- <small>-</small></div>
                                            <!--</span>-->
                                            </div>
                                            <div class="card-stats">
                                                <div class="card-stats-group g-2">
                                                    <div class="card-stats-data">
                                                        <div class="title">Real (80%) : </div>
                                                        <div class="amount">{{ number_format($orden->electricidad['totalProcesoH'],2) }} </div>
                                                    </div>
                                                    <div class="card-stats-data">
                                                        <div class="title">Standar de Consu.:</div>
                                                        <div class="amount">740 Kw/Ton</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="row g-gs">
                                <div class="col-md-6 col-lg-12">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="card-title-group align-start mb-0">
                                                <div class="card-title">
                                                    <h6 class="title">Gas Butano</h6>
                                                </div>
                                            </div>
                                            <div class="card-amount">
                                                <span class="amount"> <span class="currency">{{ number_format($orden->consumoGas['total'],2) }} Glns</span>
                                                </span>
                                                <div class="amount-sm">- <small>-</small></div>
                                            </div>
                                            <div class="card-stats">
                                                <div class="card-stats-group g-2">
                                                    <div class="card-stats-data">
                                                        <div class="title">Standar Consu.</div>
                                                        <div class="amount"> 145 Glns/Ton</div>
                                                    </div>
                                                    <div class="card-stats-data">
                                                        <div class="title">Consu. Real </div>
                                                        <!--<div class="amount">-->
                                                        @if ($orden->estandar_gas > 145)
                                                            <div class="amount" style="color: red">{{ number_format($orden->estandar_gas,2) }} Glns/Ton</div>
                                                        @elseif ($orden->estandar_gas > 0 && $orden->estandar_gas < 145)
                                                            <div class="amount" style="color: green">{{ number_format($orden->estandar_gas,2) }} Glns/Ton</div>
                                                        @else
                                                            <div class="amount" style="color: black">{{ number_format($orden->estandar_gas,2) }} Glns/Ton</div>
                                                        @endif
                                                    <!--</div>-->
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
                    <!-- End of customization -->
                    <div class="row g-gs">
                        <div class="col-lg-6">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-3">
                                        <div class="card-title">
                                            <h6 class="title">Información General de la Orden</h6>
                                            <p>Se detalla datos relevantes de la orden.</p>
                                        </div>
                                        <div class="card m-0" style="">
                                            <h4 class="" style="color: #2B9A48"> Tonelada/Dia: {{ $orden->Tonelada_dia }}</h4>
                                            <span class="ml-1">STANDAR : 10 ton/dia</span>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="nk-insight">
                                        <div class="row g-4 align-end">
                                            <div class="col-xxl-8">
                                                <div class="nk-insight-ck">
                                                    <div class="nk-ovb">
                                                        <div class="nk-ovb-data-group g-4">
                                                            <div class="nk-ovb-data">
                                                                <div class="title"><span class="dot dot-lg sq" data-bg="#f7bf90" style="background: rgb(247, 191, 144) none repeat scroll 0% 0%;"></span><span>Merma Yankee Dry (kg)</span></div>
                                                                <div class="amount">
                                                                    {{ number_format($orden->mermaYankeeDry,2) }} KG
                                                                </div>
                                                            </div>
                                                            <div class="nk-ovb-data">
                                                                <div class="title"><span class="dot dot-lg sq" data-bg="#ffa9ce" style="background: rgb(255, 169, 206) none repeat scroll 0% 0%;"></span><span>Merma Yankee Dry (%)</span></div>
                                                                <div class="amount">{{ $orden->porcentMermaYankeeDry }} %</div>
                                                            </div>
                                                            <div class="nk-ovb-data">
                                                                <div class="title"><span class="dot dot-lg sq" data-bg="#b8acff" style="background: rgb(184, 172, 255) none repeat scroll 0% 0%;"></span><span>Residuos del Pulper (kg):</span></div>
                                                                <div class="amount">{{ number_format($orden->residuosPulper,2) }} KG</div>
                                                            </div>
                                                            <div class="nk-ovb-data">
                                                                <div class="title"><span class="dot dot-lg sq" data-bg="#9cabff" style="background: rgb(156, 171, 255) none repeat scroll 0% 0%;"></span><span>Residuos del Pulper (%):</span></div>
                                                                <div class="amount">{{ $orden->porcentResiduosPulper }} %</div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="nk-ovb">
                                                        <div class="nk-ovb-data-group g-4">
                                                            <div class="nk-ovb-data">
                                                                <div class="title"><span class="dot dot-lg sq" data-bg="#f7bf90" style="background: rgb(247, 191, 144) none repeat scroll 0% 0%;"></span><span>Horas Trabajadas</span></div>
                                                                <div class="amount">
                                                                    {{ number_format($orden->hrsTrabajadas,2) }} hrs
                                                                </div>
                                                            </div>
                                                            <div class="nk-ovb-data">
                                                                <div class="title"><span class="dot dot-lg sq" data-bg="#ffa9ce" style="background: rgb(255, 169, 206) none repeat scroll 0% 0%;"></span><span>Factor fibral</span></div>
                                                                <div class="amount">{{ $orden->factorFibral }} %</div>
                                                            </div>
                                                            <div class="nk-ovb-data">
                                                                <div class="title"><span class="dot dot-lg sq" data-bg="#b8acff" style="background: rgb(184, 172, 255) none repeat scroll 0% 0%;"></span><span>Lavadora de Tetrapack (kg):</span></div>
                                                                <div class="amount">{{ number_format($orden->lavadoraTetrapack,2) }} KG</div>
                                                            </div>
                                                            <div class="nk-ovb-data">
                                                                <div class="title"><span class="dot dot-lg sq" data-bg="#9cabff" style="background: rgb(156, 171, 255) none repeat scroll 0% 0%;"></span><span>Lavadora de Tetrapack (%):</span></div>
                                                                <div class="amount">{{ $orden->porcentLavadoraTetrapack }} %</div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-4">
                                                <div class="row g-4">

                                                    <div class="col-sm-6 col-xxl-12">
                                                        <div class="nk-insight-data payin">
                                                            <div class="amount">{{ number_format($orden->produccionNeta,2) }} <small class="currency">KG</small></div>

                                                            <div class="title"></em> PROD.REAL (kg):</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xxl-12">
                                                        <div class="nk-insight-data payout">
                                                            <div class="amount">{{ number_format($orden->produccionTotal,2) }} <small class="currency">KG.</small></div>
                                                            <div class="title">PROD.TOTAL (kg):</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-bordered" style="min-height:370px">
                                <div class="card-body">
                                    <div class="card-title mb-4">
                                        <h5 class="">YANKEE DRYER</h5>

                                        <h6>Horas Efectivas Por Contador</h6>
                                    </div>
                                    <table class="table table-hover" id="dthrasEfectivas">
                                        <thead>
                                        <tr class="text-center">
                                            <th class=" text-left" width="25%">MAQUINA</th>
                                            <th class=" " width="25%">Día</th>
                                            <th class=" " width="25%">Noche</th>
                                            <th class=" " width="25%">Total/Horas</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(is_null($yk_hrasEftvs))
                                            <tr class="unread">
                                                <td class="dt-left"> 0.00</td>
                                                <td class="dt-center"> 0.00</td>
                                                <td class="dt-center"> 0.00</td>
                                                <td class="dt-center"> 0.00</td>
                                            </tr>
                                        @else
                                            @foreach($yk_hrasEftvs as $hf)
                                                <tr class="unread">
                                                    <td class="dt-left">{{ $hf['nombre']}} </td>
                                                    <td class="dt-center">{{ $hf['dia']}} hrs</td>
                                                    <td class="dt-center">{{ $hf['noche']}} hrs</td>
                                                    <td class="dt-center">{{ $hf['total']}} hrs</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <tfoot class="text-center">
                                        <tr>
                                            <th colspan="4">
                                                <div class="mt-4">
                                                                    <span class="mt-5" style="font-size: 1rem; font-weight: 700;">Promedio De Horas Trabajadas En Yankee Dryer:
                                                                        <span class="" style="font-size: 1.5rem; font-weight: 700; color: #6c7ae0">
                                                                            @if($yk_hrasEftvs[0]['totalYk']!=null)
                                                                                {{ $yk_hrasEftvs[0]['totalYk'] }} Hrs
                                                                            @else
                                                                                0.00 Hrs
                                                                            @endif
                                                                        </span>
                                                                    </span>
                                                </div>
                                            </th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                        </div>



                    </div>
                    <div class="card card-bordered card-full">
                        <div class="card-inner border-bottom">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Insumos de la Orden de Producción</h6>
                                </div>
                                <div class="card-tools">
                                    <ul class="card-tools-nav nav">
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#nav_fibra"><span>Fibras</span></a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#nav_mano_obra"><span>Mano de obra directa</span></a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#nav_quimico"><span>Quimicos</span></a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#nav_costos_indirectos"><span>Costos indirectos de fabricación</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content mt-0">
                            <div class="tab-pane active" id="nav_fibra">
                                <div class="nk-tnx-pro is-scrollable h-425px" data-simplebar="init">
                                    <div class="simplebar-wrapper" style="margin: 0px;">
                                        <div class="simplebar-mask">
                                            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                                <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
                                                    <div class="simplebar-content" style="padding: 0px;">
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
                            </div>
                            <div class="tab-pane" id="nav_mano_obra">
                                <div class="nk-tnx-pro is-scrollable h-425px" data-simplebar="init">
                                    <div class="simplebar-wrapper" style="margin: 0px;">
                                        <div class="simplebar-mask">
                                            <div class="simplebar-offset">
                                                <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden;">
                                                    <div class="simplebar-content" style="padding: 0px;">
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
                            </div>
                            <div class="tab-pane" id="nav_quimico">
                                <div class="nk-tnx-pro is-scrollable h-425px" data-simplebar="init">
                                    <div class="simplebar-wrapper" style="margin: 0px;">
                                        <div class="simplebar-mask">
                                            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                                <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden;">
                                                    <div class="simplebar-content" style="padding: 0px;">
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
                            </div>
                            <div class="tab-pane" id="nav_costos_indirectos">
                                <div class="nk-tnx-pro is-scrollable h-425px" data-simplebar="init">
                                    <div class="simplebar-wrapper" style="margin: 0px;">
                                        <div class="simplebar-mask">
                                            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                                <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden;">
                                                    <div class="simplebar-content" style="padding: 0px;">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection

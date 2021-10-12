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
                                    <li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>
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
                                        <div class="card-header">
                                            <h5>Orden de Produccion N°: {{ $orden->numOrden }}  -  {{ $orden->producto }}</h5>
                                        </div>
                                    </div>  
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">                                                
                                              <div class="form-group row">
                                                <label for="fechaInicio" class="col-sm-6 col-form-label">Fecha Inicio:</label>
                                                <div class="col-sm-6">
                                                  <input type="text" readonly class="form-control-plaintext" id="fechaInicio" value="{{ $orden->fechaInicio }}">
                                                </div>
                                              </div>                                                
                                            </div>
                                            <div class="col-md-3">                                                
                                              <div class="form-group row">
                                                <label for="fechaFinal" class="col-sm-6 col-form-label">Fecha Final:</label>
                                                <div class="col-sm-6">
                                                  <input type="text" readonly class="form-control-plaintext" id="fechaFinal" value="{{ $orden->fechaFinal }}">
                                                </div>
                                              </div>                                                
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label for="merma-yankee-dry" class="col-sm-6 col-form-label">Merma Yankee Dry:</label>
                                                    <div class="col-sm-6">
                                                        <h6 class="mt-2">{{ $orden->mermaYankeeDry }} <span class="float-right">{{ $orden->porcentMermaYankeeDry }} %</span></h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-center">
                                                <label for="fechaFinal" class="col-sm-6 col-form-label">Horas Trabajadas</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">                                                
                                              <div class="form-group row">
                                                <label for="produccionNeta" class="col-sm-6 col-form-label">Hora Inicio:</label>
                                                <div class="col-sm-6">
                                                  <input type="text" readonly class="form-control-plaintext" id="produccionNeta" value="{{ $orden->horaInicio }}">
                                                </div>
                                              </div>                                                
                                            </div>
                                            <div class="col-md-3">                                                
                                              <div class="form-group row">
                                                <label for="horaFinal" class="col-sm-6 col-form-label">Hora Final:</label>
                                                <div class="col-sm-6">
                                                  <input type="text" readonly class="form-control-plaintext" id="horaFinal" value="{{ $orden->horaFinal }}">
                                                </div>
                                              </div>                                                
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label for="residuos-pulper" class="col-sm-6 col-form-label">Residuos del Pulper:</label>
                                                    <div class="col-sm-6">
                                                        <h6 class="mt-2">{{ $orden->residuosPulper }} <span class="float-right">{{ $orden->porcentResiduosPulper }} %</span></h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <h6 class="mt-2 text-center">{{ $orden->hrsTrabajadas }}</h6>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">                                                
                                              <div class="form-group row">
                                                <label for="produccionNeta" class="col-sm-6 col-form-label">PROD. REAL (unds y kg):</label>
                                                <div class="col-sm-6">
                                                  <input type="text" readonly class="form-control-plaintext" id="produccionNeta" value="{{ $orden->produccionNeta }}">
                                                </div>
                                              </div>                                                
                                            </div>
                                            <div class="col-md-3">                                                
                                              <div class="form-group row">
                                                <label for="produccionReal" class="col-sm-6 col-form-label">PROD. TOTAL (unds y kg):</label>
                                                <div class="col-sm-6">
                                                  <input type="text" readonly class="form-control-plaintext" id="produccionReal" value="{{ $orden->produccionReal }}">
                                                </div>
                                              </div>                                                
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label for="lav-tetrapack" class="col-sm-6 col-form-label">Lavadora de Tetrapack:</label>
                                                    <div class="col-sm-6">
                                                        <h6 class="mt-2">{{ $orden->lavadoraTetrapack }} <span class="float-right">{{ $orden->porcentLavadoraTetrapack }} %</span></h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Header orden produccion ] end -->

                            <!-- [ Tabla Materia Prima ] start -->
                            <div class="col-xl-6 col-md-6">
                                <div class="card card-event">
                                    <div class="card-header">
                                        <h5 class="m-0">Materia Prima Directa (M. P.)</h5>
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
                                                    <td class="dt-center">{{ $mp->cantidad }}</td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Tabla Materia Prima ] end -->

                            <!-- [ Tabla Materia Prima ] start -->
                            <div class="col-xl-6 col-md-6">
                                <div class="card card-event">
                                    <div class="card-header">
                                        <h5 class="m-0">Mano de Obra Directa</h5>
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
                                                    <td class="dt-center">{{ $key['dia'] }}</td>
                                                    <td class="dt-center">{{ $key['noche'] }}</td>
                                                    <td class="dt-center">{{ $key['total'] }}</td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Tabla Materia Prima ] end -->

                            <!-- [ Tabla Materia Prima ] start -->
                            <div class="col-xl-6 col-md-6">
                                <div class="card card-event">
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
                                                    <td class="dt-center">{{ $mp->cantidad }}</td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Tabla Materia Prima ] end -->

                            <!-- [ Tabla Materia Prima ] start -->
                            <div class="col-xl-6 col-md-6">
                                <div class="card card-event">
                                    <div class="card-header">
                                        <h5 class="m-0">Costos indirectos de Fabricación</h5>
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
                                                    <td class="dt-center">{{ $key['total'] }}</td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            <!-- [ Tabla Materia Prima ] end -->

                            <!-- [ Consumo Electricidad ] start -->
                            <div class="col-xl-6 col-md-6">
                                <div class="card card-social">
                                    <div class="card-block border-bottom">
                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-auto">
                                                 <h5 class="mb-0">Electricidad Kwh</h5>
                                            </div>
                                            <div class="col text-right">
                                                <h3>{{ $orden->electricidad['total'] }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center card-active">
                                            <div class="col-6">
                                                <h6 class="text-left m-b-10"><span class="text-muted m-r-5">Inicial:</span>{{ $orden->electricidad['inicial'] }}</h6>
                                            </div>
                                            <div class="col-6">
                                                <h6 class="text-left m-b-10"><span class="text-muted m-r-5">Final:</span>{{ $orden->electricidad['final'] }}</h6>
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
                                                 <h5 class="mb-0">Consumo Agua</h5>
                                            </div>
                                            <div class="col text-right">
                                                <h3>{{ $orden->consumoAgua['total'] }}</h3>
                                               
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div class="row align-items-center justify-content-center card-active">
                                            <div class="col-6">
                                                <h6 class="text-left m-b-10"><span class="text-muted m-r-5">Inicial:</span>{{ $orden->consumoAgua['inicial'] }}</h6>
                                            </div>
                                            <div class="col-6">
                                                <h6 class="text-left  m-b-10"><span class="text-muted m-r-5">Final:</span>{{ $orden->consumoAgua['final'] }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Consumo Agua ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->
@endsection
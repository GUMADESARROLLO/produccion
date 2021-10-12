@extends('layouts.main')
@section('metodosjs')
  @include('User.Reporte.js_reporte')
@endsection
@section('content')
<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ Header ] start -->
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="page-header-title">
                                    <h5 class="m-b-10">Hoja de Reporte</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{url('/orden-produccion')}}">Ordenes Produccion</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:">Reporte</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ Header ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                
                                <!-- [ statistics year chart ] start -->
                                <div class="col-xl-12 col-md-6">
                                    <div class="card card-event">
                                        <div class="card-block">
                                            <div class="row">
                                                <div class="col-4 border-right">
                                                    <div class="row align-items-center justify-content-center">
                                                        <div class="col">
                                                            <h5 class="m-0">{{ $producto->nombre }}</h5>
                                                        </div>
                                                    </div>
                                                    <h2 class="mt-3" id="numOrden">{{ $orden->numOrden }}</h2>
                                                    <h6 class="text-muted mb-0">Numero de orden activa </h6>
                                                </div>
                                                <div class="col-8">
                                                    <div class="row align-items-center justify-content-center">
                                                        <div class="col">
                                                            <h5 class="m-0">Costos Indirectos de Fabricacion</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-0">
                                                        <div class="col-sm-6">
                                                            <div class="card Monthly-sales mb-0">
                                                                <div class="card-block">
                                                                    <h6 class="mb-4 font-weight-bold">Electricidad Kwh</h6>
                                                                    <div class="row d-flex align-items-center">
                                                                        <div class="col-12">
                                                                        @if( is_null($electricidad) )
                                                                        <form>
                                                                          <div class="form-group row">
                                                                            <label for="consumoInicialElec" class="col-sm-5 col-form-label">{{ date('g:i a', strtotime($orden->horaInicio)) }} : </label>
                                                                            <div class="col-sm-7">
                                                                              <input type="number"class="form-control" id="consumoInicialElec">
                                                                            </div>
                                                                          </div>
                                                                          <div class="form-group row">
                                                                            <label for="consumoFinalElec" class="col-sm-5 col-form-label">{{ date('g:i a', strtotime($orden->horaFinal)) }} : </label>
                                                                            <div class="col-sm-7">
                                                                              <input type="number" class="form-control" id="consumoFinalElec">
                                                                            </div>
                                                                          </div>
                                                                        </form>
                                                                        @else
                                                                        <form>
                                                                          <div class="form-group row">
                                                                            <label for="consumoInicialElec" class="col-sm-5 col-form-label">{{ date('g:i a', strtotime($orden->horaInicio)) }} : </label>
                                                                            <div class="col-sm-7">
                                                                              <input type="number" value="{{ $electricidad->inicial }}" class="form-control" id="consumoInicialElec">
                                                                            </div>
                                                                          </div>
                                                                          <div class="form-group row">
                                                                            <label for="consumoFinalElec" class="col-sm-5 col-form-label">{{ date('g:i a', strtotime($orden->horaFinal)) }} : </label>
                                                                            <div class="col-sm-7">
                                                                              <input type="number" value="{{ $electricidad->final }}" class="form-control" id="consumoFinalElec">
                                                                            </div>
                                                                          </div>
                                                                        </form>
                                                                        @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="card Monthly-sales mb-0">
                                                                <div class="card-block">
                                                                    <h6 class="mb-4 font-weight-bold">Consumo Agua</h6>
                                                                    <div class="row d-flex align-items-center">
                                                                        <div class="col-12">
                                                                        @if( is_null($consumo_agua) )
                                                                        <form>
                                                                          <div class="form-group row">
                                                                            <label for="consumoInicialAgua" class="col-sm-5 col-form-label">Inicial : </label>
                                                                            <div class="col-sm-7">
                                                                              <input type="number"class="form-control" id="consumoInicialAgua">
                                                                            </div>
                                                                          </div>
                                                                          <div class="form-group row">
                                                                            <label for="consumoFinalAgua" class="col-sm-5 col-form-label">Final : </label>
                                                                            <div class="col-sm-7">
                                                                              <input type="number" class="form-control" id="consumoFinalAgua">
                                                                            </div>
                                                                          </div>
                                                                        </form>
                                                                        @else
                                                                        <form>
                                                                          <div class="form-group row">
                                                                            <label for="consumoInicialAgua" class="col-sm-5 col-form-label">Inicial : </label>
                                                                            <div class="col-sm-7">
                                                                              <input type="number"class="form-control" id="consumoInicialAgua" value="{{ $consumo_agua->inicial }}">
                                                                            </div>
                                                                          </div>
                                                                          <div class="form-group row">
                                                                            <label for="consumoFinalAgua" class="col-sm-5 col-form-label">Final : </label>
                                                                            <div class="col-sm-7">
                                                                              <input type="number" value="{{ $consumo_agua->final }}" class="form-control" id="consumoFinalAgua">
                                                                            </div>
                                                                          </div>
                                                                        </form>
                                                                        @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-0">
                                                        <div class="col-12">
                                                            <button class="btn btn-success float-right" id="btncCIFAB">Guardar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- [ statistics year chart ] end -->
                                
                                <!-- [ Tiempo de Pulpeo ] start -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="card card-event">
                                        <div class="card-block border-bottom">
                                            <div class="row align-items-center justify-content-center">
                                                <div class="col-6">
                                                    <h5 class="m-0">Tiempo de Pulpeo</h5>
                                                </div>
                                                <div class="col-6">
                                                    @if( is_null($pulpeo) )
                                                    <input value="" class="input-dt float-right" id="tiempo-pulpeo" style="font-size: 1.3em;" type="text" placeholder="Digite la cantidad">
                                                    @else
                                                    <input value="{{ $pulpeo->tiempoPulpeo }}" class="input-dt float-right" id="tiempo-pulpeo" style="font-size: 1.3em;" type="text" placeholder="Digite la cantidad">
                                                    @endif                                                    
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="card-block table-border-style">
                                            <h6 class="text-uppercase text-center font-weight-bold mb-3">No. de Bachadas en el pulper</h6>
                                            <div class="table-responsive">
                                                <table class="table table-hover" id="dtBachadasxdias">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th class="text-center">#</th>
                                                            <th>FECHA</th>
                                                            <th>DIA</th>
                                                            <th>NOCHE</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($tiempoPulpeo as $key => $tp)
                                                    <tr class="unread">
                                                        <td class="dt-center">{{ $tp->id }}</td>
                                                        <td class="dt-center">
                                                            <input type="text" class="input-fecha-dos form-control" id="fch-pulp-{{ $tp->id }}" value="{{ $tp->fecha }}">
                                                        </td>
                                                        <td class="dt-center">
                                                            <input class="input-dt" type="text" placeholder="Cantidad" id="cant-pulp-dia-{{ $tp->id }}" value="{{ $tp->cant_dia }}">
                                                        </td>
                                                        <td class="dt-center">
                                                            <input class="input-dt" type="text" placeholder="Cantidad" id="cant-pulp-noc-{{ $tp->id }}" value="{{ $tp->cant_noche }}">
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <button class="btn btn-success float-right" id="btnGBACH">Guardar</button>
                                                <button class="btn btn-danger float-right" id="quitRowdtBATH">Quitar</button>
                                                <button class="btn btn-light add-row-dt-bach float-right">Agregar</button>
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
                                                <div class="col-6">
                                                    <h5 class="m-0">Tiempo de Lavado</h5>
                                                </div>
                                                <div class="col-6">
                                                    @if( is_null($lavado) )
                                                    <input value="" class="input-dt float-right" id="tiempo-lavado" style="font-size: 1.3em;" type="text" placeholder="Digite la cantidad">
                                                    @else
                                                    <input value="{{ $lavado->tiempoLavado }}" class="input-dt float-right" id="tiempo-lavado" style="font-size: 1.3em;" type="text" placeholder="Digite la cantidad">
                                                    @endif  
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="card-block table-border-style">
                                            <h6 class="text-uppercase text-center font-weight-bold mb-3">No. de Batch en el lavadora Tetrapack</h6>
                                            <div class="table-responsive">
                                                <table class="table table-hover" id="dtBachadasTetra">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th class="text-center">#</th>
                                                            <th>FECHA</th>
                                                            <th>DIA</th>
                                                            <th>NOCHE</th>                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($tiempoLavado as $key => $tl)
                                                    <tr class="unread">
                                                        <td class="dt-center">{{ $tl->id }}</td>
                                                        <td class="dt-center">
                                                            <input type="text" class="input-fecha-dos form-control" id="fch-lava-{{ $tl->id }}" value="{{ $tl->fecha }}">
                                                        </td>
                                                        <td class="dt-center">
                                                            <input class="input-dt" type="text" placeholder="Cantidad" id="cant-lava-dia-{{ $tl->id }}" value="{{ $tl->cant_dia }}">
                                                        </td>
                                                        <td class="dt-center">
                                                            <input class="input-dt" type="text" placeholder="Cantidad" id="cant-lava-noc-{{ $tl->id }}" value="{{ $tl->cant_noche }}">
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <button class="btn btn-primary float-right" id="btnGTLAV">Guardar</button>
                                                <button class="btn btn-danger float-right" id="quitRowdtLAV">Quitar</button>
                                                <button class="btn btn-light add-row-dt-tetra float-right">Agregar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- [ Tiempo de Lavado ] end -->

                                <!-- [ Tiempos Muertos ] start -->
                                <div class="col-xl-12 col-md-6">
                                    <div class="card card-event">
                                        <div class="card-block border-bottom">
                                            <div class="row align-items-center justify-content-center">
                                                <div class="col-12">
                                                    <h5 class="m-0">Tiempos Muertos</h5>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="card-block table-border-style">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-border-style" id="dtTiemposMuertos">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="1"></th>
                                                            <th colspan="1"></th>
                                                            <th class="text-center" colspan="2">
                                                                <h6 class="text-uppercase font-weight-bold">Día</h6>
                                                            </th>
                                                            <th class="text-center" colspan="2">
                                                                <h6 class="text-uppercase font-weight-bold">Noche</h6>
                                                            </th>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <th class="text-center">#</th>
                                                            <th>Fecha</th>
                                                            <th>Y1</th>
                                                            <th>Y2</th>
                                                            <th>Y1</th>
                                                            <th>Y2</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($t_muerto as $key => $tm)
                                                    <tr class="unread">
                                                        <td class="dt-center">{{ $tm->id }}</td>
                                                        <td class="dt-center">
                                                            <input type="text" class="input-fecha-dos form-control" id="fch-tm-{{ $tm->id }}" value="{{ $tm->fecha }}">
                                                        </td>
                                                        <td class="dt-center">
                                                            <input class="input-dt" type="text" placeholder="Cantidad" id="cant-y1-dia-{{ $tm->id }}" value="{{ $tm->y1_dia }}">
                                                        </td>
                                                        <td class="dt-center">
                                                            <input class="input-dt" type="text" placeholder="Cantidad" id="cant-y2-dia-{{ $tm->id }}" value="{{ $tm->y2_dia }}">
                                                        </td>
                                                        <td class="dt-center">
                                                            <input class="input-dt" type="text" placeholder="Cantidad" id="cant-y1-noc-{{ $tm->id }}" value="{{ $tm->y1_noche }}">
                                                        </td>
                                                        <td class="dt-center">
                                                            <input class="input-dt" type="text" placeholder="Cantidad" id="cant-y2-noc-{{ $tm->id }}" value="{{ $tm->y2_noche }}">
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <button class="btn btn-primary float-right" id="btnTMuertos">Guardar</button>
                                                <button class="btn btn-danger float-right" id="quitRowdtTM">Quitar</button>
                                                <button class="btn btn-light add-row-dt-tmuertos float-right">Agregar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- [ Tiempos Muertos ] end -->

                                <!-- [ Inventario ] start -->
                                <div class="col-xl-12 col-md-6">
                                  <div class="card">
                                    <div class="card-header">
                                        <h5>Inventarios</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive mt-3" id="container-table-inventario">
                                        </div>
                                        <button class="btn btn-primary float-right" id="btnInventarioFull">Guardar</button>
                                        <button class="btn btn-danger float-right" id="quitRowdtJROLL">Quitar</button>
                                        <button class="btn btn-light add-row-dt-inventarios float-right">Agregar</button>
                                    </div>
                                </div>
                                <!-- [ JUMBO ROLL ] end -->

                                <!-- [ JUMBO ROLL ] start -->
                                <div class="col-xl-12 col-md-6">
                                  <div class="card">
                                    <div class="card-header">
                                        <h5>Jumbo Roll</h5>
                                    </div>
                                    <div class="card-body">
                                        @foreach ($jumboroll as $key => $jr)
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="turno">Turno</label>
                                                    <select class="form-control" name="turno" id="turno">
                                                    @foreach($turnos as $tu)
                                                        @if ( $tu->idTurno==$jr->idTurno )
                                                        <option value="{{ $tu['idTurno'] }}" selected>{{ $tu['turno'] }}</option>
                                                        @else
                                                        <option value="{{ $tu['idTurno'] }}">{{ $tu['turno'] }}</option>
                                                        @endif                                                    
                                                    @endforeach
                                                    </select>
                                                    <small id="grupoturno" class="form-text text-muted">Seleccione un turno</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="jefe">Jefe de Turno</label>
                                                    <select class="form-control" name="jefe" id="jefe">
                                                    @foreach($usuarios as $u)
                                                        @if ( $u['id']==$jr->idUsuario )
                                                        <option value="{{ $u['id'] }}" selected>{{ $u['nombres'] }} {{ $u['apellidos'] }}</option>
                                                        @else
                                                        <option value="{{ $u['id'] }}">{{ $u['nombres'] }} {{ $u['apellidos'] }}</option>
                                                        @endif 
                                                    
                                                    @endforeach
                                                    </select>
                                                    <small id="grupoHelp" class="form-text text-muted">Seleccione un Jefe de Turno</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="fecha01">Fecha Inicia</label>
                                                    <input type="text" value="{{ $jr->fechaInicio }}" class="input-fecha form-control" name="fecha01" id="fecha01">
                                                    <small id="fecha01Help" class="form-text text-muted">Indique la fecha en que inicia</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="fecha02">Fecha Finaliza</label>
                                                    <input type="text" value="{{ $jr->fechaFinal }}" class="input-fecha form-control" name="fecha02" id="fecha02">
                                                    <small id="fecha02Help" class="form-text text-muted">Indique la fecha en que finaliza</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="res-pulper">Residuo del Pulper</label>
                                                    <input type="number" class="form-control" name="res-pulper" id="res-pulper" value="{{ $jr->residuo_pulper }}">
                                                    <small id="numordenHelp" class="form-text text-muted">Digite la cantidad de Residuo del Pulper</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="lav-tetrapack">Lavadora de Tetrapack</label>
                                                    <input type="number" class="form-control" name="lav-tetrapack" id="lav-tetrapack" value="{{ $jr->lavadora_tetrapack }}">
                                                    <small id="numordenHelp" class="form-text text-muted">Digite la cantidad de Lavadora de Tetrapack</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="merma-dry-y1">Merma Yankee Dry Y1</label>
                                                    <input type="text" class="form-control" name="merma-dry-y1" id="merma-dry-y1" value="{{ $jr->merma_yankee_dry_1 }}">
                                                    <small id="merma-dry-y1Help" class="form-text text-muted">Digite la Merma Yankee Dry Y1</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="merma-dry-y2">Merma Yankee Dry Y2</label>
                                                    <input type="number" class="form-control" name="merma-dry-y2" id="merma-dry-y2" value="{{ $jr->merma_yankee_dry_2 }}">
                                                    <small id="merma-dry-y2Help" class="form-text text-muted">Digite la Merma Yankee Dry Y2</small>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        
                                        <div class="table-responsive mt-3">
                                            <table class="table table-hover" id="dtJumboRoll">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th class="text-center">#</th>
                                                        <th>VIÑETA</th>
                                                        <th>KG</th>
                                                        <th>Gsm</th>
                                                        <th>YANKEE</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                        <button class="btn btn-primary float-right" id="btnGJROLL">Guardar</button>
                                        <button class="btn btn-danger float-right" id="quitRowdtJROLL">Quitar</button>
                                        <button class="btn btn-light add-row-dt-jroll float-right">Agregar</button>
                                    </div>
                                </div>
                                <!-- [ JUMBO ROLL ] end -->
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

<!-- [ MODAL ] start -->
<div class="modal fade" id="mdInventarioSolicitado" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-xl" role="document" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bolder">Agregar Inventario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="fibra" class="col-form-label">Seleccione la Fibra</label>
                <select class="form-control" id="fibra"></select>
              </div>
              <div class="form-group">
                <label for="cantidad-fibra" class="col-form-label">Cantidad</label>
                <input type="text" class="form-control" id="cantidad-fibra">
              </div>
            </form>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="btnGuardarInv">Guardar</button>
          </div>
        </div>
    </div>
</div>
<!-- [ MODAL ] end -->
@endsection

<thead>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    <tr><th></th><tr><th></th>

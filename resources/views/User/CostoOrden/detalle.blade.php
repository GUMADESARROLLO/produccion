@extends('layouts.main')
@section('metodosjs')
@include('jsViews.js_costo_orden')
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
                                    <h5 class="m-b-10">Lista Costos por Orden</h5>
                                </div>
                                <ul class="breadcrumb">
                                <!--<li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>-->
                                    <li class="breadcrumb-item"><a href="{{url('/costo-orden')}}">Lista de
                                            ordenes</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:"> Lista de Costos por Orden</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-2 text-center">
                                <a href="{{url('costo-orden/nuevo')}}" class="btn btn-primary btn-sm text-right"
                                    id="btnNuevoCostoO">Nuevo Costo</a>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="">
                <!-- [ breadcrumb ] start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <!-- [ Tabla Categorias ] start -->
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col">
                                                <h5>Lista de Costos por Orden</h5>
                                            </div>

                                            <div class="col text-right">
                                                <a id="btnTipoCambio" class="btn btn-info active " data-dismiss="modal"
                                                   data-toggle="modal" data-target="#capturacompararModal">T / C : C$ {{ number_format($TipoCambio,4) }} </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="id_tbl_costo_detalles">
                                                <thead>
                                                    <tr class="text-center">

                                                        <th>#</th>
                                                        <th>DESCRIPCIÓN</th>
                                                        <th>UNIDAD DE MEDIDA</th>
                                                        <th>CANTIDAD</th>
                                                        <th>COSTO UNITARIO</th>

                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($costoOrdenL as $key => $co)
                                                    <tr class="unread">
                                                        <td class="dt-center">{{ $key+1 }}</td>
                                                        <td class="dt-center">{{ $co->descripcion }}</td>
                                                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                                                        <td class="dt-center">{{ $co->cantidad }}</td>
                                                        <td class="dt-center">C$ {{ $co->costo_unitario }}</td>


                                                        <td class="dt-center">
                                                            <!--<a href="#!" onclick="deleteCostoOrden()"><i
                                                                    class="feather icon-x-circle text-c-red f-30 m-r-10"></i></a>-->
                                                            <a href="editar/{{ $co->id }}" target="_blank"
                                                                id="btnEditar">
                                                                <i
                                                                    class="feather icon-edit text-c-blue f-30 m-r-10"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th class="text-right" colspan="5">
                                                            <h5>Costo Total en C$</h5>
                                                        </th>
                                                        <th>
                                                            @if(isset($detalle_orden))
                                                            <h5 id="ctCordobas">{{ number_format($detalle_orden,2) }}</h5>
                                                            @else
                                                            <h5 id="ctCordobas">{{ number_format(0,2) }}</h5>
                                                            @endif
                                                        </th>
                                                    </tr>

                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Tabla Categorias ] end -->
                        </div>
                        <!-- [ Tabla Categorias ] start -->
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>HORAS PRODUCTIVAS</h5>
                                </div>
                                <div class="card-block table-border-style">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="dtHrsProd">
                                            <thead>
                                                <tr class="text-left">
                                                    <th></th>
                                                    <th>MAQUINA</th>
                                                    <th>HORAS JORNADAS</th>
                                                    <th>HORAS LABORALES</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($ordenes as $key => $op)
                                                <input class="input-dt text-left" name="codigo" type="text"
                                                    id="numOrden" value="{{$op['numOrden'] }}">
                                                @if(is_null($op->horaJY1))
                                                <tr>
                                                    <td>
                                                    </td>
                                                    <td><input class="input-dt text-left unread" readonly type="text"
                                                            value="YANKEE 1" placeholder="maquina" id=""></td>
                                                    <td><input class="input-dt text-left" type="text"
                                                            placeholder="horas" id="horaJY1"></td>
                                                    <td><input class="input-dt text-left" type="text"
                                                            placeholder="horas" id="horaLY1"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td><input class="input-dt text-left unread" readonly type="text"
                                                            value="YANKEE 2" placeholder="maquina" id=""></td>
                                                    <td><input class="input-dt text-left" type="text"
                                                            placeholder="horas" id="horaJY2"></td>
                                                    <td><input class="input-dt text-left" type="text"
                                                            placeholder="horas" id="horaLY2"></td>
                                                </tr>
                                                @else
                                                <tr>
                                                    <td></td>
                                                    <td><input class="input-dt text-left" type="text" readonly
                                                            value="YANKEE 1" placeholder="maquina" id="1"></td>
                                                    <td><input class="input-dt text-left" type="text"
                                                            value="{{ $op->horaJY1 }}" placeholder="horas" id="horaJY1">
                                                    </td>
                                                    <td><input class="input-dt text-left" type="text"
                                                            value="{{ $op->horaLY1 }}" placeholder="horas" id="horaLY1">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td><input class="input-dt text-left" type="text" readonly
                                                            value="YANKEE 2" placeholder="maquina" id="2"></td>
                                                    <td><input class="input-dt text-left" type="text"
                                                            value="{{ $op->horaJY2 }}" placeholder="horas" id="horaJY2">
                                                    </td>
                                                    <td><input class="input-dt text-left" type="text"
                                                            value="{{ $op->horaLY2 }}" placeholder="horas" id="horaLY2">
                                                    </td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <button class="btn btn-primary add-row-dt-hp float-right" id="btnguardar">
                                        Guardar
                                    </button>

                                </div>
                            </div>
                        </div>
                        <!-- [ Tabla Categorias ] end -->
                    </div>
                    <div class="row">
                        <!-- [ Tabla Categorias ] start -->
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>OBSERVACIONES</h5>
                                </div>
                                <div class="card-block table-border-style">
                                    <form method="post" action="{{ url('costo-orden/add-comment')}}">
                                        {{ csrf_field() }}
                                        @foreach ($ordenes as $key => $opc)
                                        <input class="input-dt text-left" type="hidden" name="Orden" id="Orden"
                                            value="{{ $op->numOrden }}">
                                        <div class="row">
                                            <div class="col-md-12">
                                                @if(is_null($opc->comentario))
                                                <div class="form-group">
                                                    <textarea class="form-control" placeholder="Ingrese su comentario"
                                                        name="comentario" id="comentario" rows="4"></textarea>
                                                </div>
                                                @else
                                                <div class="form-group">
                                                    <textarea class="form-control" placeholder="Ingrese su comentario"
                                                        name="comentario" id="comentario"
                                                        rows="4">{{ $opc->comentario }}</textarea>
                                                </div>
                                            </div>
                                            @endif
                                            <button class="btn btn-primary add-row-dt-hp float-right"
                                                id="btnguardar-comment" type="submit">
                                                Guardar
                                            </button>
                                        </div>
                                        @endforeach
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- [ Tabla Categorias ] end -->
                    </div>
                </div>
                <!-- Modal para el tipo de cambio-->
                <div class="modal" tabindex="-1" role="dialog" id="modaltc">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title align-self-center">Tasa de Cambio</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h4 class=" text-center text-danger mb-0" >C$<span aria-hidden="true" id="tasaCambio"> 0.0000 </span></h4>
                                <div class="form-group">
                                    <label for="fechatc">Fecha</label>
                                        <input type="text" class="input-fecha form-control" name="fechatc" id="fechatc">
                                    <small id="fechatcHelp" class="form-text text-muted">Elija la fecha correcta</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="btnguardarTC" type="button" class="btn btn-primary">Aplicar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal para el tipo de cambio-->
            </div>
        </div>
    </div>
</div>

<!-- [ Main Content ] end -->
@endsection

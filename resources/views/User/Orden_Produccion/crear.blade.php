@extends('layouts.main')
@section('metodosjs')
@include('jsViews.js_ordenproduccion')

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
                                    <h5 class="m-b-10">Nueva Orden de Producción</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="{{url('/orden-produccion')}}">Ordenes
                                            Produccion</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:">Nueva</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Nueva Orden</h5>
                                        <button class="btn btn-primary float-right" id="btnguardar">Guardar</button>
                                    </div>
                                    @if(session()->has('message-success'))
                                    <div class="alert alert-success">
                                        {{ session()->get('message-success') }}
                                    </div>
                                    @endif
                                    @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <p>Corrige los siguientes errores:</p>
                                        <ul>
                                            @foreach ($errors->all() as $message)
                                            <li>{{ $message }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="card-body">
                                        <h5>Generales</h5>
                                        <hr>
                                        <form method="post" action="{{url('orden-produccion/guardar')}}" id="formdataord">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="numOrden">Orden de Producción No.</label>
                                                        <input type="text" readonly class="form-control" name="numOrden" id="numOrden" value="{{ $idOrd['numOrden']+1 }}">
                                                        <small id="numordenHelp" class="form-text text-muted">Escriba
                                                            el No. de Orden de Producción</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="producto">Producto</label>
                                                        <select class="form-control" name="producto" id="producto">
                                                            @foreach($productos as $p)
                                                            <option value="{{ $p['idProducto'] }}">{{ $p['nombre'] }}</option>
                                                            @endforeach
                                                        </select>
                                                        <small id="productoHelp" class="form-text text-muted">Seleccione
                                                            un Producto</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="jefe">Jefe de Turno</label>
                                                        <select class="form-control" name="jefe" id="jefe">
                                                            @foreach($usuarios as $u)
                                                            <option value="{{ $u['id'] }}">{{ $u['nombres'] }} {{ $u['apellidos'] }}</option>
                                                            @endforeach
                                                        </select>
                                                        <small id="grupoHelp" class="form-text text-muted">Seleccione
                                                            un Grupo</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="numOrden">Horas Trabajadas</label>
                                                        <input type="text" class="form-control" name="hrsTrabajadas" id="hrsTrabajadas" value="{{ old('hrsTrabajadas') }}" onpaste="return false">
                                                        <small id="hrsTrabajadasHelp" class="form-text text-muted">Especifique
                                                            las hras trabajadas</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <h5 class="mt-3">Horarios</h5>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="fecha01">Fecha Inicia</label>
                                                        <input type="text" class="input-fecha form-control" name="fecha01" id="fecha01">
                                                        <small id="fecha01Help" class="form-text text-muted">Indique
                                                            la fecha en que inicia</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="fecha02">Fecha Finaliza</label>
                                                        <input type="text" class="input-fecha form-control" name="fecha02" id="fecha02">
                                                        <small id="fecha02Help" class="form-text text-muted">Indique
                                                            la fecha en que finaliza</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="hora01">Hora Inicia</label>
                                                        <input type="text" required class="datetimepicker_ form-control" name="hora01" id="hora01" value="{{ old('hora01') }}">
                                                        <small id="hora01Help" class="form-text text-muted">Especifique
                                                            la hora que inicia</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="hora02">Hora Finaliza</label>
                                                        <input type="text" class="datetimepicker_ form-control" name="hora02" id="hora02" value="{{ old('hora02') }}">
                                                        <small id="hora02Help" class="form-text text-muted">Especifique
                                                            la hora que finaliza</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row mt-3">
                                        <!-- [ Tabla Materia Prima Directa ] start -->
                                        <div class="col-xl-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Materia Prima Directa (M.P.)</h5>
                                                </div>
                                                <div class="card-block table-border-style">
                                                    <div class="table-responsive">
                                                        <table class="table" id="dtMPD" cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>MAQUINA</th>
                                                                    <th>DESCRIPCION</th>
                                                                    <th class="text-center">CANTIDAD</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tbody-mp">
                                                                @foreach($mp_directa as $key => $mp)
                                                                <tr id="{{ $key }}">
                                                                    <input type="hidden" id="id-mp" value="{{$mp->id}}">
                                                                    <td></td>
                                                                    <td><select disabled class="mb-3 form-control " id="maquina-prev-{{ $key }}">
                                                                            <option  selected value="{{ $mp->idFibra }}">{{ $mp->nombre }}</option>
                                                                        </select></td>
                                                                    <td><select disabled class="mb-3 form-control" id="fibras-prev-{{ $key }}">
                                                                            <option  selected value="{{ $mp->idMaquina }}">{{ $mp->descripcion}}</option>
                                                                        </select></td>
                                                                    <td><input class="input-dt mp-cant" type="text" placeholder="" id="cantidad-prev-{{ $key }}" onpaste="return false" value="{{ $mp->cantidad}}"></td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <button class="btn btn-danger float-right" id="quitRowdtBATH">
                                                        Quitar
                                                    </button>
                                                    <button class="btn btn-light add-row-dt-mp float-right" id="btn-agregar">
                                                        Agregar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- [ Tabla Materia Prima Directa ] end -->
                                    </div>
                                    <div class="row mt-3">
                                        <!-- [ Tabla Quimicos por Maquina ] start -->
                                        <div class="col-xl-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Quimicos por Maquina</h5>
                                                </div>
                                                <div class="card-block table-border-style">
                                                    <div class="table-responsive">
                                                        <table class="table" id="dtQM" cellspacing="0" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>MAQUINA</th>
                                                                <th>QUIMICO</th>
                                                                <th class="text-center">CANTIDAD</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="tbody-qm">
                                                            @foreach($quimico_maquina as $key => $qm)
                                                                <tr>
                                                                    <td></td>
                                                                    <td><select disabled class="mb-3 form-control " id="maquinaq-prev-{{ $key }}">
                                                                            <option  selected value="{{ $qm->idQuimico }}">{{ $qm->nombre }}</option>
                                                                        </select></td>
                                                                    <td><select disabled class="mb-3 form-control" id="quimicos-prev-{{ $key }}">
                                                                            <option  selected value="{{ $qm->idMaquina }}">{{ $qm->descripcion}}</option>
                                                                        </select></td>
                                                                    <td><input class="input-dt qm-cant" type="text" placeholder="" id="cantidadq-prev-{{ $key }}" onpaste="return false" value="{{ $qm->cantidad}}"></td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <button class="btn btn-danger float-right" id="quitRowdtBATHQ">
                                                        Quitar
                                                    </button>
                                                    <button class="btn btn-light add-row-dt-qm float-right" id="btn-agregarQ">
                                                        Agregar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- [ Tabla Quimicos por Maquina ] end -->
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

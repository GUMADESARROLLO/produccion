@extends('layouts.main')
@section('metodosjs')
  @include('User.Orden_Produccion.js_editarORD')
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
                                    <h5 class="m-b-10">Editar Orden Producción</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="{{url('/orden-produccion')}}">Orden Producción</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:">Editar</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <!-- [ Tabla Categorias ] start -->
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Editar Orden</h5>
                                        <button class="btn btn-danger float-right" id="btnactualizar">Actualizar</button>
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
                                        <form method="post" action="{{url('orden-produccion/actualizar')}}" id="formdataord">
                                            {{ csrf_field() }}
                                            @foreach ( $orden as $key => $ord )
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="numOrden">Orden de Producción No.</label>
                                                        <input type="text" readonly class="form-control" name="numOrden" id="numOrden" value="{{ $ord->numOrden }}">
                                                        <small id="numordenHelp" class="form-text text-muted">Escriba el No. de Orden de Producción</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="producto">Producto</label>
                                                        <select class="form-control" name="producto" id="producto">
                                                        @foreach($productos as $key => $prod)
                                                        @if ( $prod->idProducto==$ord->producto )
                                                        <option value="{{ $prod->idProducto }}" selected>{{ $prod->nombre }}</option>
                                                        @else
                                                        <option value="{{ $prod->idProducto }}">{{ $prod->nombre }}</option>option>
                                                        @endif                                                        
                                                        @endforeach
                                                        </select>
                                                        <small id="productoHelp" class="form-text text-muted">Seleccione un Producto</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="jefe">Jefe de Turno</label>
                                                        <select class="form-control" name="jefe" id="jefe">
                                                        @foreach($usuarios as $key)
                                                        @if ( $key['id']==$ord->idUsuario )
                                                        <option value="{{ $key['id'] }}" selected>{{ $key['nombres'] }} {{ $key['apellidos'] }}</option>
                                                        @else
                                                        <option value="{{ $key['id'] }}">{{ $key['nombres'] }} {{ $key['apellidos'] }}</option>
                                                        @endif
                                                        @endforeach
                                                        </select>
                                                        <small id="grupoHelp" class="form-text text-muted">Seleccione un Grupo</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="numOrden">Horas Trabajadas</label>
                                                        <input type="text" class="form-control" name="hrsTrabajadas" id="hrsTrabajadas" value="{{ $ord->hrsTrabajadas }}">
                                                        <small id="hrsTrabajadasHelp" class="form-text text-muted">Especifique las hras trabajadas</small>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach

                                            <h5 class="mt-3">Horarios</h5>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="fecha01">Fecha Inicia</label>
                                                        <input type="text" class="input-fecha form-control" value="{{ $ord->fechaInicio }}" name="fecha01" id="fecha01">
                                                        <small id="fecha01Help" class="form-text text-muted">Indique la fecha en que inicia</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="fecha02">Fecha Finaliza</label>
                                                        <input type="text" class="input-fecha form-control" value="{{ $ord->fechaFinal }}" name="fecha02" id="fecha02">
                                                        <small id="fecha02Help" class="form-text text-muted">Indique la fecha en que finaliza</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="hora01">Hora Inicia</label>
                                                        <input type="text" required class="datetimepicker_ form-control" name="hora01" id="hora01" value="{{ $ord->horaInicio }}">
                                                        <small id="hora01Help" class="form-text text-muted">Especifique la hora que inicia</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                     <div class="form-group">
                                                        <label for="hora02">Hora Finaliza</label>
                                                        <input type="text" class="datetimepicker_ form-control" name="hora02" id="hora02" value="{{ $ord->horaFinal }}">
                                                        <small id="hora02Help" class="form-text text-muted">Especifique la hora que finaliza</small>
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
                                                            <tbody>
                                                            @if( count($mp_directa)>0 )
                                                                @foreach( $mp_directa as $key => $mp )
                                                                <tr>
                                                                    <td>{{ $mp->id }}</td>
                                                                    <td>
                                                                    <select class="mb-3 form-control" id="maquina-{{ $mp->id }}">
                                                                    @foreach( $maquinas as $key => $m )
                                                                    @if( $m->idMaquina == $mp->idMaquina )
                                                                    <option value="{{ $m->idMaquina }}" selected>{{ $m->nombre }}</option>
                                                                    @else
                                                                    <option value="{{ $m->idMaquina }}">{{ $m->nombre }}</option>
                                                                    @endif
                                                                    @endforeach
                                                                    </select>
                                                                    </td>
                                                                    <td>
                                                                    <select class="mb-3 form-control" id="fibras-{{ $mp->id }}">
                                                                    @foreach( $fibras as $key => $f )
                                                                    @if( $f->idFibra == $mp->idFibra )
                                                                    <option value="{{ $f->idFibra }}" selected>{{ $f->descripcion }}</option>
                                                                    @else
                                                                    <option value="{{ $f->idFibra }}">{{ $f->descripcion }}</option>
                                                                    @endif
                                                                    @endforeach
                                                                    </select>
                                                                    </td>
                                                                    <td><input class="input-dt" id="cantidad-{{ $mp->id }}" type="number" placeholder="Ingrese la cantidad" value="{{ $mp->cantidad }}"></td>
                                                                </tr>
                                                                @endforeach

                                                            @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <button class="btn btn-danger float-right" id="quitRowdtMP">Quitar</button>
                                                    <button class="btn btn-light add-row-dt-mp float-right">Agregar</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- [ Tabla Materia Prima Directa ] end -->
                                    </div>
                                </div>
                            </div>
                            <!-- [ Tabla Categorias ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->
@endsection
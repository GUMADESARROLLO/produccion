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
                                    <h5 class="m-b-10">Editar Fibra</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <!--<li class="breadcrumb-item"><a href="home"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{url('/home')}}">Inicio</a></li>-->
                                    <li class="breadcrumb-item"><a href="{{url('/quimicos')}}">Quimicos</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:">Editar Quimico</a></li>
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
                                        <h5>Edite el químico</h5>
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
                                    <div class="card-block">
                                        <form method="post" action="{{url('quimico/actualizar-quimico')}}">
                                            {{ csrf_field() }}
                                            @foreach ($quimico ?? '' as $q)
                                            <div class="row">
                                                <div class="col-md-3" hidden>
                                                    <div class="form-group">
                                                        <label for="idQuimico">ID del Químico</label>
                                                        <input type="text" readonly class="form-control" name="idQuimico" id="idQuimico" value="{{ $q['idQuimico']}}">
                                                        <small id="idFibraHelp" class="form-text text-muted">ID del quimico</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="codigo">Código del Químico</label>
                                                        <input type="text"  class="form-control" name="codigo" id="codigo" value="{{ $q['codigo']}}">
                                                        <small id="codigoHelp" class="form-text text-muted">Codigo del quimico</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="descripcion">Nombre del Químico</label>
                                                        <input type="text" class="form-control text-uppercase" name="descripcion" id="descripcion" value="{{$q['descripcion']}}">
                                                        <small id="nombreHelp" class="form-text text-muted">Escriba el nuevo nombre del químico</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="unidad">Unidad del Químico</label>
                                                        <input type="text" class="form-control text-uppercase" name="unidad" id="unidad" value="{{$q['unidad']}}">
                                                        <small id="unidadHelp" class="form-text text-muted">Escriba el nuevo nombre del químico</small>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            <button type="submit" class="btn btn-primary">Enviar</button>
                                        </form>
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
<!-- [ Main Content ] end  -->
@endsection

@extends('layouts.main')

@section('metodosjs')
    @include('jsViews.js_usuario')
@endsection
@section('content')
<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->
                <!-- [ breadcrumb ] start -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <!-- [ Tabla Categorias ] start -->
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header border-secondary">
                                        <h5><b>USUARIOS</b></h5>
                                        <a href="{{url('user/nuevo')}}"><i class="float-right fa fa-plus-circle" style="font-size:20px; color:purple"></i></a>
                                    </div>
                                    <div class="{{ $message['tipo'] }}">{{ $message['mensaje'] }}</div>
                                    <div class="card-body col-sm-12 p-0 mb-2">	
                                        <div class="p-0 px-car">
                                            <div class="flex-between-center scrollbar border border-1 border-300 rounded-2">
                                                <table class="table table-striped table-bordered table-sm mt-3 fs--1" id="tbl_usuario">
                                                    <thead>
                                                        <tr class="text-light text-center" style="background-color: purple;">
                                                            <th width="140px">COD. USUARIO</th>
                                                            <th>NOMBRES</th>
                                                            <th>APELLIDOS</th>
                                                            <th>USERNAME</th>
                                                            <th width="140px">ACCIONES</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($user as $user)
                                                        <tr class="unread">
                                                            <td class="text-center">{{ $user['id'] }}</td>
                                                            <td>{{ $user['nombres'] }}</td>
                                                            <td>{{ $user['apellidos'] }}</td>
                                                            <td>{{ $user['username'] }}</td>
                                                            <td class="text-center">
                                                                <a href="user/detalle/{{ $user['id']}}"><i class="fa fa-eye text-c-green f-20 m-r-10"></i></a>
                                                                <a href="user/edit/{{ $user['id']}}"><i class="far fa-edit text-c-blue f-20 m-r-10"></i></a>
                                                                @if ( $user->estado )
                                                            <!-- <a href="#!" onclick="deleteUser({{ $user['id'] }})"><i class="feather icon-x-circle text-c-red f-30 m-r-10"></i></a> -->
                                                            <a href="#!" onclick="deleteUser({{ $user['id'] }})"><i class="fas fa-toggle-on text-c-success f-20 m-r-10"></i></a>
                                                                @endif
                                                                @if ( $user->estado == 0)
                                                                    <a href="#!" onclick="activeUser({{ $user['id'] }})" ><i class="fas fa-toggle-on text-c-red f-20 m-r-10"></i></a>
                                                                @endif
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
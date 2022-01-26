@extends('layouts.main')
@section('metodosjs')

@endsection
@section('content')
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">

                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>LISTA DE REQUISAS</h5>
                                        </div>
                                        <div class="card-block table-border-style">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th># Orden</th>
                                                            <th>Producto</th>
                                                            <th>Fecha Inicio</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach ($requisas as $key)
                                                        <tr class="unread">

                                                            <td class="dt-center">
                                                                <h6>{{ $key['numOrden'] }}</h6>
                                                            </td>
                                                            <td class="dt-center">
                                                                <h6>{{ $key['codigo_req'] }}</h6>
                                                            </td>
                                                            <td class="dt-center">
                                                                <h6>{{ $key['jefe_turno'] }}</h6>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- [ Tabla ] end -->
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection

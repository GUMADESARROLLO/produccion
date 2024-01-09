@extends('layouts.main')
@section('metodosjs')
@include('jsViews.js_logAccess')
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
                                <div class="card card-bordered border-left-warning">
                                    <div class="card-header border-secondary">
                                        <h5><b>Logs de Accessos</b></h5>
                                    </div>
                                    <div class="input-group " id="cont_search" >
                                    
                                     
                                        <input type="text" id="InputBuscar" class="form-control bg-white mt-2" placeholder="Buscar..." aria-label="Username" aria-describedby="basic-addon1">
                                        <div class="form-row ">
                                            
                                            <div class="form-group col-md-3 ml-5 mt-2">
                                                <div class="input-group ">   
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i class="material-icons text-black">event</i></div>
                                                    </div>                            
                                                    <input type="text" class="input-fecha form-control" id="fecha_hora_inicial">
                                                </div>
                                            </div>

                                           
                                            <div class="form-group col-md-5 mt-2">
                                                <div class="input-group "> 
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><i class="material-icons text-black">event</i></div>
                                                    </div>                                            
                                                    <input type="text" class="input-fecha form-control" id="fecha_hora_final">                                            
                                                </div>
                                            </div>
                                            
                                            <div class="form-group col-md-1 mt-2 " > 
                                                <div class="input-group-prepend" id="id_search">
                                                    <div class="input-group-text "><i class="material-icons text-black">search</i></div>
                                                </div> 
                                            </div>
                                            <div class="form-group col-md-2 mt-2">
                                                <div class="input-group">
                                                    <select class="custom-select" id="frm_lab_row" name="frm_lab_row">
                                                        <option value="5" selected>5</option>
                                                        <option value="10">1</option>
                                                        <option value="20">2</option>
                                                        <option value="-1">Todos</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="card-body col-sm-12 p-0">	
                                        <div class="p-0 px-car">
                                            <div class="flex-between-center scrollbar border border-1 border-300 rounded-2">
                                                <table class="table table-striped table-bordered table-sm  fs--1" id="tblProductos">
                                                    <thead>
                                                        <tr class="text-light text-center" style="background-color: purple;">
                                                            <th width="100px">CODIGO</th>
                                                            <th>USUARIO</th>
                                                            <th>MOD. ACCESS</th>
                                                            <th width="100px">VISITAS</th>
                                                        </tr>
                                                    </thead>
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
<!-- [ Main Content ] end -->
@endsection

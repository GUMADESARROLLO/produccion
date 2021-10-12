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
                                
                                <!-- [ Tiempo de Pulpeo ] start -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="card card-event">
                                        <div class="card-block border-bottom">
                                            <div class="row align-items-center justify-content-center">
                                                <div class="col">
                                                    <h5 class="m-0">Tiempo de Pulpeo</h5>
                                                </div>
                                                <div class="col-auto">
                                                    <label class="label theme-bg2 text-white f-14 f-w-400 float-right">45</label>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="card-block table-border-style">
                                            <h6 class="text-uppercase text-center">No. de Bachadas en el pulper</h6>
                                            <div class="table-responsive">
                                                <table class="table table-hover" id="dtFibras">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>FECHA</th>
                                                            <th>DIA</th>
                                                            <th>NOCHE</th>                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>                                                        
                                                        <tr class="unread">
                                                            <td class="dt-center"></td>
                                                            <td class="dt-left"></td>
                                                            <td class="dt-center"></td>
                                                        </tr>                                                        
                                                    </tbody>
                                                </table>
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
                                                <div class="col">
                                                    <h5 class="m-0">Tiempo de Lavado</h5>
                                                </div>
                                                <div class="col-auto">
                                                    <label class="label theme-bg2 text-white f-14 f-w-400 float-right">45</label>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="card-block table-border-style">
                                            <h6 class="text-uppercase text-center">No. de Batch en el lavadora Tetrapack</h6>
                                            <div class="table-responsive">
                                                <table class="table table-hover" id="dtFibras">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>FECHA</th>
                                                            <th>DIA</th>
                                                            <th>NOCHE</th>                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>                                                        
                                                        <tr class="unread">
                                                            <td class="dt-center"></td>
                                                            <td class="dt-left"></td>
                                                            <td class="dt-center"></td>
                                                        </tr>                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- [ Tiempo de Lavado ] end -->

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

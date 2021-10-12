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
                        <div class="row">
                            
                            <!-- [ Comportamiento de ventas Chart ] start -->
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Admin</h5>
                                    </div>
                                    <div class="card-block">
                                        <div id="morris-bar-chart" style="height:300px"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Comportamiento de ventas Chart ] end -->
                        
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->
@endsection

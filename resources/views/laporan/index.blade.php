@extends('layouts.app')

@section('content')
<div class="container">  
          <!--overview start-->
            <div class="row">
              <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-file-text "></i> Laporan</h3>
              </div>
            </div>
                  
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <div class="info-box red-bg" align="center">
                    <a href="{{ url('laporan/bulanan')}}"><img src="img/bulanan.png"  width="150" height="150" class="img-responsive"></a>
                    <h3>KEUANGAN BULANAN</h3>           
                  </div><!--/.info-box-->     
                </div><!--/.col-->
                
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <div class="info-box green-bg" align="center">
                    <a href="{{ url('laporan/labarugi')}}"><img src="img/labarugi.png"  width="150" height="150" class="img-responsive"></a>
                    <h3>LABA-RUGI</h3>            
                  </div><!--/.info-box-->     
                </div><!--/.col-->  

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <div class="info-box blue-bg" align="center">
                    <a href="{{ url('laporan/tahunan')}}"><img src="img/tahunan.png"  width="150" height="150" class="img-responsive"></a>
                    <h3>LAPORAN TAHUNAN</h3>            
                  </div><!--/.info-box-->     
                </div><!--/.col-->
            </div>         
           
</div>  
@endsection

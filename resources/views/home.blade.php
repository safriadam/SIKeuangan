@extends('layouts.app')

@section('content')
<div class="container">  
          <!--overview start-->
            <div class="row">
              <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-laptop"></i> Dashboard</h3>
                  <ol class="breadcrumb">
                    <li><i class="fa fa-laptop"></i><a href="{{ url('/')}}"></i>Dashboard</li>                
                  </ol>
              </div>
            </div>
                  
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <div class="info-box blue-bg" align="center">
                    <a href="{{ url('anggaran')}}"><img src="img/anggaran.png"  width="120" height="120" class="img-responsive"></a>
                    <h3>ANGGARAN</h3>           
                  </div><!--/.info-box-->     
                </div><!--/.col-->
                
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <div class="info-box brown-bg" align="center">
                    <a href="{{ url('pengeluaran')}}"><img src="img/realisasi.png"  width="120" height="120" class="img-responsive"></a>
                    <h3>REALISASI</h3>            
                  </div><!--/.info-box-->     
                </div><!--/.col-->  
                
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <div class="info-box dark-bg" align="center">
                    <a href="{{ url('pemasukan')}}"><img src="img/pemasukan.png"  width="120" height="120" class="img-responsive"></a>
                    <h3>PEMASUKAN</h3>            
                  </div><!--/.info-box-->     
                </div><!--/.col-->
                
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <div class="info-box yellow-bg" align="center">
                    <a href="{{ url('laporan')}}"><img src="img/laporan.png"  width="120" height="120" class="img-responsive"></a>
                    <h3>LAPORAN</h3>           
                  </div><!--/.info-box-->     
                </div><!--/.col-->

                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <div class="info-box green-bg" align="center">
                    <a href="{{ url('laporan')}}"><img src="img/sayuran.png"  width="120" height="120" class="img-responsive"></a>
                    <h3>SAYURAN</h3>           
                  </div><!--/.info-box-->     
                </div><!--/.col-->
            </div>         
           
</div>  
@endsection

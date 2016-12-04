@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>LAPORAN</h2></div>

                <div class="panel-body">
                    <div class='container'>
                        <div class="col-sm-2 " align="center">
                          <a href="{{ url('laporan/labarugi') }}"><img src="img/labarugi.png"  width="100" height="100" class="img-responsive" alt="Generic placeholder thumbnail">
                          <h4 >LABA-RUGI</h4>
                        </div>
                        <div class="col-sm-2 " align="center">
                          <a href="{{ url('laporan/bulanan')}}"><img src="img/bulanan.png" width="100" height="100" class="img-responsive" alt="Generic placeholder thumbnail">
                          <h4>BULANAN</h4>      
                        </div>
                        <div class="col-sm-2 " align="center">
                          <a href="{{ url('laporan/harga')}}"><img src="img/cost.png" width="100" height="100" class="img-responsive" alt="Generic placeholder thumbnail">
                          <h4>HARGA POKOK</h4>      
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop
@extends('layouts.app')
@section('content')


<div class="container">
		<div class="row">
              <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-money" aria-hidden="true"></i>Laporan Keuangan Tahunan</h3>
              </div>
        </div>
		<div class="col-lg-1">
			<h4>Periode: </h4> 
		</div>
		<div class="col-lg-2">
				{!! Form::open(array('url'=>'laporan/tahunan/tahun')) !!}
				{!! Form::selectRange('year',2015, date('Y'), $y ,['class' => 'field input-sm']) !!}
				{!! form::submit('Tampilkan',['class'=>'btn btn-info btn-sm']) !!}
				{!! form::close() !!}
		</div>
</div>

<div class="container">
	<hr>
	<table class="table table-bordered">
		<tr>
			<th>No</th>
			<th>Periode</th>
			<th>Pemasukan</th>
			<th>Pengeluaran</th>
		</tr>
		<?php
			 $nomor = 1;
			 ?>

		@for($no=0; $no<=11; $no++)
		<tr>
		<td width="50px" align="center">{{ $nomor++ }}</td>
		<td width="200px">{{ $monthName[$no] }}</td>
		<td width="140px">{{ number_format($pemasukan[$no]) }}</td>
		<td width="140px">{{ number_format($pengeluaran[$no]) }}</td>
		</tr>
		@endfor
		<tr><th colspan="2">Saldo Akhir :</th><th colspan="2">{{number_format($saldomt->saldo)}}</th></tr>
		
	</table>
			
			
</div>


@stop
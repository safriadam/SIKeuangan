@extends('layouts.app')
@section('content')

<head><link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css"></head>
<div class="container">
	<div class="container">
		<div class="col-sm-4">
			<h4>Saldo saat ini:</h4> <!-- untuk pilih periode  -->
			<tr><td>{!! Form::text('saldo', number_format($saldo->saldo) ,['class'=>'form-control','readonly']) !!}</td></tr>
		</div>
	</div>
	<div>
		<div class="container">
			<div class= "col-sm-3" >
				<h4>Laporan Bulanan Periode : </h4> <!-- untuk pilih periode  -->
				{!! Form::open(array('url'=>'laporan/bulanan/tahunBulan')) !!}
				{!! Form::selectRange('year',2015, date('Y'), $y ,['class' => 'field']) !!}
				{!! Form::selectMonth('month', $m ,['class' => 'field'] ) !!}
				{!! form::submit('Tampilkan',['class'=>'btn btn-info btn-sm']) !!}
				{!! form::close() !!}
			</div>
			<div class= "col-sm-5" >
			<h4>Cetak laporan Bulanan Periode: </h4> <!-- untuk pilih periode  -->
					{!! Form::open(array('url'=>'laporan/bulanan/bulananpdf')) !!}
					{!! Form::selectRange('year',2015, date('Y'), $y ,['class' => 'field']) !!}
					{!! Form::selectMonth('month', $m ,['class' => 'field'] ) !!}
					{!! form::submit('Cetak PDF',['class'=>'btn btn-info btn-sm']) !!}
					{!! form::close() !!}
			</div>
		</div>
	</div>
<hr>
	
	<table class="table table-bordered">
		<tr>
			<th>no</th>
			<th>Tanggal Transaksi</th>
			<th>Deskripsi</th>
			<th>Pemasukan</th>
			<th>Pengeluaran</th>
			<th>Saldo</th>
		</tr>
			<?php $no = 1; ?>
			@foreach ( $transaksi as $n)
		<tr>
			<td width="50px" align="center">{{ $no++ }} </td>
			<td width="200px">{{ $n->created_at->format('d-m-Y') }}</td>
			<td>{{ $n->deskripsi }}</td>
			<td width="150px">{{ number_format($n->pemasukan) }}</td>
			<td width="100px">{{ number_format($n->pengeluaran) }}</td>
			<td width="100px">{{ number_format($n->saldo) }}</td>
		
	 	</tr>
		

		@endforeach
	
	</table>
{!! $transaksi->render() !!}
</div>



@stop
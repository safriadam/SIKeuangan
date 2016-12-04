@extends('layouts.app')
@section('content')

<head><link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css"></head>
<div class="container">
	<div style="border:1px solid #CFD7DF;">
		<div class="container">
			<div class= "col-sm-4" >
				<h4>Laporan Laba-Rugi Periode: </h4> <!-- untuk pilih periode  -->
				{!! Form::open(array('url'=>'laporan/labarugi/labarugiBulanan')) !!}
				{!! Form::selectRange('year',2015, date('Y'), $y ,['class' => 'field']) !!}
				{!! Form::selectMonth('month', $m ,['class' => 'field'] ) !!}
				{!! form::submit('Tampilkan',['class'=>'btn btn-info btn-sm']) !!}
				{!! form::close() !!}
			</div>
			<div class= "col-sm-5" >
			<h4>Cetak Laba-Rugi Periode: </h4> <!-- untuk pilih periode  -->
					{!! Form::open(array('url'=>'laporan/labarugi/labarugipdf')) !!}
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
		</tr>
			<?php $no = 1; ?>
			@foreach ( $laba_rugi as $n)
		<tr>
			<td width="50px" align="center">{{ $no++ }} </td>
			<td>{{ $n->created_at->format('d-m-Y')}}</td>
			<td>{{ $n->deskripsi }}</td>
			<td>{{ number_format($n->pemasukan) }}</td>
			<td>{{ number_format($n->pengeluaran) }}</td>
	 	</tr>
			@endforeach
	</table>

	<h4>Laba-Rugi :</h4>
		{!! form::text('labarugi',number_format($labarugi),['class'=>'form-control','placeholder'=>'','readonly'])!!}
		<br>
</div>



@stop
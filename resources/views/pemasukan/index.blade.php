@extends('layouts.app')
@section('content')


<div class="container">
	<div>
		<div class="container">
			<div class="col-sm-4">
				<h4>Saldo saat ini:</h4> <!-- untuk pilih periode  -->
				<tr><td>{!! Form::text('saldo', number_format($saldo->saldo) ,['class'=>'form-control']) !!}</td></tr>
			</div>
		</div>
		<div>
		<div class="container">
			<div class= "col-sm-4" >
				<h4>Pemasukan Periode: </h4> <!-- untuk pilih periode  -->
				{!! Form::open(array('url'=>'pemasukan/tahunBulan')) !!}
				{!! Form::selectRange('year',2015, date('Y'), $y ,['class' => 'field']) !!}
				{!! Form::selectMonth('month', $m ,['class' => 'field'] ) !!}
				{!! form::submit('Tampilkan',['class'=>'btn btn-info btn-sm']) !!}
				{!! form::close() !!}
			</div>
			<div class= "col-sm-4" >
			<h4>Cetak Pemasukan Periode: </h4> <!-- untuk pilih periode  -->
					{!! Form::open(array('url'=>'pemasukan/pdf')) !!}
					{!! Form::selectRange('year',2015, date('Y'), $y ,['class' => 'field']) !!}
					{!! Form::selectMonth('month', $m ,['class' => 'field'] ) !!}
					{!! form::submit('Cetak PDF',['class'=>'btn btn-info btn-sm']) !!}
					{!! form::close() !!}
			</div>
		</div>
		</div>
	</div>
	<div>
		<hr>
		{!! link_to('pemasukan/create','Tambah Pemasukan',['class'=>'btn btn-danger btn-md']) !!}
		<hr>
	</div>

<table class="table table-bordered">
	
	<tr><th>No</th><th>Tanggal Transaksi</th><th>Deskripsi</th><th>Pemasukan</th><th>Jenis Pemasukan</th><!-- <th colspan="2">Aksi</th> --></tr>
	<?php $no = 1; ?>
	@foreach ( $pemasukan as $n)
	<tr>
	<td width="50px" align="center">{{ $no++ }}</td>
	<td width="140px">{{ $n->created_at->format('d-m-Y') }}</td>
	<td width="500px">{{ $n->deskripsi }}</td>
	<td width="140px">{{ number_format($n->pemasukan) }}</td>
	<td width="150px">{{ $n->jenis_pema }}</td>

	<!-- <td width="50px">{!! link_to('pemasukan/'.$n->id.'/edit','Edit',['class'=>'btn btn-warning btn-sm']) !!}
	<td>
		{!! Form::open(array('method'=>'delete','url'=>'pemasukan/'.$n->id))!!}
		{!! Form::hidden('_delete','DELETE')!!}
		{!! Form::submit('Hapus',['class'=>'btn btn-danger btn-sm'])!!}
		{!! Form::close()!!}
	</td> -->
		
		<!-- fitur edit dan delete diatas di matikan karena alasan integritas data keuangan -->

	</td> </tr>
	

	@endforeach
	
</table>
{!! $pemasukan->render() !!}

<h4>Total :</h4>
		{!! form::text('total',number_format($total),['class'=>'form-control','placeholder'=>'','readonly'])!!}
		<br>
</div>


@stop
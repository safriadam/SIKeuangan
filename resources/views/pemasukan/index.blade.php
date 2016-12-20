@extends('layouts.app')
@section('content')


<div class="container">
	<div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i>Pemasukan</h3>
          </div>
    </div>
	<div class="col-sm-3">
			<h4>Saldo saat ini:</h4>
			<tr><td>{!! Form::text('saldo', number_format($saldo->saldo) ,['class'=>'form-control']) !!}</td></tr>
	</div>
	<div class= "col-sm-4" >
			<h4>Pemasukan Masa Tanam: </h4> <!-- untuk pilih periode masa tanam  -->
			{!! Form::open(array('url'=>'pemasukan/tahunBulan')) !!}
			{!! Form::selectRange('year',2015, date('Y'), $y ,['class' => 'field input-sm']) !!}
			{{ Form::select('masaTanam', [
							   '1' => 'Januari - Maret',
							   '2' => 'Februari - April',
							   '3' => 'Maret - Mei',
							   '4' => 'April - Juni',
							   '5' => 'Mei - Juli',
							   '6' => 'Juni - Agustus',
							   '7' => 'Juli - September',
							   '8' => 'Agustus - Oktober',
							   '9' => 'September - November',
							   '10' => 'Oktober - Desember',
							   '11' => 'November - Januari',
							   '12' => 'Desember - Februari'], $m, ['class' => 'field input-sm']
								) }}
			{!! form::submit('Tampilkan',['class'=>'btn btn-info btn-sm']) !!}
			{!! form::close() !!}
	</div>
	<div class= "col-sm-3" >
	<h4>Total Pemasukan : {{ $saldomt->masa_tanam->format('F') }}</h4>
		{!! form::text('total',number_format($total),['class'=>'form-control','placeholder'=>'','readonly'])!!}
		<br>
	</div>
	<div class="col-sm-2">
	<h4>Cetak Pemasukan</h4>
			<div class="btn-group">
				{!! Form::open(array('url'=>'pemasukan/pdf')) !!}
				{!! Form::hidden('year', $y) !!}
				{!! Form::hidden('month', $m) !!}
				{!! form::submit('Cetak PDF',['class'=>'btn btn-success btn-md']) !!}
				{!! form::close() !!}
			</div>
	</div>
	
</div>
		
<div class="container">
	<div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i>Pemasukan Hasil Penjualan</h3>
          </div>
    </div>

<table class="table table-bordered">
	
	<tr>
		<th>No</th>
		<th>Masa Tanam</th>
		<th>Nama Sayur</th>
		<th>Keterangan</th>
		<th>Pemasukan</th>
		<th>Aksi</th>
	</tr>
	<?php $no = 1; ?>
	@foreach ( $pemasukan as $n)

		@if ($n->jenis_pema == 'PENJUALAN')
			<tr>
				<td width="25px" align="center">{{ $no++ }}</td>
				<td width="200px">{{ $n->masa_tanam->format('F') }} - {{ $n->masa_tanam->modify('+2 month')->format('F') }}</td>
				<td width="160px">{{ $n->nama_sayur }}</td>
				<td width="500px">{{ $n->keterangan }}</td>
				<td width="180px">{{ number_format($n->pemasukan) }}</td>

			@if ($n->pemasukan) 
				<td width="50px"><button type="button" class="btn btn-success btn-sm disabled">Tambah Pemasukan</button></td>	
			@else
				<td width="50px">{!! link_to('pemasukan/'.$n->id.'/edit','Tambah Pemasukan',['class'=>'btn btn-success btn-sm']) !!}</td>
			@endif
			</tr>
		@else
		
		@endif

	@endforeach
	
</table>

	<div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i>Pemasukan Non-Penjualan</h3>
          </div>
    </div>

<table class="table table-bordered">
	<div>
		<hr>
		{!! link_to('pemasukan/create','Tambah Pemasukan',['class'=>'btn btn-danger btn-md']) !!}
		<hr>
	</div>
	<tr>
		<th>No</th>
		<th>Tanggal</th>
		<th>Jenis Pemasukan</th>
		<th>Keterangan</th>
		<th>Pemasukan</th>
	</tr>
	<?php $no = 1; ?>
	@foreach ( $pemasukan as $n)

	@if ($n->jenis_pema == 'PENJUALAN')

	@else
	<tr>
		<td width="50px" align="center">{{ $no++ }}</td>
		<td width="140px">{{ $n->masa_tanam->format('d-m-Y') }}</td>
		<td width="140px">{{ $n->jenis_pema }}</td>
		<td width="300px">{{ $n->keterangan }}</td>
		<td width="100px">{{ number_format($n->pemasukan) }}</td>
		
	</tr>
	@endif
	

	@endforeach
	
</table>
{!! $pemasukan->render() !!}


</div>


@stop
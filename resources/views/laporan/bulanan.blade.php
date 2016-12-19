@extends('layouts.app')
@section('content')

 

<div class="container">
		<div class="row">
              <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-money" aria-hidden="true"></i>Laporan Keuangan Bulanan</h3>
              </div>
        </div>
		<div class="col-sm-2">
			<h4>Saldo saat ini:</h4> 
			<tr><td>{!! Form::text('saldo', number_format($saldo->saldo) ,['class'=>'form-control']) !!}</td></tr>
		</div>
		<div class="col-sm-4">
			<h4>periode: </h4> <!-- untuk pilih periode masa tanam  -->
				{!! Form::open(array('url'=>'laporan/bulanan/tahunBulan')) !!}
				{!! Form::selectRange('year',2015, date('Y'), $y ,['class' => 'field input-sm']) !!}
				{!! Form::selectMonth('month', $m ,['class' => 'field input-sm'] ) !!}
				{!! form::submit('Tampilkan',['class'=>'btn btn-info btn-sm']) !!}
				{!! form::close() !!}
		</div>
		<div class="col-sm-3">
			<h4>Saldo Periode : {{ $saldomt->masa_tanam->format('F') }}</h4> 
			{!! Form::text('saldomt', number_format($saldomt->saldo) ,['class'=>'form-control']) !!}
				
		</div>
		<div class="col-sm-2">
		<h4>Cetak Laporan</h4>
			<div class="btn-group">
				{!! Form::open(array('url'=>'laporan/bulanan/bulananpdf')) !!}
				{!! Form::hidden('year', $y) !!}
				{!! Form::hidden('month', $m) !!}
				{!! form::submit('Cetak PDF',['class'=>'btn btn-success btn-md']) !!}
				{!! form::close() !!}
			</div>
		</div>
	
</div>
	
 	

<div class="container">
	<hr>
	<table class="table table-bordered">
		<tr>
			<th>No</th>
			<th>Tanggal Transaksi</th>
			<th>Deskripsi</th>
			<th>Pemasukan</th>
			<th>Pengeluaran</th>
			<th>Aksi</th>
		</tr>
		<?php $no = 1; ?>
		@foreach ( $transaksi as $n)
		<tr>
		<td width="50px" align="center">{{ $no++ }}</td>
		<td width="100px">{{ $n->tgl_transaksi->format('d-F-Y')}}</td> 
		<td width="250px">{{ $n->deskripsi }}</td>
		<td width="140px">{{ number_format($n->pemasukan) }}</td>
		<td width="140px">{{ number_format($n->pengeluaran) }}</td>

		@if ($n->pengeluaran)

				<td width="50px">{!! link_to('pengeluaran/'.$n->pengeluaran_id.'/detail','Detail',['class'=>'btn btn-success btn-sm']) !!}</td>
		@else
				<td></td>
		@endif

		
		
		
		@endforeach
		
	</table>
	{!! $transaksi->render() !!}
			
			
</div>
		
		
	


@stop
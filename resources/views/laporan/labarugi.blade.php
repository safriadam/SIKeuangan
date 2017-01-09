@extends('layouts.app')
@section('content')

 

<div class="container">
		<div class="row">
              <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-book" aria-hidden="true"></i>Laporan Laba-Rugi</h3>
              </div>
        </div>
		<div class="col-sm-3">
			<h4>Saldo saat ini:</h4> 
			<tr><td>{!! Form::text('saldo', number_format($saldo->saldo) ,['class'=>'form-control']) !!}</td></tr>
		</div>
		<div class="col-sm-4">
			<h4>Periode: </h4> <!-- untuk pilih periode masa tanam  -->
				{!! Form::open(array('url'=>'laporan/labarugi/labarugiBulanan')) !!}
				{!! Form::selectRange('year',2015, date('Y'), $y ,['class' => 'field input-sm']) !!}
				{!! Form::selectMonth('masaTanam', $m ,['class' => 'field input-sm'] ) !!}
				{!! form::submit('Tampilkan',['class'=>'btn btn-info btn-sm']) !!}
				{!! form::close() !!}
		</div>
		<div class="col-sm-3">
			<h4>Laba - Rugi :{{ $saldomt->periode->format('F') }}</h4> 
			<tr><td>{!! Form::text('labarugi', number_format($labarugi) ,['class'=>'form-control']) !!}</td></tr>
		</div>
		<div class="col-sm-2">
		<h4>Cetak Laba-Rugi</h4>
			<div class="btn-group">
				{!! Form::open(array('url'=>'laporan/labarugi/labarugipdf')) !!}
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
			<th>Masa Tanam</th>
			<th>Deskripsi</th>
			<th>Pemasukan</th>
			<th>Pengeluaran</th>
			<th>Aksi</th>
		</tr>
		<?php $no = 1; ?>
		@foreach ( $laba_rugi as $n)
		<tr>
		<td width="50px" align="center">{{ $no++ }}</td>
		<td width="120px">{{ $n->periode->format('F') }} - {{ $n->periode->modify('+2 month')->format('F') }}</td> 
		<td width="200px">{{ $n->deskripsi }}</td>
		<td width="140px">{{ number_format($n->pemasukan) }}</td>
		<td width="140px">{{ number_format($n->pengeluaran) }}</td>

		@if ($n->pengeluaran)

				<td width="50px">{!! link_to('pengeluaran/'.$n->realisasi_id.'/detail','Detail',['class'=>'btn btn-success btn-sm']) !!}</td>
		@else
				<td></td>
		@endif

		
		
		
		@endforeach
		
	</table>
	{!! $laba_rugi->render() !!}
			
	
</div>
		
		
	


@stop
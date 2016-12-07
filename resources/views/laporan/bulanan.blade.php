@extends('layouts.app')
@section('content')

 

<div class="container">
		<div class="row">
              <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-money" aria-hidden="true"></i>Laporan Keuangan Bulanan</h3>
              </div>
        </div>
		<div class="col-sm-4">
			<h4>Saldo saat ini:</h4> 
			<tr><td>{!! Form::text('saldo', number_format($saldo->saldo) ,['class'=>'form-control']) !!}</td></tr>
		</div>
		<div class="col-sm-4">
			<h4>Periode: </h4> <!-- untuk pilih periode masa tanam  -->
				{!! Form::open(array('url'=>'laporan/bulanan/tahunBulan')) !!}
				{!! Form::selectRange('year',2015, date('Y'), $y ,['class' => 'field']) !!}
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
								   '12' => 'Desember - Februari'], $m, ['class' => 'field']
									) }}
				{!! form::submit('Tampilkan',['class'=>'btn btn-info btn-sm']) !!}
				{!! form::close() !!}
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
		<td width="100px">{{ $n->tgl_transaksi }}</td> 
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
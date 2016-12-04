@extends('layouts.app')
@section('content')

 

<div class="container">
		<div class="row">
              <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-calendar" aria-hidden="true"></i>Anggaran</h3>
              </div>
        </div>
		<div class="col-sm-4">
			<h4>Saldo saat ini:</h4> 
			<tr><td>{!! Form::text('saldo', $saldo ,['class'=>'form-control']) !!}</td></tr>
		</div>
		<div class="col-sm-4">
			<h4>Anggaran Masa Tanam: </h4> <!-- untuk pilih periode masa tanam  -->
				{!! Form::open(array('url'=>'anggaran/tahunBulan')) !!}
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

		<div class="col-sm-4">
			<H4>Total Anggaran:</H4>
			{!! Form::text('total_ang', number_format($total_ang) ,['class'=>'form-control']) !!}
		</div>
	
</div>
	
<div class="container"> 	
	<div class="col-sm-3">
		<hr>
			<div class="btn-group">
				{!! link_to('anggaran/create','Tambah Anggaran',['class'=>'btn btn-danger btn-md btn-space']) !!}
			</div>
		<hr>
	</div>

</div>
<div class="container">
	<table class="table table-bordered">
		
		<tr>
			<th>No</th>
			<th>Masa Tanam</th>
			<th>Nama Sayur</th>
			<th>Bibit</th>
			<th>Nutrisi</th>
			<th>Bahan Lain</th>
			<th>Total Anggaran</th>
			<th colspan="2">Aksi</th></tr>
		<?php $no = 1; ?>
		@foreach ( $anggaran as $n)
		<tr>
		<td width="50px" align="center">{{ $no++ }}</td>
		<td width="200px">{{ $n->masa_tanam->format('F') }} - {{ $n->masa_tanam->modify('+2 month')->format('F') }}</td> 
		<td width="200px">{{ $n->nama_sayur }}</td>
		<td width="140px">{{ number_format($n->bibit) }}</td>
		<td width="140px">{{ number_format($n->nutrisi) }}</td>
		<td width="140px">{{ number_format($n->bahan_lain) }}</td>
		<td width="140px">{{ number_format($n->tot_anggaran) }}</td>

		<td width="50px">{!! link_to('anggaran/'.$n->id.'/edit','Detail',['class'=>'btn btn-warning btn-sm']) !!}
		<!-- <td>
			{!! Form::open(array('method'=>'delete','url'=>'pemasukan/'.$n->id))!!}
			{!! Form::hidden('_delete','DELETE')!!}
			{!! Form::submit('Hapus',['class'=>'btn btn-danger btn-sm'])!!}
			{!! Form::close()!!}
		</td> -->
			
			<!-- fitur edit dan delete diatas di matikan karena alasan integritas data keuangan -->

		</td> </tr>
		
		<!--  -->

		@endforeach
		
	</table>
	{!! $anggaran->render() !!}
			
			
</div>
		
		
	


@stop
@extends('layouts.app')
@section('content')

 

<div class="container">
		<div class="row">
              <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Realisasi</h3>
              </div>
        </div>
		<div class="col-sm-4">
			<h4>Saldo saat ini:</h4> 
			<tr><td>{!! Form::text('saldo', $saldo ,['class'=>'form-control']) !!}</td></tr>
		</div>
		<div class="col-sm-4">
			<h4>Realisasi Masa Tanam: </h4> <!-- untuk pilih periode masa tanam  -->
				{!! Form::open(array('url'=>'pengeluaran/tahunBulan')) !!}
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
			<H4>Total Realisasi:</H4>
			{!! Form::text('total_real', number_format($total_real) ,['class'=>'form-control']) !!}
		</div>
	
</div>
	
 	

<div class="container">
	<hr>
	<table class="table table-bordered">
		<tr>
			<th>No</th>
			<th>Masa Tanam</th>
			<th>Nama Sayur</th>
			<th>Realiasi Bibit</th>
			<th>Realiasi Nutrisi</th>
			<th>Realisasi Bahan Lain</th>
			<th>Total Realisasi</th>
			<th colspan="2">Aksi</th></tr>
		<?php $no = 1; ?>
		@foreach ( $pengeluaran as $n)
		<tr>
		<td width="50px" align="center">{{ $no++ }}</td>
		<td width="200px">{{ $n->masa_tanam->format('F') }} - {{ $n->masa_tanam->modify('+2 month')->format('F') }}</td> 
		<td width="200px">{{ $n->nama_sayur }}</td>
		<td width="140px">{{ number_format($n->real_bibit) }}</td>
		<td width="140px">{{ number_format($n->real_nutrisi) }}</td>
		<td width="140px">{{ number_format($n->real_bahan_lain) }}</td>
		<td width="140px">{{ number_format($n->total_realisasi) }}</td>

		@if ($n->total_realisasi) 
				<td width="50px"><button type="button" class="btn btn-success btn-sm disabled">Realiasikan</button></td>	
		@else
				<td width="50px">{!! link_to('pengeluaran/'.$n->id.'/edit','Realisasikan',['class'=>'btn btn-success btn-sm']) !!}</td>
		@endif
		 </tr>

		
		
		
		@endforeach
		
	</table>
	{!! $pengeluaran->render() !!}
			
			
</div>
		
		
	


@stop
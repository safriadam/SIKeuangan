@extends('layouts.app')
@section('content')

 

<div class="container">
		<div class="row">
              <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-money" aria-hidden="true"></i>Harga Jual Produk</h3>
              </div>
        </div>
		<div class="col-sm-4">
			<h4>Masa Tanam: </h4> <!-- untuk pilih periode masa tanam  -->
				{!! Form::open(array('url'=>'harga/tahunBulan')) !!}
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
		<div class="col-sm-3">
		<h4>Cetak Harga: </h4>
			<div class="btn-group">
				{!! Form::open(array('url'=>'harga/hargapdf')) !!}
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
			<th>Nama Sayur</th>
			<th>Total Modal</th>
			<th>Total Panen</th>
			<th>Profit</th>
			<th>Rekomendasi Harga</th>
			<th>Harga Pasar</th>
			<th>Harga Jual</th>
			<th colspan="2">Aksi</th></tr>
		<?php $no = 1; ?>
		@foreach ( $harga as $n)
		<tr>
		<td width="50px" align="center">{{ $no++ }}</td>
		<td width="200px">{{ $n->masa_tanam->format('F') }} - {{ $n->masa_tanam->modify('+2 month')->format('F') }}</td> 
		<td width="200px">{{ $n->nama_sayur }}</td>
		<td width="140px">{{ number_format($n->pengeluaran) }}</td>
		<td width="140px">{{ number_format($n->total_panen) }}</td>
		<td width="140px">{{ number_format($n->profit) }}</td>
		<td width="140px">{{ number_format($n->harga_rekomen) }}</td>
		<td width="140px">{{ number_format($n->harga_pasar) }}</td>
		<td width="140px">{{ number_format($n->harga_jual) }}</td>

		@if ($n->total_realisasi) 
				<td width="50px"><button type="button" class="btn btn-success btn-sm disabled">Realiasikan</button></td>	
		@else
				<td width="50px">{!! link_to('harga/'.$n->id.'/edit','Edit',['class'=>'btn btn-success btn-sm']) !!}</td>
		@endif
		 </tr>

		
		
		
		@endforeach
		
	</table>
	
			
			
</div>
		
		
	


@stop
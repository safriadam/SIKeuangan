@extends('layouts.app')
@section('content')


<div class="container">
	{!! Html::ul($errors->all()) !!}
		<div class="row">
              <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-pagelines"></i>Sayuran</h3>
              </div>
         </div>
<div class="container"> 	
	<div class="col-sm-2">
			<div class="btn-group">
				{!! link_to('sayuran/create','Tambah Sayuran',['class'=>'btn btn-danger btn-md btn-space']) !!}
			</div>
			
	</div>
<div class="col-sm-6">
<table class="table table-bordered">
		
		<tr>
			<th align="center">No</th>
			<th>Nama Sayur</th>
			<th>Tanggal Ditambahkan </th>
		<?php $no = 1; ?>
		@foreach ( $sayuran as $n)
		<tr>
			<td width="5px" align="center">{{ $no++ }}</td>
			<td width="200px">{{ $n->nama_sayur }}</td>
			<td width="200px">{{ $n->created_at->format('d/m/Y')}}</td>
		</tr>
		

		@endforeach
		
	</table>
</div>
</div>
@stop
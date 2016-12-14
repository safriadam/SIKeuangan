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
					</tr>
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
</div>

<div class="container">
	{!! Html::ul($errors->all()) !!}
		<div class="row">
              <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-pagelines"></i>Bibit</h3>
              </div>
        </div>
		<div class="container"> 	
			<div class="col-sm-2">
				<div class="btn-group">
					{!! link_to('sayuran/createBibit','Tambah Bibit',['class'=>'btn btn-danger btn-md btn-space']) !!}
				</div>
			</div>
			<div class="col-sm-10">
				<table class="table table-bordered">
					
					<tr>
						<th align="center">No</th>
						<th>Nama Sayur</th>
						<th>Nama Bibit</th>
						<th>Harga</th>
						<th>Tanggal Ditambahkan</th>
					</tr>
					<?php $no = 1; ?>
					@foreach ( $bibit as $n)
					<tr>
						<td width="5px" align="center">{{ $no++ }}</td>
						<td width="200px">{{ $n->nama_sayur }}</td>
						<td width="400px">{{ $n->nama_bibit }}</td>
						<td width="200px">{{ number_format($n->harga_bibit) }}</td>
						<td width="200px">{{ $n->created_at->format('d/m/Y')}}</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
</div>

<div class="container">
	{!! Html::ul($errors->all()) !!}
	<div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-flask"></i>Nutrisi</h3>
          </div>
    </div>
	<div class="container"> 	
		<div class="col-sm-2">
			<div class="btn-group">
				{!! link_to('sayuran/createNutrisi','Tambah Nutrisi',['class'=>'btn btn-danger btn-md btn-space']) !!}
			</div>	
		</div>
		<div class="col-sm-10">
			<table class="table table-bordered">
				<tr>
					<th align="center">No</th>
					<th>Nama Nutrisi</th>
					<th>Harga Nutrisi</th>
					<th>Tanggal Ditambahkan </th>
				</tr>
				<?php $no = 1; ?>
				@foreach ( $nutrisi as $n)
				<tr>
					<td width="5px" align="center">{{ $no++ }}</td>
					<td width="400px">{{ $n->nama_nutrisi }}</td>
					<td width="200px">{{ number_format($n->harga_nutrisi) }}</td>
					<td width="200px">{{ $n->created_at->format('d/m/Y')}}</td>
				</tr>
				@endforeach	
			</table>
		</div>
	</div>
</div>

<div class="container">
	{!! Html::ul($errors->all()) !!}
		<div class="row">
              <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-plus-square-o"></i>Bahan Lain</h3>
              </div>
        </div>
		<div class="container"> 	
			<div class="col-sm-2">
				<div class="btn-group">
					{!! link_to('sayuran/createBahan','Tambah Bahan Lain',['class'=>'btn btn-danger btn-md btn-space']) !!}
				</div>	
			</div>
			<div class="col-sm-10">
				<table class="table table-bordered">
					
					<tr>
						<th align="center">No</th>
						<th>Nama Bahan Lain</th>
						<th>Harga Bahan Lain</th>
						<th>Tanggal Ditambahkan </th>
					</tr>
					<?php $no = 1; ?>
					@foreach ( $bahan_lain as $n)
					<tr>
						<td width="5px" align="center">{{ $no++ }}</td>
						<td width="200px">{{ $n->nama_bahan_lain }}</td>
						<td width="200px">{{ number_format($n->harga_bahan_lain) }}</td>
						<td width="200px">{{ $n->created_at->format('d/m/Y')}}</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
</div>
@stop
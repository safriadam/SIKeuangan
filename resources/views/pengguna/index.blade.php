@extends('layouts.app')
@section('content')


<div class="container">
		<div class="row">
              <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-user" aria-hidden="true"></i>Pengguna</h3>
              </div>
        </div>
@include('flash::message')
	<div>
		{!! link_to('pengguna/create','Tambah Pengguna',['class'=>'btn btn-danger btn-md']) !!}
		<hr>
	</div>

<table class="table table-bordered">
	
	<tr>
		<th>No</th>
		<th>Nama</th>
		<th>Email</th>
		<th>Jabatan</th>
		<th>Status</th>
		<th colspan="2">Aksi</th>
	</tr>

	<?php $no = 1; ?>
	@foreach ( $pengguna as $n)
	<tr>
		<td width="50px" align="center">{{ $no++ }}</td>
		<td width="140px">{{ $n->name }}</td>
		<td width="500px">{{ $n->email }}</td>
		<td width="140px">{{ $n->jabatan }}</td>
		<td width="140px">{{ $n->status }}</td>

		@if($n->status=='AKTIF')
			<td width="50px">
				{!! link_to('pengguna/'.$n->id.'/edit','NON-AKTIFKAN',array('class'=>'btn btn-danger btn-sm','method'=>'patch') ) !!}
			</td>
			<td width="50px">
				{!! link_to('pengguna/'.$n->id.'/reset','RESET PASSWORD',array('class'=>'btn btn-warning btn-sm','method'=>'patch') ) !!}
			</td>

		@elseif($n->status=='NONAKTIF')
			<td>
				{!! link_to('pengguna/'.$n->id.'/edit','AKTIFKAN',['class'=>'btn btn-success btn-sm']) !!}
			</td>
			<td width="50px">
				{!! link_to('pengguna/'.$n->id.'/reset','RESET PASSWORD',array('class'=>'btn btn-warning btn-sm','method'=>'patch') ) !!}
			</td>
		@endif
	</tr>
	
	@endforeach
	
</table>
<!--  -->
</div>


@stop
@extends('layouts.app')
@section('content')


<div class="container">
@include('flash::message')
	<div>
		<hr>
		{!! link_to('pengguna/create','Tambah Pengguna',['class'=>'btn btn-danger btn-md']) !!}
		<hr>
	</div>
<hr>

<table class="table table-bordered">
	
	<tr><th>No</th><th>Nama</th><th>Email</th><th>Jabatan</th><th colspan="2">Aksi</th></tr>
	<?php $no = 1; ?>

	@foreach ( $pengguna as $n)
	<tr>
	<td width="50px" align="center">{{ $no++ }}</td>
	<td width="140px">{{ $n->name }}</td>
	<td width="500px">{{ $n->email }}</td>
	<td width="140px">{{ $n->jabatan }}</td>
	<td width="50px">
	
		{!! Form::open(array('method'=>'delete','url'=>'pengguna/'.$n->id))!!}
		{!! Form::hidden('_delete','DELETE')!!}

		{!! Form::submit('Hapus',['class'=>'btn btn-danger btn-sm','id'=>'deletebtn', 'onclick' => 'return confirm("Apakah anda yakin ingin menghapus ?")'])!!}
		{!! Form::close()!!}
	
	</td> </tr>
	
	@endforeach
	
</table>
<!--  -->
</div>


@stop
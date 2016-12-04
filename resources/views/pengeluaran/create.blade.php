@extends('layouts.app')
@section('content')



<div class="container">
	{!! Html::ul($errors->all()) !!}

	{!! Form::open(array('url'=>'pengeluaran')) !!}
	<table class="table table-bordered">

	@include('pengeluaran.form') <!-- buat manggil form di view/anggaran/form.blade.php, jadi sekali panggil -->
		<tr><td colspan="2">
			{!! Form::submit('simpan data',['class'=>'btn btn-danger btn-sm']) !!}
			{!! link_to('pengeluaran','Kembali',['class'=>'btn btn-danger btn-sm']) !!}
		</td></tr>
	</table>
	{!! Form::close() !!}
</div>
 
@stop
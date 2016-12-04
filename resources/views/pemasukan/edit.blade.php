@extends('layouts.app')
@section('content')


<div class="container">
		{!! Html::ul($errors->all()) !!}

		{!! Form::model($pemasukan,array('url'=>'pemasukan/'.$pemasukan->id,'method'=>'patch')) !!}
		<table class="table table-bordered container">

		@include('pemasukan.form') <!-- buat manggil form di view/pemasukan/form.blade.php, jadi sekali panggil -->
			<tr><td colspan="2">
				{!! Form::submit('simpan data',['class'=>'btn btn-danger btn-sm']) !!}
				{!! link_to('pemasukan','Kembali',['class'=>'btn btn-danger btn-sm']) !!}
			</td></tr>
		</table>
		{!! Form::close() !!}
</div>
@stop
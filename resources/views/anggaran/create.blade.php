@extends('layouts.app')
@section('content')


<div class="container">
	{!! Html::ul($errors->all()) !!}
		<div class="row">
              <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-plus-circle"></i>Tambah Anggaran</h3>
              </div>
         </div>

	{!! Form::open(array('url'=>'anggaran')) !!}
	<table class="table table-bordered ">

	@include('anggaran.form') <!-- buat manggil form di view/anggaran/form.blade.php, jadi sekali panggil -->
		<tr><td colspan="2">
			{!! Form::submit('Simpan Data',['class'=>'btn btn-danger btn-sm']) !!}
			{!! link_to('anggaran','Kembali',['class'=>'btn btn-danger btn-sm']) !!}
		</td></tr>
	</table>
	{!! Form::close() !!}
</div>



@stop
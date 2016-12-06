@extends('layouts.app')
@section('content')



<div class="container">

	<div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-plus" aria-hidden="true"></i>Tambah Pemasukan</h3>
          </div>
    </div>
	{!! Html::ul($errors->all()) !!}

	{!! Form::open(array('url'=>'pemasukan')) !!}
	<div class="col-lg-8">
		<table class="table table-bordered">

			<tr>
				<td>Tanggal Pemasukan: </td>
				<td>{{ Form::text('masa_tanam',date('Y-m-d'), ['class' => 'form-control','readonly']) }}</td>
			</tr>

			<tr>
				<td>Jenis Pemasukan</td>
				<td>{{ Form::select('jenis_pema', ['IURAN' => 'IURAN','SUMBANGAN' => 'SUMBANGAN'],'', ['class' => 'form-control'] ) }}
				</td>
			</tr>
			<tr>
				<td>Pemasukan</td>
				<td>{!! Form::text('pemasukan',null,array('class' => 'form-control','placeholder'=>'0')) !!}</td>
			</tr>
			<tr>
				<td>Keterangan</td>
				<td>{!! Form::text('keterangan',null,['class'=>'form-control']) !!}</td>
			</tr>

			<tr><td colspan="2">
				{!! Form::submit('Simpan data',['class'=>'btn btn-danger btn-sm']) !!}
				{!! link_to('pemasukan','Kembali',['class'=>'btn btn-danger btn-sm']) !!}
			</td></tr>
		</table>
</div>
	{!! Form::close() !!}
</div>
 
@stop
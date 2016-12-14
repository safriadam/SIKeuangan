@extends('layouts.app')
@section('content')


<div class="container">
{!! Html::ul($errors->all()) !!}
<div class="row">
              <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-plus-circle"></i>Tambah Nutrisi</h3>
              </div>
</div>
{!! Form::open(array('url'=>'sayuran/storeBahan')) !!}

	<div class="col-lg-6">
		<table class="table table-bordered">
			<tr>
				<td width="150px">Nama Bahan Lain</td><td>{!! Form::text('nama_bahan_lain','',['class'=>'form-control'] ) !!}</td>
			</tr>
			<tr>
				<td width="150px">Harga Bahan Lain</td><td>{!! Form::text('harga_bahan_lain','',['class'=>'form-control'] ) !!}</td>
			</tr>
			<tr>
				<td colspan="2">
					{!! Form::submit('simpan data',['class'=>'btn btn-danger btn-sm']) !!}
					{!! link_to('sayuran','Kembali',['class'=>'btn btn-danger btn-sm']) !!}
				</td>
			</tr>
		</table>
	</div>
{!! Form::close() !!}
</div>
@stop
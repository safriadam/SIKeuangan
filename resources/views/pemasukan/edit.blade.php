@extends('layouts.app')
@section('content')


<div class="container">
	<div class="row">
              <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-plus" aria-hidden="true"></i>Tambah Pemasukan</h3>
              </div>
    </div>
{!! Html::ul($errors->all()) !!}

{!! Form::model($pemasukan,array('url'=>'pemasukan/'.$pemasukan->id,'method'=>'patch')) !!}
<table class="table table-bordered">

	<tr><td>Pemasukan Masa Tanam: </td>
		<td>{{ Form::hidden('masa_tanam', $pemasukan->masa_tanam) }}
			{{ $pemasukan->masa_tanam->format('F') }} - {{ $pemasukan->masa_tanam->modify('+2 month')->format('F') }}
		
		</td>
	</tr>
	<tr>
	<td>Nama Sayur</td>
			{{ Form::hidden('jenis_pema', 'PENJUALAN') }}
			{{ Form::hidden('sayur_id', $pemasukan->id_sayur) }}
		<td>{{ Form::text('nama_sayur',null, ['class' => 'form-control','readonly']) }}</td>
	</tr>

	<tr>
		<td>Pemasukan</td>
		<td>{!! Form::text('pemasukan',null,array('class' => 'form-control','placeholder'=>'0')) !!}</td>
		<td>Keterangan</td>
		<td>{!! Form::text('keterangan',null,['class'=>'form-control']) !!}</td>
	</tr>

	<tr><td colspan="2">
		{!! Form::submit('simpan data',['class'=>'btn btn-danger btn-sm']) !!}
		{!! link_to('pemasukan','Kembali',['class'=>'btn btn-danger btn-sm']) !!}
	</td></tr>
</table>
{!! Form::close() !!}

</div>

@stop
@extends('layouts.app')
@section('content')


<div class="container">
	<div class="row">
              <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-info-circle" aria-hidden="true"></i>Detail Harga Jual Produk</h3>
              </div>
    </div>
	{!! Html::ul($errors->all()) !!}
    <div class="col-md-6">
		{!! Form::model($harga,array('url'=>'harga/'.$harga->id,'method'=>'patch')) !!}
		<table class="table table-bordered">
			<tr>
				<td>Masa Tanam</td>
				<td>{{ $harga->masa_tanam->format('F') }} - {{ $harga->masa_tanam->modify('+2 month')->format('F') }}</td>
			</tr>
			<tr>
				<td>Nama Sayur</td>
				<td>{!! Form::text('nama_sayur',$harga->nama_sayur, ['class'=>'form-control','disabled']) !!}</td>
			</tr>
			<tr>
				<td>Total Modal</td>
				<td>{!! Form::text('pengeluaran',number_format($harga->pengeluaran),['class'=>'form-control','disabled']) !!}</td>
			</tr>
			<tr>
				<td>Total Panen</td>
				<td>{!! Form::text('total_panen','',['class'=>'form-control']) !!}</td>
			</tr>
			<tr>
				<td>Profit</td>
				<td>{!! Form::text('profit','',['class'=>'form-control']) !!}</td>
			</tr>
			<tr>
				<td>Rekomendasi Harga</td>
				<td>{!! Form::text('harga_rekomen','',['class'=>'form-control']) !!}</td>
			</tr>
			<tr>
				<td>Harga Pasar</td>
				<td>{!! Form::text('harga_pasar','',['class'=>'form-control']) !!}</td>
			</tr>
			<tr>
				<td>Harga Jual</td>
				<td>{!! Form::text('harga_jual','',['class'=>'form-control']) !!}</td>
			</tr>
			<tr>
			<td>{!! Form::submit('Simpan',['class'=>'btn btn-danger btn-sm']) !!}</td>
		</table>
		{!! Form::close() !!}
	</div>
</div>

@stop
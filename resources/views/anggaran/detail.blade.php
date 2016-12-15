@extends('layouts.app')
@section('content')


<div class="container">
	<div class="row">
              <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-info-circle" aria-hidden="true"></i>Detail Anggaran</h3>
              </div>
         </div>
{!! Html::ul($errors->all()) !!}

{!! Form::model($anggaran,array('url'=>'anggaran/'.$anggaran->id,'method'=>'patch')) !!}
<table class="table table-bordered">

	<tr><td>Anggaran Masa Tanam: </td>
		<td>
			{{ $anggaran->masa_tanam->format('F') }} - {{ $anggaran->masa_tanam->modify('+2 month')->format('F') }}
				
		</td>
	</tr>
	<tr><td width="150px">Nama Sayur </td>
		<td width="250px">{{ Form::text('nama_sayur',null, ['class' => 'form-control','readonly']) }}</td>
	</tr>

	<tr><td>Bibit</td>
		<td>{!! Form::text('bibit',null,array('id'=>'bibit','class' => 'form-control','placeholder'=>'0','readonly')) !!}</td>
		<td width="100px">Keterangan</td>
		<td>{!! Form::text('ket_bibit',null,['class'=>'form-control']) !!}</td>
	</tr>

	<tr><td>Nutrisi</td>
		<td>{!! Form::text('nutrisi',null,array('id'=>'nutrisi','class' => 'form-control','placeholder'=>'0','readonly')) !!}</td>
		<td>Keterangan</td>
		<td>{!! Form::text('ket_nutrisi',null,['class'=>'form-control']) !!}</td>
	</tr>

	<tr><td>Bahan Lain</td>
		<td>{!! Form::text('bahan_lain',null,array('id'=>'bahan_lain','class' => 'form-control','placeholder'=>'0','readonly')) !!}</td>
		<td>Keterangan</td>
		<td>{!! Form::text('ket_bahan_lain',null,['class'=>'form-control']) !!}</td>
	</tr>

	<tr><td>Total Anggaran</td>
		<td>{!! Form::text('tot_anggaran',null,array('id'=>'tot_anggaran','class' => 'form-control','readonly')) !!}</td></tr>

	<tr><td colspan="2">
		
		{!! link_to('anggaran','Kembali',['class'=>'btn btn-danger btn-sm']) !!}
	</td></tr>
</table>
{!! Form::close() !!}

</div>
@stop
@extends('layouts.app')
@section('content')


<div class="container">
	<div class="row">
              <div class="col-lg-12">
                <h3 class="page-header"><i class="fa fa-info-circle" aria-hidden="true"></i>Detail Realisasi</h3>
              </div>
         </div>
{!! Html::ul($errors->all()) !!}

{!! Form::model($pengeluaran,array('url'=>'pengeluaran/'.$pengeluaran->id,'method'=>'patch')) !!}
<table class="table table-bordered">

	<tr><td>Realiasasi Masa Tanam: </td>
		<td>
			{{ $pengeluaran->masa_tanam->format('F') }} - {{ $pengeluaran->masa_tanam->modify('+2 month')->format('F') }}
		</td>
	</tr>
	<tr><td>Nama Sayur </td>
		<td>{{ Form::text('nama_sayur',null, ['class' => 'form-control','readonly']) }}</td>
	</tr>

	<tr><td>Anggaran Bibit</td>
		<td>{!! Form::text('ang_bibit',null,array('id'=>'ang_bibit','class' => 'form-control','readonly')) !!}</td>
		<td>Realiasi Bibit</td>
		<td>{!! Form::text('real_bibit',null,array('id'=>'bibit','class' => 'form-control','placeholder'=>'0')) !!}</td>
		<td>Keterangan</td>
		<td>{!! Form::text('ket_real_bibit',null,['class'=>'form-control']) !!}</td>
	</tr>

	<tr><td>Anggaran Nutrisi</td>
		<td>{!! Form::text('ang_nutrisi',null,array('id'=>'ang_nutrisi','class' => 'form-control','readonly')) !!}</td>
		<td>Realiasi Nutrisi</td>
		<td>{!! Form::text('real_nutrisi',null,array('id'=>'nutrisi','class' => 'form-control','placeholder'=>'0')) !!}</td>
		<td>Keterangan</td>
		<td>{!! Form::text('ket_real_bibit',null,['class'=>'form-control']) !!}</td>
	</tr>

	<tr><td>Anggaran Bahan Lain</td>
		<td>{!! Form::text('ang_bahan_lain',null,array('id'=>'ang_bahan_lain','class' => 'form-control','readonly')) !!}</td>
		<td>Realiasi Bahan Lain</td>
		<td>{!! Form::text('real_bahan_lain',null,array('id'=>'bahan_lain','class' => 'form-control','placeholder'=>'0')) !!}</td>
		<td>Keterangan</td>
		<td>{!! Form::text('ket_real_bahan_lain',null,['class'=>'form-control']) !!}</td>
	</tr>

	<tr><td>Total Anggaran</td>
		<td>{!! Form::text('anggaran_total',null,array('class' => 'form-control','readonly')) !!}</td>
		<td>Total Realiasi</td>
		<td>{!! Form::text('total_realisasi',null,array('id'=>'tot_anggaran','class' => 'form-control','readonly')) !!}</td></tr>

	<tr><td colspan="2">
		{!! Form::submit('simpan data',['class'=>'btn btn-danger btn-sm']) !!}
		{!! link_to('pengeluaran','Kembali',['class'=>'btn btn-danger btn-sm']) !!}
	</td></tr>
</table>
{!! Form::close() !!}

</div>


</script>
@stop
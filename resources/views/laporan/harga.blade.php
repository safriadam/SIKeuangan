@extends('layouts.app')
@section('content')


<div class="container">
	{!! Html::ul($errors->all()) !!}

	{!! Form::open(array('url'=>'laporan/harga/hasilHarga')) !!}
	<table class="table table-bordered">
		<tr>
			<td>pengeluaran produksi
				
				{!! Form::selectMonth('month', $m ,['class' => 'field'] ) !!}
				{!! Form::selectRange('year',2015, date('Y'), $y ,['class' => 'field']) !!}	
			</td>
			<td>{!! Form::text('pengeluaran_prod',number_format($pengeluaran_prod),['class'=>'form-control','readonly']) !!}</td>
		</tr>
		<tr><td>Total Hasil Panen</td><td>{!! Form::text('hasil_panen',$hasil_panen,['class'=>'form-control']) !!} *dalam satuan kilogram atau pack </td></tr>
		<tr><td>Margin</td><td>{!! Form::text('margin',$margin,['class'=>'form-control']) !!}  *keuntungan yang diinginkan per-kilogram atau per-pack</td></tr>

		<tr>
		<td>{!! Form::submit('Tampil Harga Pokok',['class'=>'btn btn-danger btn-sm']) !!}</td><td>{!! Form::text('hasil',number_format($hasil),['class'=>'form-control']) !!}</td>
	</table>
	{!! Form::close() !!}
</div>

@stop
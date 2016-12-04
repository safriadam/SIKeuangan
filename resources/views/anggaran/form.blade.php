
<tr><td>Anggaran Masa Tanam: </td>
		<td>
			<div class="col-sm-4">{!! Form::selectRange('year',2015, date('Y'), $y ,['class' => 'form-control']) !!}</div>
			<div class="col-sm-6">{{ Form::select('masaTanam', [
								   '1' => 'Januari - Maret',
								   '2' => 'Februari - April',
								   '3' => 'Maret - Mei',
								   '4' => 'April - Juni',
								   '5' => 'Mei - Juli',
								   '6' => 'Juni - Agustus',
								   '7' => 'Juli - September',
								   '8' => 'Agustus - Oktober',
								   '9' => 'September - November',
								   '10' => 'Oktober - Desember',
								   '11' => 'November - Januari',
								   '12' => 'Desember - Februari'], $m, ['class' => 'form-control']
									) }}</div>
				
		</td>
	</tr>
	<tr><td>Nama Sayur </td>
		<td>{{ Form::select('nama_sayur',$sayuran,null, ['class' => 'form-control']) }}</td>
	</tr>

	<tr><td>Bibit</td>
		<td>{!! Form::text('bibit',null,array('id'=>'bibit','class' => 'form-control','placeholder'=>'0')) !!}</td>
		<td>Keterangan</td>
		<td>{!! Form::text('ket_bibit',null,['class'=>'form-control']) !!}</td>
	</tr>

	<tr><td>Nutrisi</td>
		<td>{!! Form::text('nutrisi',null,array('id'=>'nutrisi','class' => 'form-control','placeholder'=>'0')) !!}</td>
		<td>Keterangan</td>
		<td>{!! Form::text('ket_nutrisi',null,['class'=>'form-control']) !!}</td>
	</tr>

	<tr><td>Bahan Lain</td>
		<td>{!! Form::text('bahan_lain',null,array('id'=>'bahan_lain','class' => 'form-control','placeholder'=>'0')) !!}</td>
		<td>Keterangan</td>
		<td>{!! Form::text('ket_bahan_lain',null,['class'=>'form-control']) !!}</td>
	</tr>

	<tr><td>Total Anggaran</td>
		<td>{!! Form::text('tot_anggaran',null,array('id'=>'tot_anggaran','class' => 'form-control','readonly')) !!}</td></tr>

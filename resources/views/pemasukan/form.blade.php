


<tr><td>Tanggal Transaksi</td><td>{!! Form::text('tanggal_transaksi', date('d/m/Y'),['class'=>'form-control','readonly'] ) !!}</td></tr>
<tr><td>Deskripsi</td><td>{!! Form::text('deskripsi',null,['class'=>'form-control']) !!}</td></tr>
<tr><td>Pemasukan</td><td>{!! Form::text('pemasukan',null,['class'=>'form-control']) !!}</td></tr>
<tr><td>Jenis Pemasukan</td><td>{!! Form::select('jenis_pema', array('aset' => 'ASET','produksi' => 'PRODUKSI'),'produksi') !!}</td></tr>

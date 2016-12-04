<tr><td>Nama Sayur</td><td>{!! Form::text('nama_sayur','',['class'=>'form-control'] ) !!}</td></tr>
<tr><td>Deskripsi</td><td>{!! Form::text('deskripsi',null,['class'=>'form-control']) !!}</td></tr>
<tr><td>Pemasukan</td><td>{!! Form::text('pemasukan',null,['class'=>'form-control']) !!}</td></tr>
<tr><td>Jenis Pemasukan</td><td>{!! Form::select('jenis_pema', array('aset' => 'ASET','produksi' => 'PRODUKSI'),'produksi') !!}</td></tr>

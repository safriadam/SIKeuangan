	



<tr><td>Tanggal Transaksi</td><td>{!! Form::text('tanggal_transaksi',date('d/m/Y'),['class'=>'form-control','readonly']) !!}</td></tr>

<tr><td>Item Pengeluaran</td><td>{!! Form::text('item_pengeluaran',null,['class'=>'form-control']) !!}</td></tr>

<tr><td>Harga Satuan</td><td>{!! Form::text('harga_satuan_peng',null,['class'=>'form-control']) !!}</td></tr>

<tr><td>QTY</td><td>{!! Form::text('qty_peng',null,['class'=>'form-control']) !!} Jika bilangan pecahan, Gunakan titik (.) jangan koma (,). contoh : 2.5 bukan 2,5</td></tr>

<tr><td>Pengeluaran</td><td>{!! Form::text('pengeluaran',null,['class'=>'form-control','placeholder'=>'Otomatis Terkalkulasi','readonly']) !!}</td></tr>

<tr><td>Jenis Pengeluaran</td><td>{!! Form::select('jenis_peng', array('aset' => 'ASET','produksi' => 'PRODUKSI'))!!}</td></tr>



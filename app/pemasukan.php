<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\transaksi;
use App\labarugi;

class pemasukan extends Model
{
    
    protected $fillable = [ 'tanggal_transaksi',
				            'deskripsi',
				            'pemasukan',
				            'jenis_pema',
				            'id'];

	public function transaksi()
    {
    	return $this->hasOne('App\transaksi');
    }

    public function labarugi()
    {
        return $this->hasOne('App\labarugi');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\pemasukan;
use App\pengeluaran;

class labarugi extends Model
{
   protected $fillable = ['tanggal_transaksi','deskripsi','pengeluaran_id','pemasukan_id','pemasukan','pengeluaran','labarugi'];

    public function pemasukan()
    {
    	return $this->belongsTo('App\pemasukan');

    }

    public function pengeluaran()
    {
    	return $this->belongsTo('App\pengeluaran');

    }
}

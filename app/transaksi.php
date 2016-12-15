<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\pemasukan;
use App\pengeluaran;

class transaksi extends Model
{
    //protected $dateFormat = 'U';
    protected $fillable = ['tgl_transaksi','pengeluaran_id','pemasukan_id','pemasukan','pengeluaran','saldo','deskripsi',];

    public function pemasukan()
    {
    	return $this->belongsTo('App\pemasukan');

    }

    public function pengeluaran()
    {
    	return $this->belongsTo('App\pengeluaran');

    }

    protected $dates = [
        'created_at', 
        'updated_at', 
        'tgl_transaksi',
            ];
}

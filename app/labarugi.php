<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\pemasukan;
use App\pengeluaran;

class labarugi extends Model
{
   protected $fillable = ['periode','deskripsi','realisasi_id','pemasukan_id','pemasukan','pengeluaran','labarugi','created_at'];

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
        'periode',
            ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\transaksi;
use App\labarugi;

class pengeluaran extends Model
{
	//protected $dateFormat = 'U';
    protected $fillable = [ 'masa_tanam',
                            'id_sayur',
                            'id_anggaran',
                            'nama_sayur',
                            'ang_bibit',
                            'ang_nutrisi',
                            'ang_bahan_lain',
                            'anggaran_total',
                            'real_bibit',
                            'real_nutrisi',
                            'real_bahan_lain',
                            'ket_real_bibit',
                            'ket_real_nutrisi',
                            'ket_real_bahan_lain',
                            'total_realisasi'];

    public function transaksi()
    {
        return $this->hasOne('App\transaksi');
    }

    public function labarugi()
    {
        return $this->hasOne('App\labarugi');
    }

    protected $dates = [
        'created_at', 
        'updated_at', 
        'masa_tanam',
            ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\transaksi;
use App\labarugi;

class pemasukan extends Model
{
    
    protected $fillable = [ 'masa_tanam',
				            'id_sayur',
				            'nama_sayur',
				            'jenis_pema',
                            'keterangan',
                            'pemasukan',
				            'id'];

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

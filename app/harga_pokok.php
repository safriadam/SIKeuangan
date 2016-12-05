<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class harga_pokok extends Model
{
    protected $fillable = [ 'masa_tanam',
                            'sayur_id',
                            'nama_sayur',
                            'pengeluaran_id',
                            'pengeluaran',
                            'total_panen',
                            'profit',
                            'harga_rekomen',
                            'harga_jual',
                            'harga_pasar',
                            ];

    protected $dates = [
        'created_at', 
        'updated_at', 
        'masa_tanam',
            ];

}

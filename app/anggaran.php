<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DateTime;

class anggaran extends Model
{
    //
    
    protected $fillable = [ 'masa_tanam',
						    'sayur_id',
						    'nama_sayur',
						    'bibit',
						    'ket_bibit',
						    'nutrisi',
						    'ket_nutrisi',
						    'bahan_lain',
						    'ket_bahan_lain',
						    'tot_anggaran'
						    ];

	// 

	protected $dates = [
        'created_at', 
        'updated_at', 
        'masa_tanam',
    		];
}

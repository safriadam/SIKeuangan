<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bibit extends Model
{
     protected $fillable = [ 'sayur_id',
				            'nama_sayur',
				            'nama_bibit',
                            'harga_bibit',
                          	];

}

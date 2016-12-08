<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class pengguna extends Model
{
    protected $fillable = [
        'name', 'email', 'password','jabatan','status',
    ];

   
    protected $hidden = [
        'password', 'remember_token',
    ];
}

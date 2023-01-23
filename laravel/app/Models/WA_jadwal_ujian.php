<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WA_jadwal_ujian extends Model
{
    use HasFactory;

//////////////////////////////////////////////////////////

    // protected $guarded = ['id'];

	protected $table = 'w_a_jadwal_ujians';
    protected $fillable = 
    		[
            'pesan',
        	];

}

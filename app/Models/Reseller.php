<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reseller extends Model
{
    protected $table = 'reseller';
    protected $primaryKey = 'id_reseller';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_reseller',
        'nama',
        'no_telp',
        'nama_brand',
        'email',
        'alamat',
    ];
}

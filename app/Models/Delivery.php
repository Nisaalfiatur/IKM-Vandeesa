<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'delivery';
    protected $primaryKey = 'no_do';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'no_do',
        'no_invoice',
        'id_reseller',
        'id_pegawai',
        'tanggal',
        'status',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'no_invoice', 'no_invoice');
    }

    public function reseller()
    {
        return $this->belongsTo(Reseller::class, 'id_reseller', 'id_reseller');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }
}

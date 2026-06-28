<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';
    protected $primaryKey = 'no_invoice';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'no_invoice',
        'id_pelanggan',
        'id_pegawai',
        'id_pg_kasir',
        'id_member',
        'id_reseller',
        'tanggal',
        'total_harga',
        'diskon',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member', 'id_member');
    }

    public function reseller()
    {
        return $this->belongsTo(Reseller::class, 'id_reseller', 'id_reseller');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }

    public function kasir()
    {
        return $this->belongsTo(Pegawai::class, 'id_pg_kasir', 'id_pegawai');
    }

    public function detail()
    {
        return $this->hasMany(DetailInvoice::class, 'no_invoice', 'no_invoice');
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'no_invoice', 'no_invoice');
    }
}

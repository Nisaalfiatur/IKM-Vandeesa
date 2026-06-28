<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailInvoice extends Model
{
    protected $table = 'detail_invoice';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'no_invoice',
        'id_item',
        'harga_perpcs',
        'quantity',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'no_invoice', 'no_invoice');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item', 'id_item');
    }
}

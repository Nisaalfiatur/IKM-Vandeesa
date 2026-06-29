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
        'id_pegawai',
        'id_pg_kasir',
        'id_member',
        'id_reseller',
        'nama_pelanggan_anonim',
        'tanggal',
        'total_harga',
        'diskon',
    ];

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

    public function getNamaPelangganAttribute(): string
    {
        if ($this->member) {
            return $this->member->nama;
        }
        if ($this->reseller) {
            return $this->reseller->nama;
        }
        if ($this->nama_pelanggan_anonim) {
            return $this->nama_pelanggan_anonim;
        }

        return 'N/A';
    }

    public function getNoTelpPelangganAttribute(): string
    {
        return $this->member?->no_telp
            ?? $this->reseller?->no_telp
            ?? '-';
    }

    public function getTipePelangganAttribute(): ?string
    {
        if ($this->member) {
            return 'Member';
        }
        if ($this->reseller) {
            return 'Reseller';
        }
        if ($this->nama_pelanggan_anonim) {
            return 'Non Member';
        }

        return null;
    }

    public static function parsePelangganInput(?string $raw): array
    {
        $id_member = null;
        $id_reseller = null;
        $nama_anonim = null;

        if ($raw) {
            [$type, $sourceId] = explode('_', $raw, 2);

            if ($type === 'member') {
                $id_member = $sourceId;
            } elseif ($type === 'reseller') {
                $id_reseller = $sourceId;
            }
        }

        return compact('id_member', 'id_reseller', 'nama_anonim');
    }

    public static function buildPelangganOptions(): \Illuminate\Support\Collection
    {
        $options = collect();

        foreach (Member::all() as $member) {
            $options->push([
                'value' => 'member_' . $member->id_member,
                'label' => $member->nama . ' (Member)',
            ]);
        }

        foreach (Reseller::all() as $reseller) {
            $options->push([
                'value' => 'reseller_' . $reseller->id_reseller,
                'label' => $reseller->nama . ' (Reseller)',
            ]);
        }

        return $options;
    }

    public function getPelangganSelectValue(): ?string
    {
        if ($this->id_member) {
            return 'member_' . $this->id_member;
        }
        if ($this->id_reseller) {
            return 'reseller_' . $this->id_reseller;
        }

        return null;
    }
}

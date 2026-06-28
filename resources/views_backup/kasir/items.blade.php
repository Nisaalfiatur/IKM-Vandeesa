@extends('layouts.app')

@section('content')
<div style="margin-bottom: 30px;">
    <h1>Katalog Item</h1>
    <p class="greeting">Pilih item untuk membuat invoice</p>
</div>

<div class="kasir-items-grid">
    @forelse($items as $item)
    <div class="kasir-card">
        <div class="kasir-card-image">
            @if($item->gambar)
                <img src="{{ asset('images/items/' . $item->gambar) }}" alt="{{ $item->nama_item }}">
            @else
                <div class="kasir-card-placeholder">
                    📦
                </div>
            @endif
        </div>

        <div class="kasir-card-body">
            <h3 class="kasir-card-title">{{ $item->nama_item }}</h3>
            <div class="kasir-card-id">ID: {{ $item->id_item }}</div>

            <div class="kasir-card-price">
                Rp {{ number_format($item->harga, 0, ',', '.') }}
            </div>

            <div class="kasir-card-stock">
                <span class="kasir-stock-badge @if($item->stok_item > 5) in-stock @elseif($item->stok_item > 0) low-stock @else out-stock @endif">
                    Stok: {{ $item->stok_item }}
                </span>
            </div>

            <a href="{{ route('kasir.item-detail', $item->id_item) }}" class="kasir-card-button">
                Lihat Detail
            </a>
        </div>
    </div>
    @empty
    <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #9CA3AF;">
        <div style="font-size: 48px; margin-bottom: 15px;">📭</div>
        <h3>Belum Ada Item</h3>
        <p>Tidak ada item yang tersedia saat ini.</p>
    </div>
    @endforelse
</div>

<style>
    .kasir-items-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .kasir-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(123, 92, 219, 0.08);
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        flex-direction: column;
    }

    .kasir-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 24px rgba(123, 92, 219, 0.15);
    }

    .kasir-card-image {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #F5F3FF 0%, #FAF9FF 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .kasir-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .kasir-card:hover .kasir-card-image img {
        transform: scale(1.05);
    }

    .kasir-card-placeholder {
        font-size: 64px;
    }

    .kasir-card-body {
        padding: 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .kasir-card-title {
        font-size: 15px;
        font-weight: 600;
        color: #1F2937;
        margin: 0 0 6px 0;
        line-height: 1.3;
    }

    .kasir-card-id {
        font-size: 12px;
        color: #9CA3AF;
        margin-bottom: 10px;
    }

    .kasir-card-price {
        font-size: 18px;
        font-weight: 700;
        color: #7C5CDB;
        margin-bottom: 10px;
    }

    .kasir-card-stock {
        margin-bottom: 12px;
    }

    .kasir-stock-badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
    }

    .kasir-stock-badge.in-stock {
        background: #DCFCE7;
        color: #166534;
    }

    .kasir-stock-badge.low-stock {
        background: #FEF3C7;
        color: #B45309;
    }

    .kasir-stock-badge.out-stock {
        background: #FEE2E2;
        color: #991B1B;
    }

    .kasir-card-button {
        display: block;
        text-align: center;
        padding: 10px;
        background: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: auto;
    }

    .kasir-card-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(123, 92, 219, 0.3);
    }

    @media (max-width: 768px) {
        .kasir-items-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
        }

        .kasir-card-image {
            height: 150px;
        }
    }
</style>
@endsection

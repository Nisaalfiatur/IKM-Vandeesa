@extends('layouts.app')

@section('content')
<a href="{{ route('kasir.items') }}" class="btn btn-secondary" style="margin-bottom: 20px;">
    ← Kembali ke Katalog
</a>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: start;">
    <!-- Image Section -->
    <div>
        <div style="background: linear-gradient(135deg, #F5F3FF 0%, #FAF9FF 100%); border-radius: 12px; padding: 20px; display: flex; align-items: center; justify-content: center; min-height: 400px; margin-bottom: 20px;">
            @if($item->gambar)
                <img src="{{ asset('images/items/' . $item->gambar) }}" alt="{{ $item->nama_item }}" style="max-width: 100%; max-height: 400px; border-radius: 8px;">
            @else
                <div style="font-size: 120px; opacity: 0.3;">📦</div>
            @endif
        </div>
    </div>

    <!-- Details Section -->
    <div>
        <h1 style="font-size: 32px; margin-bottom: 10px;">{{ $item->nama_item }}</h1>
        <div style="color: #9CA3AF; font-size: 14px; margin-bottom: 30px;">
            <strong>ID Item:</strong> {{ $item->id_item }}
        </div>

        <!-- Price Card -->
        <div style="background: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%); color: white; padding: 25px; border-radius: 12px; margin-bottom: 25px; box-shadow: 0 4px 12px rgba(123, 92, 219, 0.2);">
            <div style="font-size: 13px; opacity: 0.9; margin-bottom: 8px;">Harga Item</div>
            <div style="font-size: 36px; font-weight: 700;">Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
        </div>

        <!-- Stock Info -->
        <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #E9D5FF; margin-bottom: 25px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div style="font-size: 13px; color: #6B46C1; font-weight: 600; margin-bottom: 5px;">Stok Tersedia</div>
                    <div style="font-size: 28px; font-weight: 700; color: #7C5CDB;">
                        {{ $item->stok_item }}
                        @if($item->stok_item > 5)
                            <span style="font-size: 14px; color: #10B981; margin-left: 10px;">✓ Tersedia</span>
                        @elseif($item->stok_item > 0)
                            <span style="font-size: 14px; color: #F59E0B; margin-left: 10px;">⚠ Menipis</span>
                        @else
                            <span style="font-size: 14px; color: #EF4444; margin-left: 10px;">✗ Habis</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <a href="{{ route('invoice.create') }}" class="btn" style="text-align: center; padding: 15px;">
                📄 Buat Invoice
            </a>
            <a href="{{ route('kasir.items') }}" class="btn btn-secondary" style="text-align: center; padding: 15px;">
                🔍 Lihat Item Lain
            </a>
        </div>
    </div>
</div>

@endsection

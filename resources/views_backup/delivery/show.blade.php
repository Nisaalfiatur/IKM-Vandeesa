@extends('layouts.app')

@section('content')
<div>
    {{-- Header --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="margin: 0; font-size: 24px; color: #374151;">📋 Detail Delivery Order: {{ $delivery->no_do }}</h1>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('delivery.print', $delivery->no_do) }}" class="btn btn-info" target="_blank">
                🖨️ Cetak
            </a>
            <a href="{{ route('delivery.edit', $delivery->no_do) }}" class="btn btn-warning">
                ✏️ Edit
            </a>
            <a href="{{ route('delivery.index') }}" class="btn btn-secondary">
                ← Kembali
            </a>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- 2x2 Info Cards Grid --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">

        {{-- Card A: Informasi DO --}}
        <div class="card detail-card">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid #E9D5FF;">
                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px;">📦</div>
                <h3 style="margin: 0; color: #374151; font-size: 16px; font-weight: 700;">Informasi DO</h3>
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">NO DO</span>
                    <span class="info-value" style="font-weight: 700; color: #7C5CDB;">{{ $delivery->no_do }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">TANGGAL</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($delivery->tanggal)->format('d F Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">STATUS</span>
                    <span class="info-value">
                        @php
                            $statusClass = match($delivery->status) {
                                'Menunggu' => 'status-waiting',
                                'Diproses' => 'status-processing',
                                'Dikirim' => 'status-shipped',
                                'Selesai' => 'status-completed',
                                'Dibatalkan' => 'status-cancelled',
                                default => ''
                            };
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ $delivery->status }}</span>
                    </span>
                </div>
            </div>
        </div>

        {{-- Card B: Invoice Terkait --}}
        <div class="card detail-card">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid #E9D5FF;">
                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #4F46E5 0%, #3730A3 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px;">📄</div>
                <h3 style="margin: 0; color: #374151; font-size: 16px; font-weight: 700;">Invoice Terkait</h3>
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">NO INVOICE</span>
                    <span class="info-value">
                        <a href="{{ route('invoice.show', $delivery->invoice->no_invoice) }}" style="color: #7C5CDB; text-decoration: none; font-weight: 600; border-bottom: 1px dashed #7C5CDB;">
                            {{ $delivery->invoice->no_invoice }}
                        </a>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">PELANGGAN</span>
                    <span class="info-value">{{ $delivery->invoice->pelanggan->nama ?? 'N/A' }}</span>
                </div>
                <div class="info-item" style="grid-column: 1 / -1;">
                    <span class="info-label">TOTAL INVOICE</span>
                    <span class="info-value" style="color: #7C5CDB; font-weight: 700; font-size: 18px;">
                        Rp {{ number_format($delivery->invoice->total_harga, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Card C: Reseller --}}
        <div class="card detail-card" style="grid-column: 1 / -1;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid #E9D5FF;">
                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #10B981 0%, #059669 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px;">🏪</div>
                <h3 style="margin: 0; color: #374151; font-size: 16px; font-weight: 700;">Reseller</h3>
            </div>
            <div class="info-grid" style="grid-template-columns: repeat(4, 1fr);">
                <div class="info-item">
                    <span class="info-label">ID RESELLER</span>
                    <span class="info-value" style="font-weight: 600;">{{ $delivery->reseller->id_reseller ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">NAMA</span>
                    <span class="info-value">{{ $delivery->reseller->nama ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">BRAND</span>
                    <span class="info-value">{{ $delivery->reseller->brand ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">NO TELP</span>
                    <span class="info-value">{{ $delivery->reseller->no_telpn ?? 'N/A' }}</span>
                </div>
                <div class="info-item" style="grid-column: 1 / -1;">
                    <span class="info-label">ALAMAT</span>
                    <span class="info-value">{{ $delivery->reseller->alamat ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">EMAIL</span>
                    <span class="info-value">{{ $delivery->reseller->email ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        {{-- Card D: Pegawai --}}
        {{-- We need to reset to 2-col, but since the reseller card spans full width, this card sits below --}}
    </div>

    {{-- Pegawai Card (separate row for clean layout) --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; margin-top: -10px;">
        <div class="card detail-card">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid #E9D5FF;">
                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px;">👤</div>
                <h3 style="margin: 0; color: #374151; font-size: 16px; font-weight: 700;">Pegawai</h3>
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">ID PEGAWAI</span>
                    <span class="info-value" style="font-weight: 600;">{{ $delivery->pegawai->id_pegawai ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">NAMA</span>
                    <span class="info-value">{{ $delivery->pegawai->nama_pg ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">JABATAN</span>
                    <span class="info-value">{{ $delivery->pegawai->jabatan ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Items Table --}}
    <div class="card detail-card">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid #E9D5FF;">
            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px;">🛒</div>
            <h3 style="margin: 0; color: #374151; font-size: 16px; font-weight: 700;">Detail Item Pengiriman</h3>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 60px; text-align: center;">No</th>
                    <th>Nama Item</th>
                    <th style="text-align: center; width: 100px;">Qty</th>
                    <th style="text-align: right; width: 180px;">Harga Per PCS</th>
                    <th style="text-align: right; width: 180px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($delivery->invoice->detail as $index => $detail)
                <tr>
                    <td style="text-align: center; font-weight: 600; color: #9CA3AF;">{{ $index + 1 }}</td>
                    <td><strong style="color: #374151;">{{ $detail->item->nama_item ?? 'N/A' }}</strong></td>
                    <td style="text-align: center;">
                        <span style="background: #F5F3FF; color: #7C5CDB; padding: 4px 12px; border-radius: 6px; font-weight: 600;">{{ $detail->quantity }}</span>
                    </td>
                    <td style="text-align: right;">Rp {{ number_format($detail->harga_perpcs, 0, ',', '.') }}</td>
                    <td style="text-align: right; color: #7C5CDB; font-weight: 700;">
                        Rp {{ number_format($detail->harga_perpcs * $detail->quantity, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #9CA3AF; padding: 40px;">
                        <div style="font-size: 32px; margin-bottom: 8px;">📭</div>
                        Belum ada item dalam invoice terkait
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($delivery->invoice->detail && count($delivery->invoice->detail) > 0)
        <div style="text-align: right; margin-top: 20px; padding-top: 20px; border-top: 2px solid #E9D5FF;">
            <p style="font-size: 18px; font-weight: 700; margin: 0; color: #374151;">
                Total: <span style="color: #7C5CDB; font-size: 22px;">Rp {{ number_format($delivery->invoice->total_harga, 0, ',', '.') }}</span>
            </p>
        </div>
        @endif
    </div>

    {{-- Bottom Actions --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 30px;">
        <a href="{{ route('delivery.delete', $delivery->no_do) }}" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus delivery order ini? Data yang dihapus tidak dapat dikembalikan.')">
            🗑️ Hapus Delivery Order
        </a>
        <a href="{{ route('delivery.index') }}" class="btn btn-secondary">
            ← Kembali ke Daftar
        </a>
    </div>
</div>

<style>
    .btn {
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-info {
        background: #E0E7FF;
        color: #4F46E5;
    }

    .btn-info:hover {
        background: #C7D2FE;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
    }

    .btn-warning {
        background: #FEF3C7;
        color: #B45309;
    }

    .btn-warning:hover {
        background: #FDE68A;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.15);
    }

    .btn-secondary {
        background: #F3F4F6;
        color: #6B7280;
    }

    .btn-secondary:hover {
        background: #E5E7EB;
        transform: translateY(-1px);
    }

    .btn-danger {
        background: #FEE2E2;
        color: #DC2626;
        font-weight: 600;
    }

    .btn-danger:hover {
        background: #FECACA;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    }

    .detail-card {
        background: white;
        border-radius: 14px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04);
        border: 1px solid #F3F4F6;
        transition: all 0.3s ease;
    }

    .detail-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(124, 92, 219, 0.1), 0 4px 10px rgba(0, 0, 0, 0.04);
        border-color: #E9D5FF;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .info-label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: #9CA3AF;
    }

    .info-value {
        font-size: 14px;
        color: #374151;
        font-weight: 500;
    }

    .alert-success {
        background: linear-gradient(135deg, #DCFCE7 0%, #D1FAE5 100%);
        color: #166534;
        padding: 14px 18px;
        border-radius: 10px;
        margin-bottom: 24px;
        border-left: 4px solid #10B981;
        font-weight: 500;
        font-size: 14px;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .status-waiting {
        background: #FEF3C7;
        color: #B45309;
    }

    .status-processing {
        background: #DBEAFE;
        color: #1E40AF;
    }

    .status-shipped {
        background: #E0E7FF;
        color: #3730A3;
    }

    .status-completed {
        background: #DCFCE7;
        color: #166534;
    }

    .status-cancelled {
        background: #FEE2E2;
        color: #991B1B;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 14px 16px;
        text-align: left;
        border-bottom: 1px solid #F3F4F6;
    }

    th {
        background: linear-gradient(135deg, #F9FAFB 0%, #F5F3FF 100%);
        font-weight: 700;
        color: #374151;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    tbody tr {
        transition: all 0.2s ease;
    }

    tbody tr:hover {
        background: #F5F3FF;
    }
</style>
@endsection

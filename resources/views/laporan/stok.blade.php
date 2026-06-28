@extends('layouts.app')

@section('content')
<style>
    /* Analytics Dashboard Styles */
    .analytics-container {
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        color: #1e293b;
        max-width: 1400px;
        margin: 0 auto;
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Header Section */
    .analytics-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .analytics-title-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: #64748b;
        font-weight: 500;
    }

    .breadcrumb-active {
        color: #8B7CF6;
        background: #F3F0FF;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .title-icon-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #10B981, #059669);
        border-radius: 14px;
        color: white;
        box-shadow: 0 8px 16px rgba(16, 185, 129, 0.25);
    }

    .page-subtitle {
        font-size: 1rem;
        color: #64748b;
        margin: 0;
        margin-left: 60px;
    }

    /* KPI Cards */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .kpi-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        border: 1px solid #f1f5f9;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }

    .kpi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.06);
        border-color: #e2e8f0;
    }

    .kpi-icon-wrapper {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .kpi-content {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .kpi-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #64748b;
    }

    .kpi-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
    }

    .kpi-trend {
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
        margin-top: 4px;
    }

    .trend-neutral { color: #64748b; }
    .trend-warning { color: #D97706; }

    /* Layout Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
    }

    @media (max-width: 1024px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Content Cards */
    .content-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        border: 1px solid #f1f5f9;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .card-header {
        padding: 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #ffffff;
    }

    .card-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Modern Table Styles */
    .table-container {
        overflow-x: auto;
    }

    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .modern-table th {
        background: #f8fafc;
        color: #64748b;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 1rem 1.5rem;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }

    .modern-table td {
        padding: 1rem 1.5rem;
        font-size: 0.875rem;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        transition: background-color 0.2s;
    }

    .modern-table tr:last-child td {
        border-bottom: none;
    }

    .modern-table tbody tr:hover td {
        background-color: #f8fafc;
    }

    /* Badges & Entity Infos */
    .entity-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .entity-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .entity-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .entity-name {
        font-weight: 600;
        color: #1e293b;
    }
    
    .entity-sub {
        font-size: 0.75rem;
        color: #64748b;
        margin-top: 2px;
    }

    .money-value {
        font-weight: 700;
        color: #0f172a;
    }

    .stock-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.8125rem;
    }

    .stock-safe {
        background: #ECFDF5;
        color: #059669;
        border: 1px solid #A7F3D0;
    }

    .stock-warning {
        background: #FFFBEB;
        color: #D97706;
        border: 1px solid #FDE68A;
    }

    .stock-danger {
        background: #FEF2F2;
        color: #DC2626;
        border: 1px solid #FECACA;
    }

    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
        color: #94a3b8;
    }
    
    .empty-state i {
        width: 48px;
        height: 48px;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }
</style>

<div class="analytics-container">
    
    {{-- Header Section --}}
    <div class="analytics-header">
        <div class="analytics-title-group">
            <div class="breadcrumb">
                <span>Dashboard</span>
                <i data-lucide="chevron-right" style="width: 14px; height: 14px;"></i>
                <span>Laporan</span>
                <i data-lucide="chevron-right" style="width: 14px; height: 14px;"></i>
                <span class="breadcrumb-active">Stok & Aset</span>
            </div>
            <h1 class="page-title">
                <div class="title-icon-wrapper">
                    <i data-lucide="boxes" style="width: 24px; height: 24px;"></i>
                </div>
                Laporan Stok & Aset
            </h1>
            <p class="page-subtitle">Pantau ketersediaan barang dan valuasi aset secara real-time.</p>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="kpi-grid">
        <!-- Asset Value Card -->
        <div class="kpi-card">
            <div class="kpi-icon-wrapper" style="background: linear-gradient(135deg, #EEF2FF, #E0E7FF); color: #4F46E5;">
                <i data-lucide="coins" style="width: 28px; height: 28px;"></i>
            </div>
            <div class="kpi-content">
                <div class="kpi-label">Total Nilai Aset</div>
                <div class="kpi-value">Rp {{ number_format($totalAset, 0, ',', '.') }}</div>
                <div class="kpi-trend trend-neutral">
                    <i data-lucide="calculator" style="width: 12px; height: 12px;"></i>
                    Valuasi (Stok × Harga Beli)
                </div>
            </div>
        </div>

        <!-- Total Stock Card -->
        <div class="kpi-card">
            <div class="kpi-icon-wrapper" style="background: linear-gradient(135deg, #F0FDF4, #DCFCE7); color: #16A34A;">
                <i data-lucide="package-check" style="width: 28px; height: 28px;"></i>
            </div>
            <div class="kpi-content">
                <div class="kpi-label">Total Volume Stok</div>
                <div class="kpi-value">{{ number_format($totalStok) }} <span style="font-size:1rem;color:#94a3b8;font-weight:600;">Unit</span></div>
                <div class="kpi-trend trend-neutral">
                    <i data-lucide="layers" style="width: 12px; height: 12px;"></i>
                    Seluruh kategori
                </div>
            </div>
        </div>

        <!-- Low Stock Warning Card -->
        <div class="kpi-card">
            <div class="kpi-icon-wrapper" style="background: linear-gradient(135deg, #FEF2F2, #FEE2E2); color: #DC2626;">
                <i data-lucide="alert-triangle" style="width: 28px; height: 28px;"></i>
            </div>
            <div class="kpi-content">
                <div class="kpi-label">Peringatan Stok Tipis</div>
                <div class="kpi-value" style="color: #DC2626;">{{ $lowStockCount }} <span style="font-size:1rem;color:#FCA5A5;font-weight:600;">Item</span></div>
                <div class="kpi-trend trend-warning">
                    <i data-lucide="info" style="width: 12px; height: 12px;"></i>
                    Stok kurang dari 10 unit
                </div>
            </div>
        </div>
    </div>

    {{-- Content Area --}}
    <div class="dashboard-grid">
        
        {{-- Left Column: Main Table --}}
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i data-lucide="database" style="color: #10B981; width: 20px; height: 20px;"></i>
                    Rincian Valuasi Stok
                </h3>
            </div>
            <div class="table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Kategori</th>
                            <th>Sisa Stok</th>
                            <th style="text-align: right;">Harga</th>
                            <th style="text-align: right;">Nilai Aset</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                        <tr>
                            <td>
                                <div class="entity-group">
                                    <div class="entity-avatar">
                                        @if($item->gambar)
                                            <img src="{{ asset('images/items/' . $item->gambar) }}" alt="{{ $item->nama_item }}">
                                        @else
                                            <i data-lucide="image" style="width: 16px; height: 16px; color: #94a3b8;"></i>
                                        @endif
                                    </div>
                                    <div style="display: flex; flex-direction: column;">
                                        <span class="entity-name">{{ $item->nama_item }}</span>
                                        <span class="entity-sub">{{ $item->id_item }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="color: #64748b; font-weight: 500;">{{ $item->kategori->nama_kategori ?? '-' }}</span>
                            </td>
                            <td>
                                @php
                                    $stockClass = 'stock-safe';
                                    if($item->stok_item == 0) $stockClass = 'stock-danger';
                                    elseif($item->stok_item < 10) $stockClass = 'stock-warning';
                                @endphp
                                <span class="stock-badge {{ $stockClass }}">{{ $item->stok_item }}</span>
                            </td>
                            <td style="text-align: right;">
                                <span style="color: #64748b; font-weight: 500;">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                            </td>
                            <td style="text-align: right;">
                                <span class="money-value">Rp {{ number_format($item->stok_item * $item->harga, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i data-lucide="package-open"></i>
                                    <h4>Tidak Ada Data Item</h4>
                                    <p>Sistem belum memiliki data item atau stok saat ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Right Column: Need Restock --}}
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i data-lucide="alert-circle" style="color: #EF4444; width: 20px; height: 20px;"></i>
                    Perlu Restock Segera
                </h3>
            </div>
            <div class="table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th style="text-align: right;">Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $needRestock = $items->where('stok_item', '<', 10)->sortBy('stok_item')->take(7);
                        @endphp
                        @forelse($needRestock as $item)
                        <tr>
                            <td>
                                <div class="entity-group">
                                    <div class="entity-avatar" style="width: 32px; height: 32px;">
                                        @if($item->gambar)
                                            <img src="{{ asset('images/items/' . $item->gambar) }}" alt="{{ $item->nama_item }}">
                                        @else
                                            <i data-lucide="image" style="width: 14px; height: 14px; color: #94a3b8;"></i>
                                        @endif
                                    </div>
                                    <div style="display: flex; flex-direction: column; max-width: 140px;">
                                        <span class="entity-name" style="font-size: 0.8125rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $item->nama_item }}</span>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: right;">
                                @php
                                    $badgeClass = $item->stok_item == 0 ? 'stock-danger' : 'stock-warning';
                                @endphp
                                <span class="stock-badge {{ $badgeClass }}" style="padding: 2px 6px; font-size: 0.75rem;">
                                    {{ $item->stok_item }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2">
                                <div class="empty-state" style="padding: 3rem 1rem;">
                                    <i data-lucide="check-circle-2" style="color: #10B981;"></i>
                                    <p>Semua stok aman!</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($needRestock->count() > 0)
            <div style="padding: 1rem; text-align: center; border-top: 1px solid #f1f5f9; background: #f8fafc;">
                <span style="font-size: 0.8125rem; font-weight: 600; color: #EF4444;">
                    Harap segera lakukan pemesanan ulang (restock)
                </span>
            </div>
            @endif
        </div>

    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection

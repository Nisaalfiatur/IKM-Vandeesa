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
        background: linear-gradient(135deg, #8B7CF6, #6D28D9);
        border-radius: 14px;
        color: white;
        box-shadow: 0 8px 16px rgba(139, 124, 246, 0.25);
    }

    .page-subtitle {
        font-size: 1rem;
        color: #64748b;
        margin: 0;
        margin-left: 60px; /* Aligned with text, skipping icon */
    }

    /* Filter Card */
    .filter-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 1.25rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border: 1px solid #f1f5f9;
        display: inline-block;
    }

    .filter-form {
        display: flex;
        gap: 1rem;
        align-items: flex-end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .filter-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #94a3b8;
    }

    .filter-input {
        padding: 0.6rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.875rem;
        color: #334155;
        background: #f8fafc;
        outline: none;
        transition: all 0.2s;
        font-family: inherit;
        font-weight: 500;
    }

    .filter-input:focus {
        border-color: #8B7CF6;
        box-shadow: 0 0 0 3px rgba(139, 124, 246, 0.1);
        background: #ffffff;
    }

    .btn-filter {
        background: #1e293b;
        color: white;
        border: none;
        padding: 0.7rem 1.25rem;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-filter:hover {
        background: #0f172a;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
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

    .trend-up { color: #10B981; }
    .trend-neutral { color: #64748b; }

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
    .badge-primary {
        background: #EEF2FF;
        color: #4F46E5;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.8125rem;
        text-decoration: none;
        display: inline-block;
        font-family: 'Courier New', Courier, monospace;
    }

    .badge-primary:hover {
        background: #E0E7FF;
    }

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

    .date-text {
        color: #64748b;
        font-weight: 500;
    }

    .qty-badge {
        background: #ECFDF5;
        color: #059669;
        padding: 4px 8px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.75rem;
        border: 1px solid #A7F3D0;
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
                <span class="breadcrumb-active">Penjualan</span>
            </div>
            <h1 class="page-title">
                <div class="title-icon-wrapper">
                    <i data-lucide="trending-up" style="width: 24px; height: 24px;"></i>
                </div>
                Laporan Penjualan
            </h1>
            <p class="page-subtitle">Analisis performa pendapatan, volume transaksi, dan tren produk terlaris.</p>
        </div>

        {{-- Filter Card --}}
        <div class="filter-card">
            <form method="GET" action="{{ route('laporan.penjualan') }}" class="filter-form">
                <div class="filter-group">
                    <label class="filter-label">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="filter-input">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Tanggal Selesai</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="filter-input">
                </div>
                <button type="submit" class="btn-filter">
                    <i data-lucide="list-filter" style="width: 16px; height: 16px;"></i>
                    Apply Filter
                </button>
            </form>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="kpi-grid">
        <!-- Revenue Card -->
        <div class="kpi-card">
            <div class="kpi-icon-wrapper" style="background: linear-gradient(135deg, #EEF2FF, #E0E7FF); color: #4F46E5;">
                <i data-lucide="wallet" style="width: 28px; height: 28px;"></i>
            </div>
            <div class="kpi-content">
                <div class="kpi-label">Total Pendapatan</div>
                <div class="kpi-value">Rp {{ number_format($totalOmset, 0, ',', '.') }}</div>
                <div class="kpi-trend trend-neutral">
                    <i data-lucide="calendar" style="width: 12px; height: 12px;"></i>
                    Berdasarkan periode filter
                </div>
            </div>
        </div>

        <!-- Transactions Card -->
        <div class="kpi-card">
            <div class="kpi-icon-wrapper" style="background: linear-gradient(135deg, #F0FDF4, #DCFCE7); color: #16A34A;">
                <i data-lucide="receipt" style="width: 28px; height: 28px;"></i>
            </div>
            <div class="kpi-content">
                <div class="kpi-label">Total Transaksi</div>
                <div class="kpi-value">{{ number_format($totalTransaksi) }} <span style="font-size:1rem;color:#94a3b8;font-weight:600;">Inv</span></div>
                <div class="kpi-trend trend-neutral">
                    <i data-lucide="check-circle-2" style="width: 12px; height: 12px;"></i>
                    Transaksi berhasil
                </div>
            </div>
        </div>

        <!-- Items Sold Card -->
        <div class="kpi-card">
            <div class="kpi-icon-wrapper" style="background: linear-gradient(135deg, #FFFBEB, #FEF3C7); color: #D97706;">
                <i data-lucide="package" style="width: 28px; height: 28px;"></i>
            </div>
            <div class="kpi-content">
                <div class="kpi-label">Volume Barang Terjual</div>
                <div class="kpi-value">{{ number_format($soldItems->sum('total_qty')) }} <span style="font-size:1rem;color:#94a3b8;font-weight:600;">Pcs</span></div>
                <div class="kpi-trend trend-neutral">
                    <i data-lucide="bar-chart-2" style="width: 12px; height: 12px;"></i>
                    Akumulasi item
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
                    <i data-lucide="file-text" style="color: #8B7CF6; width: 20px; height: 20px;"></i>
                    Riwayat Transaksi
                </h3>
            </div>
            <div class="table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>No Invoice</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th style="text-align: right;">Total Transaksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $inv)
                        <tr>
                            <td style="color: #94a3b8; font-weight: 600;">{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('invoice.show', $inv->no_invoice) }}" class="badge-primary">
                                    {{ $inv->no_invoice }}
                                </a>
                            </td>
                            <td>
                                <div class="entity-group">
                                    <div class="entity-avatar" style="background: #f8fafc; color: #64748b;">
                                        <i data-lucide="user" style="width: 18px; height: 18px;"></i>
                                    </div>
                                    <span class="entity-name">{{ $inv->pelanggan->nama ?? 'Umum / Guest' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="date-text">{{ \Carbon\Carbon::parse($inv->tanggal)->format('d M Y') }}</span>
                            </td>
                            <td style="text-align: right;">
                                <span class="money-value">Rp {{ number_format($inv->total_harga, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i data-lucide="inbox"></i>
                                    <h4>Tidak Ada Transaksi</h4>
                                    <p>Belum ada data transaksi yang tercatat pada rentang tanggal ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Right Column: Top Products --}}
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i data-lucide="award" style="color: #F59E0B; width: 20px; height: 20px;"></i>
                    Produk Terlaris
                </h3>
            </div>
            <div class="table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th style="text-align: right;">Performa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($soldItems->take(7) as $sold)
                        <tr>
                            <td>
                                <div class="entity-group">
                                    <div class="entity-avatar">
                                        @if($sold->item && $sold->item->gambar)
                                            <img src="{{ asset('images/items/' . $sold->item->gambar) }}" alt="{{ $sold->item->nama_item }}">
                                        @else
                                            <i data-lucide="image" style="width: 16px; height: 16px; color: #94a3b8;"></i>
                                        @endif
                                    </div>
                                    <div style="display: flex; flex-direction: column; max-width: 140px;">
                                        <span class="entity-name" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $sold->item->nama_item ?? 'Item Terhapus' }}
                                        </span>
                                        <span class="entity-sub">Rp {{ number_format($sold->total_omset, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <span class="qty-badge">{{ $sold->total_qty }} terjual</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2">
                                <div class="empty-state" style="padding: 3rem 1rem;">
                                    <i data-lucide="package-x"></i>
                                    <p>Data item kosong</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($soldItems->count() > 7)
            <div style="padding: 1rem; text-align: center; border-top: 1px solid #f1f5f9; background: #f8fafc;">
                <span style="font-size: 0.8125rem; font-weight: 600; color: #64748b;">Menampilkan 7 teratas dari {{ $soldItems->count() }} item</span>
            </div>
            @endif
        </div>

    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection

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
        background: linear-gradient(135deg, #F59E0B, #D97706);
        border-radius: 14px;
        color: white;
        box-shadow: 0 8px 16px rgba(245, 158, 11, 0.25);
    }

    .page-subtitle {
        font-size: 1rem;
        color: #64748b;
        margin: 0;
        margin-left: 60px;
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
        border-color: #F59E0B;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
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
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
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
        width: 56px;
        height: 56px;
        border-radius: 16px;
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

    /* Layout Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr;
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

    /* Badges */
    .badge-primary {
        background: #FFFBEB;
        color: #D97706;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.8125rem;
        text-decoration: none;
        display: inline-block;
        font-family: 'Courier New', Courier, monospace;
    }

    .badge-primary:hover {
        background: #FEF3C7;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .status-diproses {
        background: #EFF6FF;
        color: #3B82F6;
        border: 1px solid #BFDBFE;
    }

    .status-dikirim {
        background: #FFFBEB;
        color: #F59E0B;
        border: 1px solid #FDE68A;
    }

    .status-selesai {
        background: #ECFDF5;
        color: #10B981;
        border: 1px solid #A7F3D0;
    }

    .status-dibatalkan {
        background: #FEF2F2;
        color: #EF4444;
        border: 1px solid #FECACA;
    }

    .date-text {
        color: #64748b;
        font-weight: 500;
    }

    .courier-name {
        font-weight: 600;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 6px;
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

    /* Chart/Progress Bars for Courier */
    .courier-perf-item {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .courier-perf-item:last-child {
        border-bottom: none;
    }

    .courier-perf-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
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
                <span class="breadcrumb-active">Delivery Order</span>
            </div>
            <h1 class="page-title">
                <div class="title-icon-wrapper">
                    <i data-lucide="truck" style="width: 24px; height: 24px;"></i>
                </div>
                Laporan Delivery
            </h1>
            <p class="page-subtitle">Pantau status pengiriman dan riwayat delivery order.</p>
        </div>

        {{-- Filter Card --}}
        <div class="filter-card">
            <form method="GET" action="{{ route('laporan.delivery') }}" class="filter-form">
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
        <!-- Total Delivery -->
        <div class="kpi-card">
            <div class="kpi-icon-wrapper" style="background: linear-gradient(135deg, #F3F4F6, #E5E7EB); color: #374151;">
                <i data-lucide="truck" style="width: 24px; height: 24px;"></i>
            </div>
            <div class="kpi-content">
                <div class="kpi-label">Total Delivery</div>
                <div class="kpi-value">{{ $totalDelivery }}</div>
            </div>
        </div>

        <!-- Proses -->
        <div class="kpi-card">
            <div class="kpi-icon-wrapper" style="background: linear-gradient(135deg, #EFF6FF, #DBEAFE); color: #3B82F6;">
                <i data-lucide="package" style="width: 24px; height: 24px;"></i>
            </div>
            <div class="kpi-content">
                <div class="kpi-label">Diproses</div>
                <div class="kpi-value">{{ $statusCounts['Diproses'] ?? 0 }}</div>
            </div>
        </div>

        <!-- Dikirim -->
        <div class="kpi-card">
            <div class="kpi-icon-wrapper" style="background: linear-gradient(135deg, #FFFBEB, #FEF3C7); color: #F59E0B;">
                <i data-lucide="navigation" style="width: 24px; height: 24px;"></i>
            </div>
            <div class="kpi-content">
                <div class="kpi-label">Sedang Dikirim</div>
                <div class="kpi-value">{{ $statusCounts['Dikirim'] ?? 0 }}</div>
            </div>
        </div>

        <!-- Selesai -->
        <div class="kpi-card">
            <div class="kpi-icon-wrapper" style="background: linear-gradient(135deg, #F0FDF4, #DCFCE7); color: #10B981;">
                <i data-lucide="check-circle-2" style="width: 24px; height: 24px;"></i>
            </div>
            <div class="kpi-content">
                <div class="kpi-label">Selesai</div>
                <div class="kpi-value">{{ $statusCounts['Selesai'] ?? 0 }}</div>
            </div>
        </div>
    </div>

    {{-- Content Area --}}
    <div class="dashboard-grid">
        
        {{-- Left Column: Main Table --}}
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i data-lucide="map-pin" style="color: #F59E0B; width: 20px; height: 20px;"></i>
                    Riwayat Pengiriman
                </h3>
            </div>
            <div class="table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>No DO</th>
                            <th>Tanggal</th>
                            <th>No Invoice</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deliveries as $do)
                        <tr>
                            <td>
                                <a href="{{ route('delivery.show', $do->no_do) }}" class="badge-primary">
                                    {{ $do->no_do }}
                                </a>
                            </td>
                            <td>
                                <span class="date-text">{{ \Carbon\Carbon::parse($do->tanggal)->format('d M Y') }}</span>
                            </td>
                            <td>
                                @if($do->no_invoice)
                                    <span style="font-family: monospace; font-size: 0.8125rem; color: #64748b; background: #f8fafc; padding: 2px 6px; border-radius: 4px; border: 1px solid #e2e8f0;">
                                        {{ $do->no_invoice }}
                                    </span>
                                @else
                                    <span style="color: #94a3b8;">-</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusClass = 'status-diproses';
                                    $icon = 'package';
                                    if(strtolower($do->status) == 'dikirim') {
                                        $statusClass = 'status-dikirim';
                                        $icon = 'navigation';
                                    } elseif(strtolower($do->status) == 'selesai') {
                                        $statusClass = 'status-selesai';
                                        $icon = 'check-circle-2';
                                    } elseif(strtolower($do->status) == 'dibatalkan') {
                                        $statusClass = 'status-dibatalkan';
                                        $icon = 'x-circle';
                                    }
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    <i data-lucide="{{ $icon }}" style="width: 12px; height: 12px;"></i>
                                    {{ $do->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <i data-lucide="inbox"></i>
                                    <h4>Tidak Ada Delivery Order</h4>
                                    <p>Belum ada data pengiriman yang tercatat pada rentang tanggal ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection

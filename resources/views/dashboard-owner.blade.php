@extends('layouts.app')

@section('content')
<style>
    /* Gen Z Aesthetic CSS */
    .dashboard-container {
        font-family: 'Inter', 'Segoe UI', sans-serif;
        color: #333;
        padding: 20px;
    }
    .header-title {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #7C5CDB, #6B46C1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .header-subtitle {
        color: #888;
        font-size: 1.1rem;
        margin-bottom: 30px;
    }
    .grid-2 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .grid-5 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }
    .card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(123, 92, 219, 0.08);
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(123, 92, 219, 0.15);
    }
    .metric-card {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .metric-icon {
        font-size: 3rem;
        margin-bottom: 10px;
        animation: float 3s ease-in-out infinite;
    }
    .metric-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #555;
        margin-bottom: 5px;
    }
    .metric-value {
        font-size: 2rem;
        font-weight: 800;
        color: #6B46C1;
    }
    .metric-subtitle {
        font-size: 0.9rem;
        color: #9CA3AF;
        margin-top: 5px;
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    @keyframes bounce-sm {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #4B5563;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .gradient-card {
        background: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%);
        color: white;
        border: none;
    }
    .gradient-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(123, 92, 219, 0.3);
    }
    .gradient-card .stat-value {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 5px;
        text-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .gradient-card .stat-label {
        font-size: 1rem;
        opacity: 0.9;
        font-weight: 500;
    }

    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
    }
    .custom-table th {
        text-align: left;
        padding: 15px;
        color: #6B7280;
        font-weight: 600;
        border-bottom: 2px solid #F3F4F6;
    }
    .custom-table td {
        padding: 15px;
        background: #fff;
        transition: all 0.2s;
    }
    .custom-table tr.table-row td:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }
    .custom-table tr.table-row td:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }
    .custom-table tr.table-row:hover td {
        background: #F5F3FF;
        transform: scale(1.01);
    }
    
    .status-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }
    .status-waiting { background: #FEF3C7; color: #D97706; }
    .status-processing { background: #DBEAFE; color: #2563EB; }
    .status-shipped { background: #EDE9FE; color: #7C5CDB; }
    .status-completed { background: #D1FAE5; color: #059669; }
    .status-cancelled { background: #FEE2E2; color: #DC2626; }

    .btn-primary {
        background: linear-gradient(135deg, #7C5CDB, #6B46C1);
        color: white;
        padding: 12px 24px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 4px 15px rgba(123, 92, 219, 0.3);
    }
    .btn-primary:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 6px 20px rgba(123, 92, 219, 0.4);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        background: rgba(255,255,255,0.5);
        border-radius: 16px;
        border: 2px dashed #DDD6FE;
    }
    .empty-icon {
        font-size: 4rem;
        margin-bottom: 15px;
        display: inline-block;
        animation: bounce-sm 2s infinite;
    }
    
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        text-align: center;
    }
    @media (max-width: 768px) {
        .summary-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-container">
    <h1 class="header-title">👋 Dashboard Owner</h1>
    <p class="header-subtitle">Ringkasan bisnis Anda secara keseluruhan ✨</p>

    <!-- Main Metrics Grid -->
    <div class="grid-2">
        <div class="card metric-card">
            <div class="metric-icon">💰</div>
            <h3 class="metric-title">Total Penjualan</h3>
            <div class="metric-value">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
            <span class="metric-subtitle">Semua transaksi berjalan</span>
        </div>

        <div class="card metric-card">
            <div class="metric-icon">📄</div>
            <h3 class="metric-title">Total Invoice</h3>
            <div class="metric-value" style="font-size: 2.5rem;">{{ $jumlahInvoice }}</div>
            <span class="metric-subtitle">Dokumen penjualan tercatat</span>
        </div>
    </div>

    <!-- Delivery Overview -->
    <h2 class="section-title">📋 Status Pengiriman</h2>
    <div class="grid-5">
        <div class="card metric-card" style="padding: 20px 10px;">
            <div class="metric-icon" style="font-size: 2rem;">⏳</div>
            <h3 class="metric-title" style="font-size: 1rem;">Menunggu</h3>
            <div class="metric-value" style="color: #F59E0B; font-size: 1.8rem;">{{ $deliveryMenunggu }}</div>
        </div>

        <div class="card metric-card" style="padding: 20px 10px;">
            <div class="metric-icon" style="font-size: 2rem;">⚙️</div>
            <h3 class="metric-title" style="font-size: 1rem;">Diproses</h3>
            <div class="metric-value" style="color: #3B82F6; font-size: 1.8rem;">{{ $deliveryDiproses }}</div>
        </div>

        <div class="card metric-card" style="padding: 20px 10px;">
            <div class="metric-icon" style="font-size: 2rem;">🚚</div>
            <h3 class="metric-title" style="font-size: 1rem;">Dikirim</h3>
            <div class="metric-value" style="color: #8B5CF6; font-size: 1.8rem;">{{ $deliveryDikirim }}</div>
        </div>

        <div class="card metric-card" style="padding: 20px 10px;">
            <div class="metric-icon" style="font-size: 2rem;">✅</div>
            <h3 class="metric-title" style="font-size: 1rem;">Selesai</h3>
            <div class="metric-value" style="color: #10B981; font-size: 1.8rem;">{{ $deliverySelesai }}</div>
        </div>

        <div class="card metric-card" style="padding: 20px 10px;">
            <div class="metric-icon" style="font-size: 2rem;">❌</div>
            <h3 class="metric-title" style="font-size: 1rem;">Dibatalkan</h3>
            <div class="metric-value" style="color: #EF4444; font-size: 1.8rem;">{{ $deliveryDibatalkan }}</div>
        </div>
    </div>

    <!-- Summary Card -->
    <div class="card gradient-card" style="margin-top: 40px; margin-bottom: 40px;">
        <div class="summary-grid">
            <div>
                <div class="stat-value">{{ $jumlahInvoice }}</div>
                <div class="stat-label">Invoice Aktif 📝</div>
            </div>
            <div>
                <div class="stat-value">{{ $jumlahDelivery }}</div>
                <div class="stat-label">Pengiriman 📦</div>
            </div>
            <div>
                <div class="stat-value" style="font-size: 2.2rem; line-height: 1.3;">Rp {{ number_format($totalPenjualan / max($jumlahInvoice, 1), 0, ',', '.') }}</div>
                <div class="stat-label">Avg. per Invoice 💸</div>
            </div>
        </div>
    </div>

    <!-- Invoice Terbaru -->
    <h2 class="section-title">📊 Invoice Terbaru</h2>
    <div class="card" style="margin-bottom: 40px; padding: 20px; border: none; box-shadow: none; background: transparent;">
        @if(count($invoiceTerbaru) > 0)
        <table class="custom-table">
            <thead>
                <tr>
                    <th>No Invoice</th>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoiceTerbaru as $invoice)
                <tr class="table-row">
                    <td><strong>{{ $invoice->no_invoice }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($invoice->tanggal)->format('d M Y') }}</td>
                    <td style="color: #7C5CDB; font-weight: 700;">Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <span class="empty-icon">📭</span>
            <h3 style="color: #6B46C1; margin-bottom: 10px;">Belum Ada Invoice</h3>
            <p style="color: #6B7280; margin-bottom: 20px;">Sepertinya belum ada transaksi penjualan yang tercatat.</p>
        </div>
        @endif
    </div>

    <!-- Delivery Status -->
    <h2 class="section-title">🚀 Pengiriman Terbaru</h2>
    <div class="card" style="margin-bottom: 40px; padding: 20px; border: none; box-shadow: none; background: transparent;">
        @if(count($deliveryTerbaru) > 0)
        <table class="custom-table">
            <thead>
                <tr>
                    <th>No DO</th>
                    <th>No Invoice</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($deliveryTerbaru as $delivery)
                <tr class="table-row">
                    <td><strong>{{ $delivery->no_do }}</strong></td>
                    <td style="color: #6B7280;">{{ $delivery->no_invoice }}</td>
                    <td>{{ \Carbon\Carbon::parse($delivery->tanggal)->format('d M Y') }}</td>
                    <td>
                        @php
                            $statusClass = match($delivery->status) {
                                'Menunggu' => 'status-waiting',
                                'Diproses' => 'status-processing',
                                'Dikirim' => 'status-shipped',
                                'Selesai' => 'status-completed',
                                'Dibatalkan' => 'status-cancelled',
                                default => 'status-waiting'
                            };
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ $delivery->status }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <span class="empty-icon">📦</span>
            <h3 style="color: #6B46C1; margin-bottom: 10px;">Belum Ada Pengiriman</h3>
            <p style="color: #6B7280; margin-bottom: 20px;">Data pengiriman belum tersedia saat ini.</p>
        </div>
        @endif
    </div>

    <div style="text-align: center; margin-top: 50px; padding: 40px; background: rgba(245, 243, 255, 0.8); backdrop-filter: blur(5px); border-radius: 20px; border: 1px solid #EDE9FE;">
        <div style="font-size: 3rem; margin-bottom: 15px; animation: float 3s ease-in-out infinite;">✨</div>
        <h3 style="color: #6B46C1; font-size: 1.5rem; font-weight: 800; margin-bottom: 10px;">Butuh Insight Lebih Dalam?</h3>
        <p style="color: #6B7280; margin-bottom: 25px; max-width: 500px; margin-left: auto; margin-right: auto; line-height: 1.6;">Akses menu Laporan untuk melihat analisis detail penjualan, metrik stok, dan tren pengiriman Anda secara komprehensif.</p>
        <a href="{{ route('laporan.penjualan') }}" class="btn-primary">
            <span>📈</span> Buka Laporan Lengkap
        </a>
    </div>
</div>
@endsection

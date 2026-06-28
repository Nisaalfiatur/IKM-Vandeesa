@extends('layouts.app')

@section('content')
<style>
    /* Gen Z Aesthetic Typography & Base */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .dashboard-container {
        font-family: 'Inter', sans-serif;
        background-color: #F5F3FF;
        padding: 2rem;
        min-height: 100vh;
        color: #1F2937;
        border-radius: 24px;
    }

    /* Typography */
    .dashboard-title {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #7C5CDB, #6B46C1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .greeting {
        font-size: 1.1rem;
        color: #6B7280;
        margin-bottom: 2.5rem;
        font-weight: 500;
    }

    /* Grids */
    .grid-3 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3.5rem;
    }

    /* Glassmorphism Cards */
    .metric-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(12px);
        border-radius: 24px;
        padding: 1.75rem;
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 4px 15px rgba(123, 92, 219, 0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .metric-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #7C5CDB, #6B46C1);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .metric-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 15px 30px rgba(123, 92, 219, 0.15);
    }

    .metric-card:hover::before {
        opacity: 1;
    }

    /* Metric Icon & Value */
    .metric-icon {
        font-size: 2.2rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, rgba(124, 92, 219, 0.1), rgba(107, 70, 193, 0.1));
        border-radius: 20px;
        margin-bottom: 1rem;
        animation: float 4s ease-in-out infinite;
    }

    .metric-card.alert-card .metric-icon {
        background: rgba(239, 68, 68, 0.1);
        animation: pulse 2s ease-in-out infinite;
    }

    .metric-card h3 {
        font-size: 0.95rem;
        color: #6B7280;
        font-weight: 600;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .metric-value {
        font-size: 2rem;
        font-weight: 800;
        color: #1F2937;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, #111827, #374151);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .metric-value.large-number {
        font-size: 2.5rem;
    }

    .subtitle {
        font-size: 0.85rem;
        color: #9CA3AF;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Animations */
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.08); }
    }

    @keyframes slideUpFade {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-in {
        opacity: 0;
        animation: slideUpFade 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    /* Tables */
    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .table-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        padding: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 4px 15px rgba(123, 92, 219, 0.08);
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    th {
        text-align: left;
        padding: 1rem 1.5rem;
        font-size: 0.85rem;
        font-weight: 700;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid rgba(124, 92, 219, 0.1);
    }

    td {
        padding: 1.25rem 1.5rem;
        font-size: 0.95rem;
        color: #374151;
        border-bottom: 1px solid rgba(124, 92, 219, 0.05);
        vertical-align: middle;
        transition: all 0.2s ease;
    }

    .table-row {
        opacity: 0;
        animation: slideUpFade 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    .table-row:hover td {
        background-color: rgba(124, 92, 219, 0.03);
    }

    .table-row:last-child td {
        border-bottom: none;
    }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.4rem 1rem;
        border-radius: 9999px;
        font-size: 0.85rem;
        font-weight: 600;
        background: linear-gradient(135deg, rgba(124, 92, 219, 0.15), rgba(107, 70, 193, 0.15));
        color: #7C5CDB;
        gap: 0.4rem;
        box-shadow: 0 2px 5px rgba(123, 92, 219, 0.05);
        transition: transform 0.2s ease;
    }
    
    .table-row:hover .badge {
        transform: scale(1.05);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(8px);
        border-radius: 24px;
        border: 2px dashed rgba(124, 92, 219, 0.3);
        margin-top: 1rem;
        box-shadow: 0 4px 15px rgba(123, 92, 219, 0.05);
    }

    .empty-state-icon {
        font-size: 4.5rem;
        margin-bottom: 1.5rem;
        animation: float 3s ease-in-out infinite;
    }

    .empty-state h4 {
        font-size: 1.25rem;
        font-weight: 800;
        color: #374151;
        margin-bottom: 0.75rem;
    }

    .empty-state p {
        color: #6B7280;
        font-size: 1rem;
        max-width: 320px;
        margin: 0 auto 1.5rem;
        line-height: 1.5;
    }
    
    .empty-state .btn-primary {
        background: linear-gradient(135deg, #7C5CDB, #6B46C1);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 9999px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(123, 92, 219, 0.3);
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .empty-state .btn-primary:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 8px 25px rgba(123, 92, 219, 0.4);
    }
</style>

<div class="dashboard-container">
    <h1 class="dashboard-title">👋 Hey Kasir!</h1>
    <p class="greeting">Here's your sales summary for today ✨</p>

    <!-- Main Metrics Grid -->
    <div class="grid-3">
        <div class="metric-card animate-in" style="animation-delay: 0.1s;">
            <span class="metric-icon">💰</span>
            <h3>Total Penjualan</h3>
            <div class="metric-value">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
            <span class="subtitle">🚀 Semua transaksi hari ini</span>
        </div>

        <div class="metric-card animate-in" style="animation-delay: 0.2s;">
            <span class="metric-icon">🧾</span>
            <h3>Transaksi Dibuat</h3>
            <div class="metric-value large-number">{{ $jumlahInvoice }}</div>
            <span class="subtitle">🔥 Total transaksi aktif</span>
        </div>

        <div class="metric-card alert-card animate-in" style="animation-delay: 0.3s;">
            <span class="metric-icon">⚠️</span>
            <h3>Stok Menipis</h3>
            <div class="metric-value large-number">{{ $stokMenipis }}</div>
            <span class="subtitle">🚨 Perlu direstok segera!</span>
        </div>
    </div>

    <!-- Transaksi Terbaru -->
    <h2 class="section-title">📊 Transaksi Terbaru</h2>
    
    @if(count($invoiceTerbaru) > 0)
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>No Transaksi</th>
                        <th>Tanggal</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoiceTerbaru as $index => $invoice)
                    <tr class="table-row" style="animation-delay: {{ 0.4 + ($index * 0.1) }}s;">
                        <td>
                            <div style="font-weight: 700; color: #1F2937;">{{ $invoice->no_invoice }}</div>
                        </td>
                        <td>
                            <div style="color: #6B7280; font-size: 0.9rem; display: flex; align-items: center; gap: 0.4rem;">
                                📅 {{ \Carbon\Carbon::parse($invoice->tanggal)->format('d M Y') }}
                            </div>
                        </td>
                        <td>
                            <div style="color: #7C5CDB; font-weight: 800; font-size: 1.05rem;">
                                Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}
                            </div>
                        </td>
                        <td>
                            <span class="badge">✨ Sukses</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state animate-in" style="animation-delay: 0.4s;">
            <div class="empty-state-icon">📭</div>
            <h4>Belum Ada Transaksi</h4>
            <p>Ups! Sepertinya belum ada transaksi yang tercatat hari ini. Yuk semangat jualannya! 💪</p>
        </div>
    @endif
</div>

@endsection

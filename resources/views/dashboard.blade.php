@extends('layouts.app')

@section('content')
<style>
    /* Gen Z Aesthetic Styles */
    :root {
        --primary: #7C5CDB;
        --primary-dark: #6B46C1;
        --bg-color: #F5F3FF;
        --text-main: #1F2937;
        --text-muted: #6B7280;
        --shadow-soft: 0 4px 15px rgba(123, 92, 219, 0.08);
        --shadow-hover: 0 10px 25px rgba(123, 92, 219, 0.15);
        --radius-lg: 20px;
        --radius-md: 12px;
    }

    body {
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: var(--bg-color);
        color: var(--text-main);
    }

    .dashboard-container {
        padding: 20px;
        animation: fadeIn 0.8s ease-in-out;
    }

    .header-title {
        font-size: 2rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .greeting {
        color: var(--text-muted);
        font-size: 1.1rem;
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-main);
        margin: 40px 0 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Grids */
    .grid-4 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .grid-3 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .grid-5 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    /* Cards */
    .metric-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: var(--radius-lg);
        padding: 25px 20px;
        box-shadow: var(--shadow-soft);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        position: relative;
        overflow: hidden;
    }

    .metric-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .metric-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: var(--shadow-hover);
        background: #ffffff;
    }

    .metric-card:hover::before {
        opacity: 1;
    }

    .metric-card.alert-card {
        border-left: 4px solid #EF4444;
    }

    .metric-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        display: inline-block;
        animation: float 3s ease-in-out infinite;
        background: rgba(124, 92, 219, 0.1);
        padding: 12px;
        border-radius: 50%;
    }

    .metric-card h3 {
        font-size: 0.95rem;
        color: var(--text-muted);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .metric-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 5px;
    }

    .subtitle {
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    /* Table Styles */
    .table-container {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-soft);
        padding: 20px;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    th {
        background: rgba(124, 92, 219, 0.05);
        color: var(--primary-dark);
        font-weight: 700;
        text-align: left;
        padding: 16px;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    th:first-child { border-top-left-radius: var(--radius-md); border-bottom-left-radius: var(--radius-md); }
    th:last-child { border-top-right-radius: var(--radius-md); border-bottom-right-radius: var(--radius-md); }

    td {
        padding: 16px;
        border-bottom: 1px solid rgba(124, 92, 219, 0.1);
        color: var(--text-main);
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }

    tr:last-child td {
        border-bottom: none;
    }

    .table-row:hover td {
        background: rgba(124, 92, 219, 0.03);
        transform: scale(1.005);
    }

    /* Badges */
    .status-badge {
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .status-waiting { background: #FEF3C7; color: #D97706; }
    .status-processing { background: #DBEAFE; color: #2563EB; }
    .status-shipped { background: #EDE9FE; color: #7C5CDB; }
    .status-completed { background: #D1FAE5; color: #059669; }
    .status-cancelled { background: #FEE2E2; color: #DC2626; }

    /* Empty State */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        text-align: center;
        color: var(--text-muted);
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 15px;
        animation: bounce 2s infinite;
        opacity: 0.7;
    }

    /* Animations */
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="dashboard-container">
    <h1 class="header-title">✨ Dashboard</h1>
    <p class="greeting">Selamat datang kembali! Berikut ringkasan data sistem Anda 🚀</p>

    <!-- Main Metrics Grid -->
    <div class="grid-4">
        <div class="card metric-card">
            <span class="metric-icon">💸</span>
            <h3>Total Penjualan</h3>
            <div class="metric-value">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
            <span class="subtitle">Semua transaksi</span>
        </div>

        <div class="card metric-card">
            <span class="metric-icon">📄</span>
            <h3>Invoice</h3>
            <div class="metric-value large-number">{{ $jumlahInvoice }}</div>
            <span class="subtitle">Total invoice</span>
        </div>

        <div class="card metric-card">
            <span class="metric-icon">📦</span>
            <h3>Item</h3>
            <div class="metric-value large-number">{{ $jumlahItem }}</div>
            <span class="subtitle">Produk aktif</span>
        </div>

        <div class="card metric-card alert-card">
            <span class="metric-icon" style="background: rgba(239, 68, 68, 0.1);">🚨</span>
            <h3>Stok Menipis</h3>
            <div class="metric-value large-number">{{ $stokMenipis }}</div>
            <span class="subtitle" style="color: #EF4444;">Perlu restok segera</span>
        </div>
    </div>

    <!-- Secondary Metrics Grid -->
    <div class="grid-3">
        <div class="card metric-card">
            <span class="metric-icon">⭐</span>
            <h3>Member</h3>
            <div class="metric-value large-number">{{ $jumlahMember }}</div>
            <span class="subtitle">Member aktif</span>
        </div>

        <div class="card metric-card">
            <span class="metric-icon">🤝</span>
            <h3>Reseller</h3>
            <div class="metric-value large-number">{{ $jumlahReseller }}</div>
            <span class="subtitle">Mitra reseller</span>
        </div>
    </div>

    <!-- Delivery Overview -->
    <h2 class="section-title">📋 Status Pengiriman</h2>
    <div class="grid-5">
        <div class="card metric-card">
            <span class="metric-icon" style="background: rgba(245, 158, 11, 0.1);">⏳</span>
            <h3>Menunggu</h3>
            <div class="metric-value large-number" style="color: #F59E0B;">{{ $deliveryMenunggu }}</div>
            <span class="subtitle">Dalam antrian</span>
        </div>

        <div class="card metric-card">
            <span class="metric-icon" style="background: rgba(59, 130, 246, 0.1);">⚙️</span>
            <h3>Diproses</h3>
            <div class="metric-value large-number" style="color: #3B82F6;">{{ $deliveryDiproses }}</div>
            <span class="subtitle">Sedang dikerjakan</span>
        </div>

        <div class="card metric-card">
            <span class="metric-icon" style="background: rgba(139, 92, 246, 0.1);">🚚</span>
            <h3>Dikirim</h3>
            <div class="metric-value large-number" style="color: #8B5CF6;">{{ $deliveryDikirim }}</div>
            <span class="subtitle">Dalam perjalanan</span>
        </div>

        <div class="card metric-card">
            <span class="metric-icon" style="background: rgba(16, 185, 129, 0.1);">✅</span>
            <h3>Selesai</h3>
            <div class="metric-value large-number" style="color: #10B981;">{{ $deliverySelesai }}</div>
            <span class="subtitle">Terselesaikan</span>
        </div>

        <div class="card metric-card">
            <span class="metric-icon" style="background: rgba(239, 68, 68, 0.1);">❌</span>
            <h3>Dibatalkan</h3>
            <div class="metric-value large-number" style="color: #EF4444;">{{ $deliveryDibatalkan }}</div>
            <span class="subtitle">Tidak jadi</span>
        </div>
    </div>

    <!-- Invoice Terbaru -->
    <h2 class="section-title">📊 Invoice Terbaru</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No Invoice</th>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoiceTerbaru as $invoice)
                <tr class="table-row">
                    <td><strong>{{ $invoice->no_invoice }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($invoice->tanggal)->format('d M Y') }}</td>
                    <td style="color: #7C5CDB; font-weight: 700;">Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">
                        <div class="empty-state">
                            <div class="empty-icon">📭</div>
                            <h4>Belum ada data invoice</h4>
                            <p>Transaksi baru akan muncul di sini</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Delivery Terbaru -->
    <h2 class="section-title">🚚 Pengiriman Terbaru</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No DO</th>
                    <th>No Invoice</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($deliveryTerbaru as $delivery)
                <tr class="table-row">
                    <td><strong>{{ $delivery->no_do }}</strong></td>
                    <td>{{ $delivery->no_invoice }}</td>
                    <td>{{ \Carbon\Carbon::parse($delivery->tanggal)->format('d M Y') }}</td>
                    <td>
                        @php
                            $statusInfo = match($delivery->status) {
                                'Menunggu' => ['class' => 'status-waiting', 'emoji' => '⏳'],
                                'Diproses' => ['class' => 'status-processing', 'emoji' => '⚙️'],
                                'Dikirim' => ['class' => 'status-shipped', 'emoji' => '🚚'],
                                'Selesai' => ['class' => 'status-completed', 'emoji' => '✅'],
                                'Dibatalkan' => ['class' => 'status-cancelled', 'emoji' => '❌'],
                                default => ['class' => 'status-waiting', 'emoji' => '⏳']
                            };
                        @endphp
                        <span class="status-badge {{ $statusInfo['class'] }}">
                            {{ $statusInfo['emoji'] }} {{ $delivery->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <div class="empty-icon">📦</div>
                            <h4>Belum ada data pengiriman</h4>
                            <p>Status pengiriman akan muncul di sini</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Observer for animating numbers when scrolled into view
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const value = entry.target.textContent;
                    if (value.includes('Rp')) {
                        animateRupiah(entry.target);
                    } else if (!isNaN(value.trim())) {
                        animateNumber(entry.target);
                    }
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.metric-value').forEach(el => {
            observer.observe(el);
        });

        function animateNumber(element) {
            const finalValue = parseInt(element.textContent.replace(/\D/g, ''));
            const duration = 1500;
            const steps = 60;
            const stepDuration = duration / steps;
            let currentStep = 0;

            const interval = setInterval(() => {
                currentStep++;
                const progress = currentStep / steps;
                // Easing out function
                const easeOutProgress = 1 - Math.pow(1 - progress, 3);
                const currentValue = Math.floor(finalValue * easeOutProgress);
                element.textContent = currentValue;

                if (currentStep === steps) {
                    element.textContent = finalValue;
                    clearInterval(interval);
                }
            }, stepDuration);
        }

        function animateRupiah(element) {
            const finalValueStr = element.textContent;
            const finalValue = parseInt(finalValueStr.replace(/\D/g, ''));
            if(isNaN(finalValue)) return;
            const duration = 1500;
            const steps = 60;
            const stepDuration = duration / steps;
            let currentStep = 0;

            const interval = setInterval(() => {
                currentStep++;
                const progress = currentStep / steps;
                // Easing out function
                const easeOutProgress = 1 - Math.pow(1 - progress, 3);
                const currentValue = Math.floor(finalValue * easeOutProgress);
                element.textContent = 'Rp ' + currentValue.toLocaleString('id-ID');

                if (currentStep === steps) {
                    element.textContent = finalValueStr;
                    clearInterval(interval);
                }
            }, stepDuration);
        }
    });
</script>

@endsection

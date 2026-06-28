@extends('layouts.app')

@section('content')
<div>
    <h1>Dashboard Owner</h1>
    <p class="greeting">Ringkasan bisnis Anda secara keseluruhan</p>

    <!-- Main Metrics Grid -->
    <div class="grid-2">
        <div class="card metric-card">
            <span class="metric-icon">💰</span>
            <h3>Total Penjualan</h3>
            <div class="metric-value">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
            <span class="subtitle">Semua transaksi</span>
        </div>

        <div class="card metric-card">
            <span class="metric-icon">📄</span>
            <h3>Total Invoice</h3>
            <div class="metric-value large-number">{{ $jumlahInvoice }}</div>
            <span class="subtitle">Dokumen penjualan</span>
        </div>
    </div>

    <!-- Delivery Overview -->
    <h2 class="section-title">📋 Status Pengiriman</h2>
    <div class="grid-5">
        <div class="card metric-card">
            <span class="metric-icon">⏳</span>
            <h3>Menunggu</h3>
            <div class="metric-value large-number" style="color: #F59E0B;">{{ $deliveryMenunggu }}</div>
        </div>

        <div class="card metric-card">
            <span class="metric-icon">⚙️</span>
            <h3>Diproses</h3>
            <div class="metric-value large-number" style="color: #3B82F6;">{{ $deliveryDiproses }}</div>
        </div>

        <div class="card metric-card">
            <span class="metric-icon">🚚</span>
            <h3>Dikirim</h3>
            <div class="metric-value large-number" style="color: #8B5CF6;">{{ $deliveryDikirim }}</div>
        </div>

        <div class="card metric-card">
            <span class="metric-icon">✅</span>
            <h3>Selesai</h3>
            <div class="metric-value large-number" style="color: #10B981;">{{ $deliverySelesai }}</div>
        </div>

        <div class="card metric-card">
            <span class="metric-icon">❌</span>
            <h3>Dibatalkan</h3>
            <div class="metric-value large-number" style="color: #EF4444;">{{ $deliveryDibatalkan }}</div>
        </div>
    </div>

    <!-- Summary Card -->
    <div class="card" style="margin-top: 40px; background: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%); color: white;">
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; text-align: center;">
            <div>
                <div style="font-size: 48px; font-weight: 700; margin-bottom: 10px;">{{ $jumlahInvoice }}</div>
                <div style="font-size: 14px; opacity: 0.9;">Invoice Aktif</div>
            </div>
            <div>
                <div style="font-size: 48px; font-weight: 700; margin-bottom: 10px;">{{ $jumlahDelivery }}</div>
                <div style="font-size: 14px; opacity: 0.9;">Pengiriman</div>
            </div>
            <div>
                <div style="font-size: 36px; font-weight: 700; margin-bottom: 10px;">Rp {{ number_format($totalPenjualan / max($jumlahInvoice, 1), 0, ',', '.') }}</div>
                <div style="font-size: 14px; opacity: 0.9;">Avg. per Invoice</div>
            </div>
        </div>
    </div>

    <!-- Invoice Terbaru -->
    <h2 class="section-title">📊 Invoice Terbaru</h2>
    <div class="card">
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
                <tr class="table-row" style="opacity: 0;">
                    <td><strong>{{ $invoice->no_invoice }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($invoice->tanggal)->format('d M Y') }}</td>
                    <td style="color: #7C5CDB; font-weight: 600;">Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align: center; color: #9CA3AF; padding: 30px;">
                        Belum ada data invoice
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Delivery Status -->
    <h2 class="section-title">🚚 Pengiriman Terbaru</h2>
    <div class="card">
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
                <tr class="table-row" style="opacity: 0;">
                    <td><strong>{{ $delivery->no_do }}</strong></td>
                    <td>{{ $delivery->no_invoice }}</td>
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
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #9CA3AF; padding: 30px;">
                        Belum ada data pengiriman
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="text-align: center; margin-top: 40px; padding: 30px; background: #F5F3FF; border-radius: 12px;">
        <h3 style="color: #6B46C1; margin-bottom: 10px;">Lihat Laporan Detail</h3>
        <p style="color: #9CA3AF; margin-bottom: 20px;">Akses menu Laporan untuk melihat analisis detail penjualan, stok, dan pengiriman</p>
        <a href="{{ route('laporan.penjualan') }}" class="btn" style="display: inline-block;">📈 Buka Laporan</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const metricCards = document.querySelectorAll('.metric-card');

        metricCards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.6s ease';

                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 10);
            }, index * 100);
        });

        const tableRows = document.querySelectorAll('.table-row');
        tableRows.forEach((row, index) => {
            setTimeout(() => {
                row.style.opacity = '1';
                row.style.transform = 'translateX(0)';
                row.style.transition = 'all 0.5s ease';
            }, index * 80 + 800);
        });

        metricCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    });
</script>
@endsection

@extends('layouts.app')

@section('content')
<div>
    <h1>Dashboard Kasir</h1>
    <p class="greeting">Ringkasan penjualan hari ini</p>

    <!-- Main Metrics Grid -->
    <div class="grid-3">
        <div class="card metric-card">
            <span class="metric-icon">📊</span>
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

        <div class="card metric-card alert-card">
            <span class="metric-icon">⚠️</span>
            <h3>Stok Menipis</h3>
            <div class="metric-value large-number">{{ $stokMenipis }}</div>
            <span class="subtitle">Perlu restok</span>
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

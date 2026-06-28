@extends('layouts.app')

@section('content')
<div>
    <h1>Dashboard</h1>
    <p class="greeting">Selamat datang kembali! Berikut ringkasan data sistem Anda</p>

    <!-- Main Metrics Grid -->
    <div class="grid-4">
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

        <div class="card metric-card">
            <span class="metric-icon">📦</span>
            <h3>Item</h3>
            <div class="metric-value large-number">{{ $jumlahItem }}</div>
            <span class="subtitle">Produk aktif</span>
        </div>

        <div class="card metric-card alert-card">
            <span class="metric-icon">⚠️</span>
            <h3>Stok Menipis</h3>
            <div class="metric-value large-number">{{ $stokMenipis }}</div>
            <span class="subtitle">Perlu restok</span>
        </div>
    </div>

    <!-- Secondary Metrics Grid -->
    <div class="grid-3">
        <div class="card metric-card">
            <span class="metric-icon">👥</span>
            <h3>Pelanggan</h3>
            <div class="metric-value large-number">{{ $jumlahPelanggan }}</div>
            <span class="subtitle">Total pelanggan</span>
        </div>

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
            <span class="metric-icon">⏳</span>
            <h3>Menunggu</h3>
            <div class="metric-value large-number" style="color: #F59E0B;">{{ $deliveryMenunggu }}</div>
            <span class="subtitle">Dalam antrian</span>
        </div>

        <div class="card metric-card">
            <span class="metric-icon">⚙️</span>
            <h3>Diproses</h3>
            <div class="metric-value large-number" style="color: #3B82F6;">{{ $deliveryDiproses }}</div>
            <span class="subtitle">Sedang dikerjakan</span>
        </div>

        <div class="card metric-card">
            <span class="metric-icon">🚚</span>
            <h3>Dikirim</h3>
            <div class="metric-value large-number" style="color: #8B5CF6;">{{ $deliveryDikirim }}</div>
            <span class="subtitle">Dalam perjalanan</span>
        </div>

        <div class="card metric-card">
            <span class="metric-icon">✅</span>
            <h3>Selesai</h3>
            <div class="metric-value large-number" style="color: #10B981;">{{ $deliverySelesai }}</div>
            <span class="subtitle">Terselesaikan</span>
        </div>

        <div class="card metric-card">
            <span class="metric-icon">❌</span>
            <h3>Dibatalkan</h3>
            <div class="metric-value large-number" style="color: #EF4444;">{{ $deliveryDibatalkan }}</div>
            <span class="subtitle">Tidak jadi</span>
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

    <!-- Delivery Terbaru -->
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
</div>

<script>
    // Animate metric cards on page load
    document.addEventListener('DOMContentLoaded', function() {
        const metricCards = document.querySelectorAll('.metric-card');

        metricCards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.6s ease';

                // Trigger animation
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 10);
            }, index * 100);
        });

        // Animate table rows
        const tableRows = document.querySelectorAll('.table-row');
        tableRows.forEach((row, index) => {
            setTimeout(() => {
                row.style.opacity = '1';
                row.style.transform = 'translateX(0)';
                row.style.transition = 'all 0.5s ease';
            }, index * 80 + 800);
        });

        // Add hover effect to metric cards
        metricCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Animate numbers on scroll
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
                const currentValue = Math.floor(finalValue * progress);
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
            const duration = 1500;
            const steps = 60;
            const stepDuration = duration / steps;
            let currentStep = 0;

            const interval = setInterval(() => {
                currentStep++;
                const progress = currentStep / steps;
                const currentValue = Math.floor(finalValue * progress);
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

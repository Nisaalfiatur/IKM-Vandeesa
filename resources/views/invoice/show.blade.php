@extends('layouts.app')

@section('content')
<div class="genz-container">
    <div class="header-actions">
        <h1 class="page-title">📄 Detail Invoice ✨</h1>
        <div class="action-buttons">
            @if($invoice->id_reseller)
                <a href="{{ route('delivery.create', ['no_invoice' => $invoice->no_invoice]) }}" class="btn btn-primary" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
                    📦 Buat DO
                </a>
            @endif
            <a href="{{ route('invoice.print', $invoice->no_invoice) }}" class="btn btn-print" target="_blank">
                <span class="btn-icon">🖨️</span> Cetak
            </a>
            <a href="{{ route('invoice.index') }}" class="btn btn-back">
                <span class="btn-icon">←</span> Kembali
            </a>
        </div>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
    <div class="genz-alert" id="genzAlert">
        <span>✅ {{ session('success') }}</span>
        <button onclick="this.parentElement.style.display='none'" style="background:none;border:none;cursor:pointer;font-size:18px;color:#6B46C1;line-height:1;">×</button>
    </div>
    @endif

    <div class="info-grid">
        <!-- Left Column -->
        <div class="glass-card zoom-hover">
            <h3 class="card-title">ℹ️ Informasi Invoice</h3>
            <div class="info-list">
                <div class="info-row">
                    <label>No Invoice</label>
                    <span class="badge badge-purple">{{ $invoice->no_invoice }}</span>
                </div>
                <div class="info-row">
                    <label>Tanggal</label>
                    <span class="text-dark">{{ \Carbon\Carbon::parse($invoice->tanggal)->format('d F Y') }}</span>
                </div>
                <div class="info-row highlight-row">
                    <label>Total Harga</label>
                    <span class="price-tag">
                        Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="glass-card zoom-hover">
            <h3 class="card-title">👥 Data Pihak Terkait</h3>
            <div class="info-list">
                @php
                    $namaPelanggan = $invoice->nama_pelanggan;
                    $noTelp = $invoice->no_telp_pelanggan;
                    $tipePelanggan = $invoice->tipe_pelanggan;
                @endphp
                <div class="info-row">
                    <label>Pelanggan</label>
                    <span class="text-dark">
                        {{ $namaPelanggan }}
                        @if($tipePelanggan)
                            <span class="badge badge-light" style="font-size:11px; margin-left:6px;">{{ $tipePelanggan }}</span>
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <label>No Telp</label>
                    <span class="text-dark">{{ $noTelp }}</span>
                </div>
                <div class="info-row">
                    <label>Member/Reseller</label>
                    <span class="badge badge-light">
                        @if($invoice->member)
                            {{ $invoice->member->nama }} (Member)
                        @elseif($invoice->reseller)
                            {{ $invoice->reseller->nama }} (Reseller)
                        @else
                            N/A
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <label>Kasir</label>
                    <span class="text-dark">{{ $invoice->kasir->nama_pg ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Items Table -->
    <div class="glass-card mt-30">
        <h3 class="card-title">📦 Detail Barang</h3>

        <div class="table-responsive">
            <table class="genz-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Item</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Harga Per PCS</th>
                        <th class="text-right">Subtotal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoice->detail as $index => $detail)
                    <tr>
                        <td><span class="badge badge-light">{{ $index + 1 }}</span></td>
                        <td><strong>{{ $detail->item->nama_item ?? 'N/A' }}</strong></td>
                        <td class="text-center"><span class="badge badge-purple">{{ $detail->quantity }}</span></td>
                        <td class="text-right">Rp {{ number_format($detail->harga_perpcs, 0, ',', '.') }}</td>
                        <td class="text-right price-highlight">
                            Rp {{ number_format($detail->harga_perpcs * $detail->quantity, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('invoice.deleteDetail', [$invoice->no_invoice, $detail->id_item]) }}"
                               class="btn-icon-delete bounce-hover" title="Hapus Item"
                               onclick="return confirm('Yakin ingin menghapus item ini? 🥺')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <div class="empty-state-content float-anim">
                                <span class="empty-emoji">📭</span>
                                <p>Belum ada detail item nih!</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="total-section">
            @php
                $subtotal = 0;
                foreach($invoice->detail as $dtl) {
                    $subtotal += ($dtl->harga_perpcs * $dtl->quantity);
                }
                $diskon = $invoice->diskon ?? 0;
            @endphp
            @if($diskon > 0)
                <p class="total-text" style="font-size: 14px; margin-bottom: 8px;">
                    Subtotal: <span style="font-weight: 600;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </p>
                <p class="total-text" style="font-size: 14px; color: #EF4444; margin-bottom: 12px; border-bottom: 1px dashed #E5E7EB; padding-bottom: 12px;">
                    Diskon: <span style="font-weight: 600;">- Rp {{ number_format($diskon, 0, ',', '.') }}</span>
                </p>
            @endif
            <p class="total-text">
                Total: <span class="total-price">Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}</span>
            </p>
        </div>
    </div>

    <!-- Form Tambah Detail Item -->
    <div class="glass-card mt-30 dash-border">
        <h3 class="card-title">➕ Tambah Item Penjualan</h3>

        <form method="POST" action="{{ route('invoice.storeDetail', $invoice->no_invoice) }}" class="genz-form">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label for="id_item">Item ✨</label>
                    <div class="select-wrapper">
                        <select id="id_item" name="id_item" class="form-control" required onchange="updatePrice(this)">
                            <option value="">-- Pilih Item --</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id_item }}" data-harga="{{ $item->harga }}">
                                    {{ $item->nama_item }} (Rp {{ number_format($item->harga, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="quantity">Qty 📦</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" min="1" value="1" required>
                </div>

                <div class="form-group">
                    <label for="harga_perpcs">Harga Per PCS 💸</label>
                    <input type="number" id="harga_perpcs" name="harga_perpcs" class="form-control" min="0" required readonly style="background: #F9FAFB; cursor: not-allowed;">
                </div>

                <div class="form-group btn-group-bottom">
                    <button type="submit" class="btn btn-primary w-100">💾 Simpan</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Form Diskon -->
    <div class="glass-card mt-30 diskon-card">
        <h3 class="card-title">🏷️ Atur Diskon Invoice</h3>
        <form method="POST" action="{{ route('invoice.updateDiskon', $invoice->no_invoice) }}">
            @csrf
            <div class="diskon-form-row">
                <div class="diskon-info">
                    <p class="diskon-desc">Masukkan nominal diskon yang dikurangkan dari subtotal.</p>
                    @php
                        $subtotalDiskon = 0;
                        foreach($invoice->detail as $dtl) {
                            $subtotalDiskon += ($dtl->harga_perpcs * $dtl->quantity);
                        }
                    @endphp
                    <div class="diskon-summary">
                        <span>Subtotal Barang</span>
                        <strong>Rp {{ number_format($subtotalDiskon, 0, ',', '.') }}</strong>
                    </div>
                    <div class="diskon-summary diskon-red">
                        <span>Diskon Saat Ini</span>
                        <strong>- Rp {{ number_format($invoice->diskon ?? 0, 0, ',', '.') }}</strong>
                    </div>
                    <div class="diskon-summary diskon-total">
                        <span>Total Bayar</span>
                        <strong>Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}</strong>
                    </div>
                </div>
                <div class="diskon-input-group">
                    <label for="diskon" style="font-weight:700; font-size:13px; color:#374151; margin-bottom:8px; display:block;">💸 Nominal Diskon (Rp)</label>
                    <input type="number"
                           id="diskon"
                           name="diskon"
                           class="form-control"
                           value="{{ $invoice->diskon ?? 0 }}"
                           min="0"
                           placeholder="0"
                           required>
                    <button type="submit" class="btn btn-primary" style="margin-top:12px; width:100%;">
                        💾 Simpan Diskon
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Action Buttons -->
    <div class="footer-actions mt-30">
        @if($invoice->id_reseller)
            <a href="{{ route('delivery.create', ['no_invoice' => $invoice->no_invoice]) }}" class="btn btn-primary" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
                📦 Buat DO
            </a>
        @endif
        <a href="{{ route('invoice.edit', $invoice->no_invoice) }}" class="btn btn-warning">
            ✏️ Edit Invoice
        </a>
        <a href="{{ route('invoice.delete', $invoice->no_invoice) }}" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus invoice ini? 😭')">
            🗑️ Hapus Invoice
        </a>
    </div>
</div>

<style>
    /* Gen Z Aesthetics & Glassmorphism Variables */
    :root {
        --primary-gradient: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%);
        --primary-color: #7C5CDB;
        --secondary-color: #F5F3FF;
        --dark-color: #374151;
        --text-muted: #6B7280;
        --glass-bg: rgba(255, 255, 255, 0.85);
        --glass-shadow: 0 4px 15px rgba(123, 92, 219, 0.08);
        --glass-border: 1px solid rgba(255, 255, 255, 0.6);
        --transition-smooth: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    .genz-container {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        color: var(--dark-color);
        max-width: 1200px;
        margin: 0 auto;
        padding-bottom: 40px;
    }

    .mt-30 { margin-top: 30px; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-dark { color: var(--dark-color); font-weight: 500; }
    .w-100 { width: 100%; }

    /* Header */
    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
    }

    /* Cards */
    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: var(--glass-border);
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--glass-shadow);
        transition: var(--transition-smooth);
    }

    .dash-border {
        border: 2px dashed rgba(124, 92, 219, 0.3);
        background: rgba(249, 250, 251, 0.6);
    }

    .zoom-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(123, 92, 219, 0.15);
    }

    .card-title {
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 18px;
        font-weight: 700;
        color: var(--dark-color);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Grid Layouts */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 24px;
    }

    .info-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        background: #f9fafb;
        border-radius: 12px;
        font-size: 14px;
        transition: var(--transition-smooth);
    }

    .info-row:hover {
        background: var(--secondary-color);
    }

    .info-row label {
        font-weight: 600;
        color: var(--text-muted);
        margin: 0;
    }

    .highlight-row {
        background: var(--secondary-color);
        border: 1px solid rgba(124, 92, 219, 0.2);
    }

    /* Badges */
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        display: inline-block;
    }

    .badge-purple {
        background: var(--secondary-color);
        color: var(--primary-color);
    }

    .badge-light {
        background: #E5E7EB;
        color: var(--dark-color);
    }

    .price-tag {
        color: var(--primary-color);
        font-weight: 800;
        font-size: 16px;
    }

    /* Tables */
    .table-responsive {
        overflow-x: auto;
        border-radius: 12px;
        border: 1px solid #E5E7EB;
    }

    .genz-table {
        width: 100%;
        border-collapse: collapse;
        white-space: nowrap;
    }

    .genz-table th, .genz-table td {
        padding: 16px;
        border-bottom: 1px solid #E5E7EB;
    }

    .genz-table th {
        background: #F9FAFB;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
    }

    .genz-table tbody tr {
        transition: var(--transition-smooth);
    }

    .genz-table tbody tr:hover {
        background: var(--secondary-color);
        transform: scale(1.002);
    }

    .genz-table tbody tr:last-child td {
        border-bottom: none;
    }

    .price-highlight {
        color: var(--primary-color);
        font-weight: 700;
    }

    .total-section {
        text-align: right;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 2px dashed rgba(124, 92, 219, 0.3);
    }

    .total-text {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-muted);
        margin: 0;
    }

    .total-price {
        color: var(--primary-color);
        font-size: 24px;
        font-weight: 800;
        margin-left: 10px;
    }

    /* Forms */
    .form-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1.5fr auto;
        gap: 16px;
        align-items: flex-end;
    }

    @media (max-width: 900px) {
        .form-grid {
            grid-template-columns: 1fr 1fr;
        }
        .form-grid .form-group:first-child {
            grid-column: span 2;
        }
        .btn-group-bottom {
            grid-column: span 2;
        }
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        font-weight: 700;
        font-size: 13px;
        color: var(--dark-color);
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #E5E7EB;
        border-radius: 12px;
        font-size: 14px;
        font-family: inherit;
        background: white;
        transition: var(--transition-smooth);
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(123, 92, 219, 0.15);
        transform: translateY(-2px);
    }

    /* Buttons */
    .btn {
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        transition: var(--transition-smooth);
    }

    .btn:hover {
        transform: translateY(-3px);
    }

    .btn:active {
        transform: translateY(0);
    }

    .btn-primary {
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 4px 15px rgba(123, 92, 219, 0.3);
    }

    .btn-primary:hover {
        box-shadow: 0 6px 20px rgba(123, 92, 219, 0.4);
    }

    .btn-print {
        background: var(--secondary-color);
        color: var(--primary-color);
    }

    .btn-print:hover {
        background: #E9D5FF;
    }

    .btn-back {
        background: white;
        color: var(--dark-color);
        border: 1px solid #E5E7EB;
    }

    .btn-back:hover {
        background: #F9FAFB;
        border-color: #D1D5DB;
    }

    .btn-warning {
        background: #FEF3C7;
        color: #D97706;
    }

    .btn-warning:hover {
        background: #FDE68A;
    }

    .btn-danger {
        background: #FEE2E2;
        color: #DC2626;
    }

    .btn-danger:hover {
        background: #FECACA;
    }

    .btn-icon-delete {
        width: 36px;
        height: 36px;
        background: #FEE2E2;
        color: #DC2626;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 16px;
        transition: var(--transition-smooth);
    }

    .bounce-hover:hover {
        background: #FECACA;
        transform: scale(1.15) rotate(5deg);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px !important;
    }

    .empty-state-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
        color: var(--text-muted);
        font-weight: 600;
    }

    .empty-emoji {
        font-size: 48px;
    }

    /* Animations */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }

    .float-anim .empty-emoji {
        display: inline-block;
        animation: float 3s ease-in-out infinite;
    }

    .footer-actions {
        display: flex;
        gap: 12px;
    }

    /* ===== Diskon Card ===== */
    .diskon-card {
        border: 2px solid rgba(124, 92, 219, 0.2);
        background: linear-gradient(135deg, rgba(245, 243, 255, 0.7), rgba(255,255,255,0.9));
    }

    .diskon-form-row {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 24px;
        align-items: start;
    }

    @media (max-width: 768px) {
        .diskon-form-row {
            grid-template-columns: 1fr;
        }
    }

    .diskon-info {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .diskon-desc {
        font-size: 13.5px;
        color: var(--text-muted);
        margin: 0 0 4px 0;
    }

    .diskon-summary {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 14px;
        background: #f9fafb;
        border-radius: 10px;
        font-size: 14px;
        color: var(--dark-color);
    }

    .diskon-summary strong {
        font-weight: 700;
        color: var(--primary-color);
    }

    .diskon-red strong {
        color: #EF4444;
    }

    .diskon-total {
        background: var(--secondary-color);
        border: 1px solid rgba(124,92,219,0.2);
    }

    .diskon-total strong {
        font-size: 16px;
        color: var(--primary-color);
    }

    .diskon-input-group {
        background: white;
        border: 2px dashed rgba(124,92,219,0.25);
        border-radius: 14px;
        padding: 20px;
    }

    /* ===== Success Alert ===== */
    .genz-alert {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(135deg, #F5F3FF, #EDE9FE);
        color: #6B46C1;
        border-left: 4px solid #7C5CDB;
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 24px;
        font-size: 14px;
        font-weight: 600;
        animation: slideDown 0.4s ease;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    function updatePrice(select) {
        const harga = select.options[select.selectedIndex]?.getAttribute('data-harga');
        const hargaPerpcsInput = document.getElementById('harga_perpcs');

        if (harga) {
            hargaPerpcsInput.value = harga;
            
            // Add subtle animation to highlight the change
            [hargaPerpcsInput].forEach(el => {
                el.style.transform = 'scale(1.05)';
                el.style.borderColor = 'var(--primary-color)';
                setTimeout(() => {
                    el.style.transform = 'scale(1)';
                    el.style.borderColor = '#E5E7EB';
                }, 300);
            });
        }
    }

    // Auto-dismiss success alert
    const genzAlert = document.getElementById('genzAlert');
    if (genzAlert) {
        setTimeout(() => {
            genzAlert.style.transition = 'opacity 0.4s ease';
            genzAlert.style.opacity = '0';
            setTimeout(() => genzAlert.style.display = 'none', 400);
        }, 4000);
    }
</script>
@endsection

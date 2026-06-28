@extends('layouts.app')

@section('content')
<div class="do-detail-wrap">

    {{-- Page Header --}}
    <div class="do-page-header">
        <div>
            <h1 class="do-page-title">📋 Detail Delivery Order</h1>
            <p class="do-page-sub">{{ $delivery->no_do }}</p>
        </div>
        <div class="do-header-actions">
            <a href="{{ route('delivery.print', $delivery->no_do) }}" class="btn-hdr btn-hdr-print" target="_blank">
                🖨️ Cetak DO
            </a>
            <a href="{{ route('delivery.edit', $delivery->no_do) }}" class="btn-hdr btn-hdr-edit">
                ✏️ Edit
            </a>
            <a href="{{ route('delivery.index') }}" class="btn-hdr btn-hdr-back">
                ← Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="do-alert-success">✅ {{ session('success') }}</div>
    @endif

    {{-- 2-column info cards --}}
    <div class="do-cards-grid">

        {{-- Card: DO Info --}}
        <div class="do-card">
            <div class="do-card-header" style="border-color: #7C5CDB;">
                <div class="do-card-icon" style="background: linear-gradient(135deg,#7C5CDB,#6B46C1);">📦</div>
                <span>Informasi DO</span>
            </div>
            <div class="do-card-body">
                <div class="do-info-item">
                    <span class="do-info-lbl">No. DO</span>
                    <span class="do-info-val" style="color:#7C5CDB; font-weight:700; font-family: monospace; font-size:15px;">{{ $delivery->no_do }}</span>
                </div>
                <div class="do-info-item">
                    <span class="do-info-lbl">Tanggal</span>
                    <span class="do-info-val">{{ \Carbon\Carbon::parse($delivery->tanggal)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="do-info-item">
                    <span class="do-info-lbl">Status</span>
                    <span class="do-info-val">
                        @php
                            $sc = match($delivery->status) {
                                'Menunggu'   => 'status-waiting',
                                'Diproses'   => 'status-processing',
                                'Dikirim'    => 'status-shipped',
                                'Selesai'    => 'status-completed',
                                'Dibatalkan' => 'status-cancelled',
                                default      => 'status-waiting'
                            };
                        @endphp
                        <span class="status-badge {{ $sc }}">{{ $delivery->status }}</span>
                    </span>
                </div>
                <div class="do-info-item">
                    <span class="do-info-lbl">Pegawai</span>
                    <span class="do-info-val">Vivi Susanti</span>
                </div>
            </div>
        </div>

        {{-- Card: Invoice Terkait --}}
        <div class="do-card">
            <div class="do-card-header" style="border-color:#4F46E5;">
                <div class="do-card-icon" style="background:linear-gradient(135deg,#4F46E5,#3730A3);">📄</div>
                <span>Invoice Terkait</span>
            </div>
            <div class="do-card-body">
                <div class="do-info-item">
                    <span class="do-info-lbl">No. Invoice</span>
                    <span class="do-info-val">
                        @if($delivery->invoice)
                            <a href="{{ route('invoice.show', $delivery->invoice->no_invoice) }}" class="do-inv-link">
                                {{ $delivery->invoice->no_invoice }}
                            </a>
                        @else
                            <span>-</span>
                        @endif
                    </span>
                </div>
                <div class="do-info-item">
                    <span class="do-info-lbl">Tanggal Invoice</span>
                    <span class="do-info-val">
                        {{ $delivery->invoice ? \Carbon\Carbon::parse($delivery->invoice->tanggal)->translatedFormat('d F Y') : '-' }}
                    </span>
                </div>
                <div class="do-info-item">
                    <span class="do-info-lbl">Total Invoice</span>
                    <span class="do-info-val" style="color:#7C5CDB; font-weight:700; font-size:16px;">
                        Rp {{ number_format(optional($delivery->invoice)->total_harga ?? 0, 0, ',', '.') }}
                    </span>
                </div>
                @if($delivery->invoice)
                    <div style="margin-top:12px;">
                        <a href="{{ route('invoice.print', $delivery->invoice->no_invoice) }}" class="btn-hdr btn-hdr-print" target="_blank" style="font-size:12px; padding:7px 14px;">
                            🖨️ Cetak Invoice
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Card: Pelanggan / Reseller --}}
        <div class="do-card" style="grid-column: 1 / -1;">
            <div class="do-card-header" style="border-color:#10B981;">
                <div class="do-card-icon" style="background:linear-gradient(135deg,#10B981,#059669);">🏪</div>
                <span>Data Pelanggan / Reseller</span>
            </div>
            <div class="do-card-body">
                @php
                    $pelangganObj = $delivery->reseller 
                                    ?? optional($delivery->invoice)->pelanggan 
                                    ?? optional($delivery->invoice)->member 
                                    ?? optional($delivery->invoice)->reseller;
                    
                    $nama = $pelangganObj->nama ?? '-';
                    $telp = $pelangganObj->no_telp ?? $pelangganObj->no_hp ?? '-';
                    $alamat = $pelangganObj->alamat ?? '-';
                @endphp
                <div class="do-reseller-grid">
                    <div class="do-info-item">
                        <span class="do-info-lbl">Nama</span>
                        <span class="do-info-val">{{ $nama }}</span>
                    </div>
                    <div class="do-info-item">
                        <span class="do-info-lbl">No. Telp</span>
                        <span class="do-info-val">{{ $telp }}</span>
                    </div>
                    <div class="do-info-item">
                        <span class="do-info-lbl">Alamat</span>
                        <span class="do-info-val">{{ $alamat }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ===== Konsinyasi Table ===== --}}
    <div class="do-card" style="margin-bottom:24px;">
        <div class="do-card-header" style="border-color:#7C5CDB;">
            <div class="do-card-icon" style="background:linear-gradient(135deg,#7C5CDB,#6B46C1);">🛒</div>
            <span>Detail Barang Konsinyasi</span>
            <span class="do-card-header-sub">— Klik baris untuk melihat detail item</span>
        </div>
        <div class="do-card-body" style="padding:0;">

            @php
                $grandTotal     = 0;
                $grandQty       = 0;
                $detailItems    = optional(optional($delivery->invoice))->detail ?? collect();
            @endphp

            @if($detailItems && count($detailItems) > 0)
            <div style="overflow-x:auto;">
                <table class="konsinyasi-table">
                    <thead>
                        <tr>
                            <th style="width:38px;">NO.</th>
                            <th style="width:120px;">ITEM</th>
                            <th>DESKRIPSI PRODUK</th>
                            <th style="width:50px;">QTY</th>
                            <th style="width:55px;">SATUAN</th>
                            <th style="width:110px;">HARGA (pcs)</th>
                            <th style="width:120px;">HARGA RESELLER (pcs)</th>
                            <th style="width:110px;">KONSINYASI (pcs)</th>
                            <th style="width:110px;">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detailItems as $index => $detail)
                            @php
                                $hargaPcs      = $detail->harga_perpcs ?? 0;
                                $hargaReseller = 215200;
                                $qty           = $detail->quantity ?? 0;
                                $konsinyasi    = $hargaPcs - $hargaReseller;
                                $total         = $hargaReseller * $qty;
                                $grandTotal   += $total;
                                $grandQty     += $qty;

                                $namaItem  = $detail->item->nama_item ?? '-';
                                $itemParts = explode(' - ', $namaItem, 2);
                                $itemType  = $itemParts[0] ?? $namaItem;
                                $itemDesc  = $itemParts[1] ?? '';
                            @endphp

                            {{-- Main Row (clickable) --}}
                            <tr class="konsinyasi-row" data-idx="{{ $index }}"
                                onclick="toggleDetail({{ $index }})">
                                <td class="text-center">
                                    <span class="row-chevron" id="chevron-{{ $index }}">▶</span>
                                    {{ $index + 1 }}
                                </td>
                                <td>{{ $itemType }}</td>
                                <td>{{ $itemDesc ?: $namaItem }}</td>
                                <td class="text-center">
                                    <span class="qty-badge">{{ $qty }}</span>
                                </td>
                                <td class="text-center">pcs</td>
                                <td class="text-right">Rp {{ number_format($hargaPcs, 0, ',', '.') }}</td>
                                <td class="text-right">Rp {{ number_format($hargaReseller, 0, ',', '.') }}</td>
                                <td class="text-right konsinyasi-val">Rp {{ number_format($konsinyasi, 0, ',', '.') }}</td>
                                <td class="text-right total-val">Rp {{ number_format($total, 0, ',', '.') }}</td>
                            </tr>

                            {{-- Detail Accordion Row --}}
                            <tr class="detail-accordion-row" id="detail-{{ $index }}" style="display:none;">
                                <td colspan="9" style="padding:0; background:#f8f5ff; border-bottom: 2px solid #E9D5FF;">
                                    <div class="detail-accordion-inner">
                                        <div class="detail-acc-grid">
                                            <div class="detail-acc-section">
                                                <div class="detail-acc-title">📦 Info Item</div>
                                                <div class="detail-acc-row">
                                                    <span class="detail-acc-lbl">ID Item</span>
                                                    <span class="detail-acc-val">{{ $detail->id_item ?? '-' }}</span>
                                                </div>
                                                <div class="detail-acc-row">
                                                    <span class="detail-acc-lbl">Nama Lengkap</span>
                                                    <span class="detail-acc-val">{{ $namaItem }}</span>
                                                </div>
                                                <div class="detail-acc-row">
                                                    <span class="detail-acc-lbl">No. Invoice</span>
                                                    <span class="detail-acc-val">{{ $detail->no_invoice ?? '-' }}</span>
                                                </div>
                                            </div>
                                            <div class="detail-acc-section">
                                                <div class="detail-acc-title">💰 Rincian Harga</div>
                                                <div class="detail-acc-row">
                                                    <span class="detail-acc-lbl">Harga/PCS</span>
                                                    <span class="detail-acc-val">Rp {{ number_format($hargaPcs, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="detail-acc-row">
                                                    <span class="detail-acc-lbl">Harga Reseller/PCS</span>
                                                    <span class="detail-acc-val">Rp {{ number_format($hargaReseller, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="detail-acc-row">
                                                    <span class="detail-acc-lbl">Konsinyasi/PCS</span>
                                                    <span class="detail-acc-val" style="color:#7C5CDB; font-weight:700;">
                                                        Rp {{ number_format($konsinyasi, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="detail-acc-section">
                                                <div class="detail-acc-title">📊 Perhitungan</div>
                                                <div class="detail-acc-row">
                                                    <span class="detail-acc-lbl">Qty</span>
                                                    <span class="detail-acc-val">{{ $qty }} pcs</span>
                                                </div>
                                                <div class="detail-acc-row">
                                                    <span class="detail-acc-lbl">Nilai Konsinyasi</span>
                                                    <span class="detail-acc-val">Rp {{ number_format($konsinyasi * $qty, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="detail-acc-row">
                                                    <span class="detail-acc-lbl">Total (Reseller)</span>
                                                    <span class="detail-acc-val" style="color:#059669; font-weight:700; font-size:15px;">
                                                        Rp {{ number_format($total, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="konsinyasi-footer-row">
                            <td colspan="3" class="text-center" style="font-weight:800; letter-spacing:2px; font-size:12px;">T O T A L</td>
                            <td class="text-center">
                                <span class="qty-badge" style="background:#7C5CDB; color:#fff;">{{ $grandQty }}</span>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right" style="font-size:16px; font-weight:800; color:#7C5CDB;">
                                Rp {{ number_format($grandTotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Summary boxes --}}
            <div class="do-summary-row">
                <div class="do-summary-box" style="border-color:#E9D5FF;">
                    <div class="do-summary-label">Total Qty Barang</div>
                    <div class="do-summary-value" style="color:#7C5CDB;">{{ $grandQty }} <span style="font-size:13px; font-weight:500;">pcs</span></div>
                </div>
                <div class="do-summary-box" style="border-color:#BBF7D0;">
                    <div class="do-summary-label">Total Nilai Konsinyasi</div>
                    @php
                        $totalKonsinyasi = $detailItems->sum(function($d) {
                            return (($d->harga_perpcs ?? 0) - 215200) * ($d->quantity ?? 0);
                        });
                    @endphp
                    <div class="do-summary-value" style="color:#059669;">Rp {{ number_format($totalKonsinyasi, 0, ',', '.') }}</div>
                </div>
                <div class="do-summary-box" style="border-color:#E9D5FF; background:#F5F3FF;">
                    <div class="do-summary-label">Total (Harga Reseller)</div>
                    <div class="do-summary-value" style="color:#7C5CDB; font-size:22px;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</div>
                </div>
            </div>

            @else
                <div class="do-empty">
                    <div style="font-size:40px; margin-bottom:12px;">📭</div>
                    <div style="font-weight:600; color:#374151;">Belum ada item dalam invoice terkait</div>
                    <div style="font-size:12px; color:#9CA3AF; margin-top:4px;">Pastikan delivery order ini sudah dihubungkan dengan invoice yang memiliki detail item.</div>
                </div>
            @endif
        </div>
    </div>

    {{-- Bottom Actions --}}
    <div class="do-bottom-actions">
        <a href="{{ route('delivery.delete', $delivery->no_do) }}"
           class="btn-hdr btn-hdr-danger"
           onclick="return confirm('Yakin ingin menghapus delivery order ini?')">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px; vertical-align: middle;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
            Hapus DO
        </a>
        <a href="{{ route('delivery.index') }}" class="btn-hdr btn-hdr-back">← Kembali ke Daftar</a>
    </div>

</div>

<style>
    .do-detail-wrap {
        animation: fadeInDO 0.4s ease-out;
    }
    @keyframes fadeInDO {
        from { opacity:0; transform:translateY(10px); }
        to   { opacity:1; transform:translateY(0); }
    }

    /* Page Header */
    .do-page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 14px;
    }
    .do-page-title {
        font-size: 24px;
        font-weight: 800;
        color: #1F2937;
        margin: 0 0 4px;
    }
    .do-page-sub {
        font-size: 13px;
        color: #7C5CDB;
        font-weight: 700;
        font-family: monospace;
    }
    .do-header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* Buttons */
    .btn-hdr {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 18px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
    }
    .btn-hdr-print  { background:#E0E7FF; color:#4F46E5; }
    .btn-hdr-print:hover  { background:#4F46E5; color:#fff; transform:translateY(-1px); }
    .btn-hdr-edit   { background:#FEF3C7; color:#B45309; }
    .btn-hdr-edit:hover   { background:#F59E0B; color:#fff; transform:translateY(-1px); }
    .btn-hdr-back   { background:#F3F4F6; color:#6B7280; }
    .btn-hdr-back:hover   { background:#E5E7EB; transform:translateY(-1px); }
    .btn-hdr-danger { background:#FEE2E2; color:#DC2626; }
    .btn-hdr-danger:hover { background:#EF4444; color:#fff; transform:translateY(-1px); }

    /* Alert */
    .do-alert-success {
        background: linear-gradient(135deg,#DCFCE7,#D1FAE5);
        color: #166534;
        padding: 12px 18px;
        border-radius: 10px;
        border-left: 4px solid #10B981;
        font-weight: 500;
        font-size: 14px;
        margin-bottom: 22px;
    }

    /* Cards Grid */
    .do-cards-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .do-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #F3F4F6;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .do-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(124,92,219,0.08);
        border-color: #E9D5FF;
    }

    .do-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 16px 20px;
        border-bottom: 2px solid #E9D5FF;
        font-weight: 700;
        font-size: 15px;
        color: #1F2937;
    }
    .do-card-header-sub {
        font-size: 12px;
        font-weight: 400;
        color: #9CA3AF;
        font-style: italic;
    }

    .do-card-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .do-card-body {
        padding: 20px;
    }

    /* Info Items */
    .do-info-item {
        display: flex;
        flex-direction: column;
        gap: 3px;
        margin-bottom: 14px;
    }
    .do-info-item:last-child { margin-bottom: 0; }
    .do-info-lbl {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #9CA3AF;
    }
    .do-info-val {
        font-size: 13.5px;
        color: #1F2937;
        font-weight: 500;
    }
    .do-inv-link {
        color: #7C5CDB;
        text-decoration: none;
        font-weight: 600;
        border-bottom: 1px dashed #7C5CDB;
    }
    .do-inv-link:hover { border-bottom-style: solid; }

    /* Reseller grid */
    .do-reseller-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }

    /* Status badges */
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }
    .status-waiting    { background:#FEF3C7; color:#B45309; }
    .status-processing { background:#DBEAFE; color:#1E40AF; }
    .status-shipped    { background:#E0E7FF; color:#3730A3; }
    .status-completed  { background:#DCFCE7; color:#166534; }
    .status-cancelled  { background:#FEE2E2; color:#991B1B; }

    /* ===== Konsinyasi Table ===== */
    .konsinyasi-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12.5px;
    }

    .konsinyasi-table thead th {
        background: linear-gradient(135deg, #F5F3FF, #EDE9FE);
        color: #4C1D95;
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        padding: 12px 10px;
        text-align: center;
        border-bottom: 2px solid #E9D5FF;
        white-space: nowrap;
    }

    .konsinyasi-table tbody td {
        padding: 11px 10px;
        border-bottom: 1px solid #F3F4F6;
        color: #374151;
        vertical-align: middle;
    }

    .konsinyasi-row {
        cursor: pointer;
        transition: background 0.2s ease;
    }
    .konsinyasi-row:hover { background: #F5F3FF; }
    .konsinyasi-row.active-row { background: #EDE9FE; }

    .row-chevron {
        display: inline-block;
        font-size: 9px;
        color: #7C5CDB;
        margin-right: 4px;
        transition: transform 0.25s ease;
    }
    .row-chevron.open { transform: rotate(90deg); }

    .qty-badge {
        display: inline-block;
        background: #F5F3FF;
        color: #7C5CDB;
        padding: 3px 10px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 12px;
    }

    .konsinyasi-val { color: #7C5CDB; font-weight: 600; }
    .total-val      { color: #059669; font-weight: 700; }

    .konsinyasi-table tfoot .konsinyasi-footer-row td {
        padding: 12px 10px;
        background: linear-gradient(135deg, #F5F3FF, #EDE9FE);
        border-top: 2px solid #E9D5FF;
        border-bottom: none;
    }

    .text-right  { text-align: right; }
    .text-center { text-align: center; }

    /* ===== Accordion Detail ===== */
    .detail-accordion-row td { border-bottom: none; }

    .detail-accordion-inner {
        padding: 16px 20px;
    }

    .detail-acc-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .detail-acc-section {
        background: #fff;
        border-radius: 10px;
        padding: 14px 16px;
        border: 1px solid #E9D5FF;
    }

    .detail-acc-title {
        font-size: 12px;
        font-weight: 700;
        color: #7C5CDB;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-acc-row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        padding: 4px 0;
        border-bottom: 1px dashed #F3F4F6;
        font-size: 12px;
    }
    .detail-acc-row:last-child { border-bottom: none; }
    .detail-acc-lbl { color: #9CA3AF; font-weight: 500; }
    .detail-acc-val { color: #374151; font-weight: 600; }

    /* ===== Summary Row ===== */
    .do-summary-row {
        display: flex;
        justify-content: flex-end;
        gap: 16px;
        padding: 16px 20px;
        background: #FAFAFF;
        border-top: 2px solid #E9D5FF;
    }

    .do-summary-box {
        background: #fff;
        border: 2px solid #E9D5FF;
        border-radius: 12px;
        padding: 14px 20px;
        text-align: center;
        min-width: 180px;
    }

    .do-summary-label {
        font-size: 11px;
        font-weight: 600;
        color: #9CA3AF;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .do-summary-value {
        font-size: 20px;
        font-weight: 800;
    }

    /* Empty state */
    .do-empty {
        text-align: center;
        padding: 50px 20px;
        color: #9CA3AF;
    }

    /* Bottom actions */
    .do-bottom-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
        flex-wrap: wrap;
        gap: 10px;
    }

    @media (max-width: 768px) {
        .do-cards-grid { grid-template-columns: 1fr; }
        .do-reseller-grid { grid-template-columns: 1fr 1fr; }
        .detail-acc-grid { grid-template-columns: 1fr; }
        .do-summary-row { flex-direction: column; }
        .do-summary-box { min-width: 0; }
    }
</style>

<script>
    function toggleDetail(idx) {
        const detailRow = document.getElementById('detail-' + idx);
        const chevron   = document.getElementById('chevron-' + idx);
        const mainRows  = document.querySelectorAll('.konsinyasi-row');
        const mainRow   = mainRows[idx];

        const isOpen = detailRow.style.display !== 'none';

        if (isOpen) {
            detailRow.style.display = 'none';
            chevron.classList.remove('open');
            mainRow.classList.remove('active-row');
        } else {
            detailRow.style.display = 'table-row';
            chevron.classList.add('open');
            mainRow.classList.add('active-row');
        }
    }
</script>
@endsection

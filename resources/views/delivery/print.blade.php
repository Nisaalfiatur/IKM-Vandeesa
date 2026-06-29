<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Order (Konsinyasi) - {{ $delivery->no_do ?? 'DO' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Arial', sans-serif;
            font-size: 11px;
            color: #2C1E4A;
            background: #EAE6DF; /* Outer grey-warm paper frame on screen */
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        /* ===== Action Buttons Bar (Screen Only) ===== */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 14px;
            padding: 20px 0;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 30px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .btn-print {
            background: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(124, 92, 219, 0.3);
        }
        .btn-print:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(124, 92, 219, 0.45);
        }

        .btn-back {
            background: #FFFDF9; /* Ivory button */
            color: #6A5A8C;
            border: 1.5px solid #E4DAF5;
        }
        .btn-back:hover {
            background: #F5F2FC;
            border-color: #7C5CDB;
            color: #7C5CDB;
            transform: translateY(-2px);
        }

        /* ===== A4 Page Container ===== */
        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 20px auto;
            padding: 16mm 16mm 20mm 16mm;
            background: #FFFDF9; /* Gorgeous warm Ivory base */
            box-shadow: 0 10px 30px rgba(44, 30, 74, 0.08);
            border-radius: 12px;
            position: relative;
            border: 1px solid #F3EDE2;
        }

        /* ===== Document Title ===== */
        .doc-title-container {
            text-align: center;
            margin-bottom: 22px;
        }

        .doc-title {
            font-size: 18px;
            font-weight: 900;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #6B46C1; /* Lilac theme primary */
            display: inline-block;
            padding-bottom: 4px;
            border-bottom: 2px solid #E4DAF5;
        }

        /* ===== Top Info Grid (Tanggal & Nomor DO) ===== */
        .top-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            border: 1.5px solid #E4DAF5;
            background: #F5F2FC; /* Soft Lilac background */
            border-radius: 10px 10px 0 0;
            overflow: hidden;
        }

        .top-info-cell {
            padding: 8px 16px;
            border-right: 1.5px solid #E4DAF5;
        }
        .top-info-cell:last-child {
            border-right: none;
        }

        .top-info-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .top-info-label {
            font-weight: 800;
            color: #6A5A8C;
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            min-width: 90px;
        }

        .top-info-val {
            color: #2C1E4A;
            font-weight: 700;
            font-size: 11px;
        }

        /* ===== Main Sender & Receiver Block ===== */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            border: 1.5px solid #E4DAF5;
            border-top: none;
            background: #FFFDF9; /* Ivory card body */
            border-radius: 0 0 10px 10px;
            overflow: hidden;
            margin-bottom: 18px;
        }

        .info-table td {
            width: 50%;
            padding: 12px 16px;
            vertical-align: top;
            border-bottom: none;
        }

        .info-table td:first-child {
            border-right: 1.5px solid #E4DAF5;
        }

        /* Col Header inside Info Block */
        .info-header {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #7C5CDB;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
            border-bottom: 1px dashed #E4DAF5;
            padding-bottom: 6px;
        }

        .info-row-inner {
            display: flex;
            gap: 8px;
            margin-bottom: 6px;
            line-height: 1.4;
        }
        .info-row-inner:last-child {
            margin-bottom: 0;
        }

        .info-row-label {
            font-weight: 700;
            color: #6A5A8C;
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: 80px;
            flex-shrink: 0;
        }

        .info-row-val {
            color: #2C1E4A;
            font-weight: 500;
            font-size: 10.5px;
        }
        .info-row-val a {
            color: #7C5CDB;
            text-decoration: none;
            font-weight: 600;
        }

        /* ===== Items Table ===== */
        .items-table-wrap {
            margin-top: 14px;
            margin-bottom: 12px;
            border: 1.5px solid #E4DAF5;
            border-radius: 10px;
            overflow: hidden;
            background: #FFFDF9;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table thead th {
            background: #F5F2FC; /* Lilac header */
            color: #6B46C1;
            font-weight: 800;
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px 8px;
            border-bottom: 1.5px solid #E4DAF5;
            text-align: center;
        }

        .items-table thead th.text-left { text-align: left; }
        .items-table thead th.text-right { text-align: right; }

        .items-table tbody td {
            padding: 10px 8px;
            border-bottom: 1px solid #F5F2FC;
            color: #2C1E4A;
            font-size: 10px;
            font-weight: 500;
        }

        .items-table tbody tr:nth-child(even) td {
            background: #FFFDF9;
        }

        .items-table tbody tr:nth-child(odd) td {
            background: #FCFAF5; /* Extremely subtle ivory alternate stripe */
        }

        .items-table tbody tr.spacer-row td {
            height: 12px;
            border: none;
            background: #FFFDF9 !important;
            border-bottom: 1.5px solid #E4DAF5;
        }

        .items-table tfoot td {
            background: #F5F2FC;
            color: #6B46C1;
            font-weight: 800;
            font-size: 11px;
            padding: 10px 8px;
            border-top: 1.5px solid #E4DAF5;
        }

        .qty-badge {
            background: #E4DAF5;
            color: #6B46C1;
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 9.5px;
        }

        .price-highlight {
            color: #2C1E4A;
            font-weight: 600;
        }

        .total-highlight {
            color: #6B46C1;
            font-weight: 800;
            font-size: 11px;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }

        /* ===== Terms and Conditions ===== */
        .terms-section {
            margin-top: 15px;
            padding: 12px 16px;
            background: #FCFAF5;
            border-left: 3px solid #7C5CDB;
            border-radius: 4px 8px 8px 4px;
            font-size: 9px;
            color: #6A5A8C;
            line-height: 1.6;
        }

        .terms-title {
            font-weight: 800;
            color: #6B46C1;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
            font-size: 9.5px;
        }

        /* ===== Signature Section ===== */
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 35px;
            gap: 40px;
        }

        .sig-block {
            flex: 1;
            text-align: center;
        }

        .sig-role {
            font-size: 10px;
            font-weight: 700;
            color: #6A5A8C;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .sig-company {
            font-size: 11px;
            font-weight: 800;
            color: #6B46C1;
            margin-bottom: 50px;
        }

        .sig-line {
            border-bottom: 1.5px solid #E4DAF5;
            margin: 0 15px 4px 15px;
        }

        .sig-name {
            font-size: 10.5px;
            font-weight: 700;
            color: #2C1E4A;
            min-height: 15px;
        }

        /* ===== Print Setup ===== */
        @media print {
            body {
                background: #ffffff;
            }

            .action-buttons {
                display: none !important;
            }

            .page {
                width: 210mm;
                min-height: auto;
                margin: 0;
                padding: 10mm 12mm 15mm 12mm;
                box-shadow: none;
                border: none;
                background: #FFFDF9; /* Retain Ivory in print */
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .top-info, .items-table thead th, .items-table tfoot td {
                background-color: #F5F2FC !important;
            }

            .info-table {
                background-color: #FFFDF9 !important;
            }

            .terms-section {
                background-color: #FCFAF5 !important;
            }
            
            @page {
                size: A4;
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Action Buttons (Screen Only) -->
    <div class="action-buttons">
        <a href="{{ url()->previous() }}" class="btn-action btn-back">← Kembali</a>
        <button onclick="window.print()" class="btn-action btn-print">🖨️ Cetak DO Konsinyasi</button>
    </div>

    <!-- A4 Page Frame -->
    <div class="page">

        <!-- Title -->
        <div class="doc-title-container">
            <div class="doc-title">Delivery Order (Konsinyasi)</div>
        </div>

        <!-- Top Info Grid: Tanggal & Nomor DO -->
        <div class="top-info">
            <div class="top-info-cell">
                <div class="top-info-row">
                    <span class="top-info-label">Tanggal</span>
                    <span class="top-info-val">
                        {{ $delivery->tanggal ? \Carbon\Carbon::parse($delivery->tanggal)->format('d F Y') : '-' }}
                    </span>
                </div>
            </div>
            <div class="top-info-cell">
                <div class="top-info-row">
                    <span class="top-info-label">Nomor DO</span>
                    <span class="top-info-val" style="font-family: monospace; letter-spacing: 0.5px;">{{ $delivery->no_do ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Info Block: Pengirim & Penerima -->
        <table class="info-table">
            <tbody>
                <tr>
                    <!-- Left: Pengirim -->
                    <td>
                        <div class="info-header">
                            <span>📤 Pengirim</span>
                        </div>
                        <div class="info-row-inner">
                            <span class="info-row-label">Nama</span>
                            <span class="info-row-val" style="font-weight: 700;">Vivi Susanti</span>
                        </div>
                        <div class="info-row-inner">
                            <span class="info-row-label">Brand</span>
                            <span class="info-row-val" style="font-weight: 700; color: #7C5CDB;">VANDEESA</span>
                        </div>
                        <div class="info-row-inner">
                            <span class="info-row-label">Alamat</span>
                            <span class="info-row-val">Perum. Koja Utama, Jl. H. Koja No. 6P Kukusan - Beji, Depok 16425</span>
                        </div>
                        <div class="info-row-inner">
                            <span class="info-row-label">No. HP</span>
                            <span class="info-row-val">+62 822-1868-2500</span>
                        </div>
                        <div class="info-row-inner">
                            <span class="info-row-label">Email</span>
                            <span class="info-row-val">
                                <a href="mailto:vandeesa.butik@gmail.com">vandeesa.butik@gmail.com</a>
                            </span>
                        </div>
                    </td>

                    <!-- Right: Penerima -->
                    <td>
                        <div class="info-header">
                            <span>📥 Penerima</span>
                        </div>
                        <div class="info-row-inner">
                            <span class="info-row-label">Nama</span>
                            <span class="info-row-val" style="font-weight: 700;">{{ optional($delivery->invoice)->nama_pelanggan ?? optional($delivery->reseller)->nama ?? '-' }}</span>
                        </div>
                        <div class="info-row-inner">
                            <span class="info-row-label">Brand</span>
                            <span class="info-row-val" style="font-weight: 700; color: #7C5CDB;">{{ optional($delivery->reseller)->nama_brand ?? '-' }}</span>
                        </div>
                        <div class="info-row-inner">
                            <span class="info-row-label">Alamat</span>
                            <span class="info-row-val">{{ optional($delivery->reseller)->alamat ?? '-' }}</span>
                        </div>
                        <div class="info-row-inner">
                            <span class="info-row-label">No. HP</span>
                            <span class="info-row-val">{{ optional($delivery->reseller)->no_telp ?? '-' }}</span>
                        </div>
                        <div class="info-row-inner">
                            <span class="info-row-label">Email</span>
                            <span class="info-row-val">{{ optional($delivery->reseller)->email ?? '-' }}</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Items Table -->
        <div class="items-table-wrap">
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 35px;">No.</th>
                        <th style="width: 120px;" class="text-left">Item</th>
                        <th class="text-left">Deskripsi Produk</th>
                        <th style="width: 45px;">Qty</th>
                        <th style="width: 50px;">Satuan</th>
                        <th style="width: 85px;" class="text-right">Harga (pcs)</th>
                        <th style="width: 100px;" class="text-right">Harga Reseller</th>
                        <th style="width: 90px;" class="text-right">Konsinyasi</th>
                        <th style="width: 95px;" class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandTotal = 0;
                        $totalQty = 0;
                    @endphp
                    @if($delivery->invoice && $delivery->invoice->detail && count($delivery->invoice->detail) > 0)
                        @foreach($delivery->invoice->detail as $index => $detail)
                            @php
                                $hargaPcs     = $detail->harga_perpcs ?? 0;
                                $hargaReseller = 215200;
                                $qty          = $detail->quantity ?? 0;
                                $konsinyasi   = $hargaPcs - $hargaReseller;
                                $total        = $hargaReseller * $qty;
                                $grandTotal  += $total;
                                $totalQty    += $qty;

                                $namaItem = $detail->item->nama_item ?? '-';
                                $itemParts = explode(' - ', $namaItem, 2);
                                $itemType  = $itemParts[0] ?? $namaItem;
                                $itemDesc  = $itemParts[1] ?? '';
                            @endphp
                            <tr>
                                <td class="text-center" style="font-weight: 600; color: #6A5A8C;">{{ $index + 1 }}</td>
                                <td style="font-weight: 600;">{{ $itemType }}</td>
                                <td style="color: #6A5A8C;">{{ $itemDesc ?: $namaItem }}</td>
                                <td class="text-center">
                                    <span class="qty-badge">{{ $qty }}</span>
                                </td>
                                <td class="text-center" style="color: #6A5A8C;">pcs</td>
                                <td class="text-right price-highlight">Rp {{ number_format($hargaPcs, 0, ',', '.') }}</td>
                                <td class="text-right price-highlight">Rp {{ number_format($hargaReseller, 0, ',', '.') }}</td>
                                <td class="text-right" style="color: #7C5CDB; font-weight: 600;">Rp {{ number_format($konsinyasi, 0, ',', '.') }}</td>
                                <td class="text-right total-highlight">Rp {{ number_format($total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="text-center" style="padding: 24px; color: #6A5A8C; font-style: italic; background: #FFFDF9 !important;">
                                Tidak ada data barang
                            </td>
                        </tr>
                    @endif
                    <!-- Spacer Row -->
                    <tr class="spacer-row"><td colspan="9"></td></tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-center" style="font-size: 11px; letter-spacing: 2px;">T O T A L</td>
                        <td class="text-center">
                            <span class="qty-badge" style="background: #7C5CDB; color: #ffffff;">{{ $totalQty }}</span>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right" style="font-size: 12.5px; font-weight: 900; color: #6B46C1;">
                            Rp {{ number_format($grandTotal, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Terms & Conditions -->
        <div class="terms-section">
            <div class="terms-title">Syarat & Ketentuan Konsinyasi :</div>
            <p>1. Barang di atas adalah milik <strong>VANDEESA</strong> yang dititipkan untuk dijualkan.</p>
            <p>2. Reseller wajib melaporkan sisa stok (stock opname) secara berkala setiap Bulan.</p>
            <p>3. Pembayaran dilakukan atas barang yang laku terjual setiap periode minggu berjalan.</p>
        </div>

        <!-- Signatures -->
        <div class="signature-section">
            <div class="sig-block">
                <div class="sig-role">Pengirim/Pemilik,</div>
                <div class="sig-company">VANDEESA</div>
                <div class="sig-line"></div>
                <div class="sig-name">Vivi Susanti</div>
            </div>
            <div class="sig-block" style="flex: 1.5;"></div>
            <div class="sig-block">
                <div class="sig-role">Penerima/Mitra,</div>
                <div class="sig-company">{{ optional($delivery->reseller)->nama_brand ?? optional($delivery->reseller)->nama ?? 'MITRA' }}</div>
                <div class="sig-line"></div>
                <div class="sig-name">{{ optional($delivery->invoice)->nama_pelanggan ?? optional($delivery->reseller)->nama ?? '........................' }}</div>
            </div>
        </div>

    </div>

    <script>
        window.addEventListener('load', function() {
            setTimeout(function() { window.print(); }, 500);
        });
    </script>
</body>
</html>

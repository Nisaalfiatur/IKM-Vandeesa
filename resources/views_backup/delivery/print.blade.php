<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan - {{ $delivery->no_do ?? 'DO' }}</title>
    <style>
        /* ===== Reset & Base ===== */
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'Arial', sans-serif;
            font-size: 12px;
            color: #1a1a1a;
            background: #e5e7eb;
            line-height: 1.5;
        }

        /* ===== A4 Page Container ===== */
        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 20px auto;
            padding: 20mm 18mm 25mm 18mm;
            background: #ffffff;
            box-shadow: 0 2px 12px rgba(0,0,0,0.15);
            position: relative;
        }

        /* ===== Action Buttons ===== */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 12px;
            padding: 16px 0;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 28px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .btn-action:hover {
            opacity: 0.85;
        }

        .btn-print {
            background: #7C5CDB;
            color: #ffffff;
        }

        .btn-back {
            background: #ffffff;
            color: #374151;
            border: 1px solid #D1D5DB;
        }

        .btn-back:hover {
            background: #F9FAFB;
        }

        /* ===== Company Header ===== */
        .company-header {
            text-align: center;
            padding-bottom: 14px;
            border-bottom: 3px double #1a1a1a;
            margin-bottom: 6px;
        }

        .company-name {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 6px;
            text-transform: uppercase;
            color: #1a1a1a;
            margin-bottom: 2px;
        }

        .company-tagline {
            font-size: 10px;
            color: #555;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* ===== Document Title ===== */
        .document-title {
            text-align: center;
            padding: 12px 0 10px 0;
            border-bottom: 1px solid #1a1a1a;
            margin-bottom: 16px;
        }

        .document-title h2 {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #1a1a1a;
        }

        /* ===== Two Column Info ===== */
        .info-columns {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            margin-bottom: 18px;
        }

        .info-col {
            flex: 1;
        }

        .info-row {
            display: flex;
            margin-bottom: 4px;
            font-size: 11.5px;
        }

        .info-label {
            width: 105px;
            font-weight: 600;
            color: #333;
            flex-shrink: 0;
        }

        .info-separator {
            width: 14px;
            text-align: center;
            flex-shrink: 0;
        }

        .info-value {
            flex: 1;
            color: #1a1a1a;
        }

        /* ===== Sections ===== */
        .section {
            margin-bottom: 16px;
        }

        .section-title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #1a1a1a;
            padding: 5px 8px;
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            border-bottom: none;
            margin-bottom: 0;
        }

        .section-body {
            border: 1px solid #d1d5db;
            padding: 10px 12px;
        }

        .section-body .info-row {
            margin-bottom: 3px;
        }

        .section-body .info-label {
            width: 100px;
        }

        /* ===== Status Badge ===== */
        .status-text {
            display: inline-block;
            padding: 1px 10px;
            border: 1px solid #333;
            border-radius: 3px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ===== Items Table ===== */
        .items-section {
            margin-bottom: 18px;
        }

        .items-section .section-title {
            border-bottom: none;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11.5px;
        }

        .items-table thead th {
            background: #f3f4f6;
            border: 1px solid #999;
            padding: 7px 8px;
            text-align: center;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1a1a1a;
        }

        .items-table tbody td {
            border: 1px solid #bbb;
            padding: 6px 8px;
            vertical-align: middle;
            color: #1a1a1a;
        }

        .items-table tbody tr:nth-child(even) {
            background: #fafafa;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .items-table tfoot td {
            border: 1px solid #999;
            padding: 7px 8px;
            font-weight: 700;
            font-size: 12px;
            color: #1a1a1a;
        }

        .total-label {
            text-align: right;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .total-value {
            text-align: right;
            font-size: 13px;
        }

        /* ===== Notes ===== */
        .notes-section {
            margin-bottom: 24px;
            font-size: 11px;
        }

        .notes-section .notes-label {
            font-weight: 700;
            margin-bottom: 3px;
        }

        .notes-section .notes-content {
            border: 1px solid #d1d5db;
            padding: 8px 10px;
            min-height: 36px;
            color: #555;
            font-style: italic;
        }

        /* ===== Signature Section ===== */
        .signature-section {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .signature-block {
            flex: 1;
            text-align: center;
        }

        .signature-role {
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 60px;
            color: #1a1a1a;
        }

        .signature-line {
            border-bottom: 1px dotted #555;
            margin: 0 15px 4px 15px;
        }

        .signature-name {
            font-size: 11px;
            font-weight: 600;
            color: #1a1a1a;
            min-height: 16px;
        }

        /* ===== Footer ===== */
        .document-footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #d1d5db;
            text-align: center;
            font-size: 9px;
            color: #999;
            letter-spacing: 0.5px;
        }

        /* ===== Print Styles ===== */
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
                padding: 15mm 18mm 20mm 18mm;
                box-shadow: none;
                border: none;
            }

            .items-table tbody tr:nth-child(even) {
                background: #f9f9f9 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .section-title,
            .items-table thead th {
                background: #f3f4f6 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .signature-section {
                page-break-inside: avoid;
            }

            @page {
                size: A4;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ url()->previous() }}" class="btn-action btn-back">
            ← Kembali
        </a>
        <button onclick="window.print()" class="btn-action btn-print">
            🖨️ Cetak Surat Jalan
        </button>
    </div>

    <!-- A4 Page -->
    <div class="page">
        <!-- Company Header -->
        <div class="company-header">
            <div class="company-name">VANDEESA</div>
            <div class="company-tagline">Beauty &amp; Skincare Products</div>
        </div>

        <!-- Document Title -->
        <div class="document-title">
            <h2>Surat Jalan / Delivery Order</h2>
        </div>

        <!-- Two Column Info -->
        <div class="info-columns">
            <div class="info-col">
                <div class="info-row">
                    <span class="info-label">No. DO</span>
                    <span class="info-separator">:</span>
                    <span class="info-value" style="font-weight:700;">{{ $delivery->no_do ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal</span>
                    <span class="info-separator">:</span>
                    <span class="info-value">
                        {{ $delivery->tanggal ? \Carbon\Carbon::parse($delivery->tanggal)->translatedFormat('d F Y') : '-' }}
                    </span>
                </div>
            </div>
            <div class="info-col">
                <div class="info-row">
                    <span class="info-label">No. Invoice</span>
                    <span class="info-separator">:</span>
                    <span class="info-value">{{ $delivery->invoice->no_invoice ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-separator">:</span>
                    <span class="info-value">
                        <span class="status-text">{{ ucfirst($delivery->status ?? '-') }}</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Data Reseller -->
        @if($delivery->reseller)
        <div class="section">
            <div class="section-title">Data Reseller</div>
            <div class="section-body">
                <div class="info-row">
                    <span class="info-label">Nama</span>
                    <span class="info-separator">:</span>
                    <span class="info-value">{{ $delivery->reseller->nama ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Brand</span>
                    <span class="info-separator">:</span>
                    <span class="info-value">{{ $delivery->reseller->brand ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">No. Telp</span>
                    <span class="info-separator">:</span>
                    <span class="info-value">{{ $delivery->reseller->no_telp ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Alamat</span>
                    <span class="info-separator">:</span>
                    <span class="info-value">{{ $delivery->reseller->alamat ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-separator">:</span>
                    <span class="info-value">{{ $delivery->reseller->email ?? '-' }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Pegawai Pengirim -->
        @if($delivery->pegawai)
        <div class="section">
            <div class="section-title">Pegawai Pengirim</div>
            <div class="section-body">
                <div class="info-row">
                    <span class="info-label">Nama</span>
                    <span class="info-separator">:</span>
                    <span class="info-value">{{ $delivery->pegawai->nama ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Jabatan</span>
                    <span class="info-separator">:</span>
                    <span class="info-value">{{ $delivery->pegawai->jabatan ?? '-' }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Data Pelanggan -->
        @if($delivery->invoice && $delivery->invoice->pelanggan)
        <div class="section">
            <div class="section-title">Data Pelanggan</div>
            <div class="section-body">
                <div class="info-row">
                    <span class="info-label">Nama</span>
                    <span class="info-separator">:</span>
                    <span class="info-value">{{ $delivery->invoice->pelanggan->nama ?? '-' }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Items Table -->
        <div class="items-section">
            <div class="section-title">Daftar Barang</div>
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width:40px;">No</th>
                        <th>Nama Item</th>
                        <th style="width:60px;">Qty</th>
                        <th style="width:120px;">Harga</th>
                        <th style="width:130px;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @if($delivery->invoice && $delivery->invoice->detail)
                        @foreach($delivery->invoice->detail as $index => $detail)
                            @php
                                $harga = $detail->harga ?? 0;
                                $qty = $detail->qty ?? 0;
                                $subtotal = $harga * $qty;
                                $grandTotal += $subtotal;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $detail->item->nama ?? '-' }}</td>
                                <td class="text-center">{{ $qty }}</td>
                                <td class="text-right">Rp {{ number_format($harga, 0, ',', '.') }}</td>
                                <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center" style="padding:16px; color:#999; font-style:italic;">
                                Tidak ada data barang
                            </td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="total-label">Total</td>
                        <td class="total-value">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Notes -->
        <div class="notes-section">
            <div class="notes-label">Catatan:</div>
            <div class="notes-content">
                {{ $delivery->catatan ?? 'Barang yang sudah dikirim tidak dapat dikembalikan kecuali ada kesepakatan tertulis.' }}
            </div>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-block">
                <div class="signature-role">Pengirim</div>
                <div class="signature-line"></div>
                <div class="signature-name">{{ $delivery->pegawai->nama ?? '........................' }}</div>
            </div>
            <div class="signature-block">
                <div class="signature-role">Penerima</div>
                <div class="signature-line"></div>
                <div class="signature-name">{{ $delivery->invoice->pelanggan->nama ?? '........................' }}</div>
            </div>
            <div class="signature-block">
                <div class="signature-role">Mengetahui</div>
                <div class="signature-line"></div>
                <div class="signature-name">........................</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="document-footer">
            Dokumen ini dicetak secara otomatis oleh sistem &mdash; {{ now()->translatedFormat('d F Y, H:i') }} WIB
        </div>
    </div>

    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->no_invoice }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Arial', sans-serif;
            font-size: 12px;
            color: #000;
            background: #EAE6DF; /* Outer grey-warm paper frame on screen */
            -webkit-font-smoothing: antialiased;
        }

        /* ===== Action Bar (Screen Only) ===== */
        .action-bar {
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
        .btn-action:hover { opacity: 0.85; }
        .btn-print { background: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%); color: #fff; box-shadow: 0 4px 15px rgba(124, 92, 219, 0.3); }
        .btn-print:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(124, 92, 219, 0.45); }
        .btn-back  { background: #FFFDF9; color: #6A5A8C; border: 1.5px solid #E4DAF5; }
        .btn-back:hover { background: #F5F2FC; border-color: #7C5CDB; color: #7C5CDB; transform: translateY(-2px); }

        /* ===== A4 Page Container ===== */
        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 20px auto;
            padding: 25mm 20mm;
            background: #FFFFFF;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
        }

        /* ===== Header ===== */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 50px;
            position: relative;
            z-index: 2;
        }

        .invoice-title-text {
            font-family: 'Times New Roman', Times, serif;
            font-size: 44px;
            font-weight: bold;
            color: #000;
            line-height: 1;
        }

        .company-block {
            text-align: right;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .company-logo {
            height: 55px;
            margin-bottom: 8px;
            object-fit: contain;
        }

        .company-address {
            font-size: 11px;
            color: #333;
            font-weight: 500;
        }

        /* ===== Info Block: KEPADA + INVOICE DETAILS ===== */
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
            position: relative;
            z-index: 2;
        }

        .to-block {
            flex: 1;
        }

        .to-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: #000;
            margin-bottom: 4px;
        }

        .to-name {
            font-size: 12px;
            color: #000;
            margin-bottom: 2px;
        }

        .to-phone {
            font-size: 12px;
            color: #000;
        }

        .invoice-details-block {
            text-align: left;
            min-width: 260px;
        }

        .inv-detail-row {
            display: flex;
            align-items: baseline;
            gap: 10px;
            margin-bottom: 4px;
            font-size: 12px;
        }

        .inv-detail-key {
            font-weight: 700;
            color: #000;
            min-width: 70px;
            text-transform: uppercase;
        }

        .inv-detail-val {
            color: #000;
            font-weight: 500;
        }

        .inv-detail-no {
            font-weight: 700;
        }

        /* ===== Items Table ===== */
        .items-table-wrap {
            position: relative;
            z-index: 2;
            margin-bottom: 10px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .items-table th, .items-table td {
            padding: 10px 4px;
        }

        .items-table thead th {
            border-top: 1.5px solid #000;
            border-bottom: 1.5px solid #000;
            text-align: left;
            font-weight: 700;
            color: #000;
        }

        .items-table thead th.text-center { text-align: center; }

        .items-table tbody td {
            vertical-align: top;
            color: #000;
            padding-top: 12px;
            padding-bottom: 12px;
        }

        /* Solid line below items */
        .hr-items-bottom {
            border: none;
            border-top: 1px solid #000;
            margin: 0 0 15px 0;
            position: relative;
            z-index: 2;
        }

        /* ===== Watermark ===== */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
            opacity: 0.08; /* slightly visible for watermark */
            z-index: 1;
            pointer-events: none;
            user-select: none;
            display: flex;
            justify-content: center;
        }

        .watermark img {
            width: 100%;
            max-width: 500px;
            object-fit: contain;
        }

        /* ===== Bottom Section ===== */
        .bottom-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            position: relative;
            z-index: 2;
        }

        .payment-block {
            flex: 1;
        }

        .payment-label {
            font-weight: 700;
            font-size: 12px;
            margin-bottom: 4px;
            text-transform: uppercase;
            color: #000;
        }

        .payment-detail {
            font-size: 12px;
            color: #000;
            line-height: 1.5;
        }

        .summary-block {
            min-width: 250px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            padding: 4px 0;
            color: #000;
        }

        .summary-row .sum-label { }
        .summary-row .sum-val   { text-align: right; min-width: 100px; }

        .summary-total-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            font-weight: 700;
            color: #000;
            padding-top: 12px;
            margin-top: 6px;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* ===== Print Setup ===== */
        @media print {
            body { background: #ffffff; }
            .action-bar { display: none !important; }
            .page {
                width: 210mm;
                min-height: auto;
                margin: 0;
                padding: 15mm 20mm;
                box-shadow: none;
                border: none;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            @page { size: A4; margin: 0; }
        }
    </style>
</head>
<body>

    <!-- Action Bar (Screen Only) -->
    <div class="action-bar no-print">
        <a href="{{ url()->previous() }}" class="btn-action btn-back">← Kembali</a>
        <button onclick="window.print()" class="btn-action btn-print">🖨️ Cetak Invoice</button>
    </div>

    <!-- A4 Page Container -->
    <div class="page">

        <!-- Watermark -->
        <div class="watermark">
            <img src="{{ asset('images/items/LOGO%20VANDEESA.png') }}" alt="Watermark">
        </div>

        <!-- Header: INVOICE title (left) + Company info (right) -->
        <div class="header">
            <div class="invoice-title-text">INVOICE</div>
            <div class="company-block">
                <img src="{{ asset('images/items/LOGO%20VANDEESA.png') }}" alt="Vandeesa Logo" class="company-logo">
                <div class="company-address">Jl. H. Kodja No. 6P Kota Depok, Jawa Barat</div>
            </div>
        </div>

        <!-- KEPADA + Invoice Number Details -->
        <div class="info-row">
            <!-- Receiver Card -->
            <div class="to-block">
                <div class="to-label">KEPADA</div>
                <div class="to-name">
                    Bapak/Ibu {{ $invoice->pelanggan->nama ?? '-' }}
                    @if($invoice->pelanggan && $invoice->pelanggan->nama_toko ?? false)
                        ({{ $invoice->pelanggan->nama_toko }})
                    @endif
                </div>
                <div class="to-phone">
                    {{ $invoice->pelanggan->no_telpn ?? '-' }}
                    @if($invoice->member && $invoice->member->nama)
                        (Member - {{ $invoice->member->nama }})
                    @endif
                </div>
            </div>

            <!-- Details Box -->
            <div class="invoice-details-block">
                <div class="inv-detail-row">
                    <span class="inv-detail-key">INVOICE</span>
                    <span class="inv-detail-val inv-detail-no">: {{ $invoice->no_invoice }}</span>
                </div>
                <div class="inv-detail-row">
                    <span class="inv-detail-key">Tanggal</span>
                    <span class="inv-detail-val">: {{ \Carbon\Carbon::parse($invoice->tanggal)->format('d-m-Y') }}</span>
                </div>
                <div class="inv-detail-row">
                    <span class="inv-detail-key">ID Member</span>
                    <span class="inv-detail-val">: {{ $invoice->id_member ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="items-table-wrap">
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 40px;" class="text-center">No</th>
                        <th>Product Name</th>
                        <th class="text-center" style="width: 120px;">Price</th>
                        <th class="text-center" style="width: 70px;">Qty</th>
                        <th class="text-center" style="width: 140px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $subtotal = 0;
                    @endphp
                    @forelse($invoice->detail as $index => $detail)
                        @php
                            $lineTotal = ($detail->harga_perpcs ?? 0) * ($detail->quantity ?? 0);
                            $subtotal += $lineTotal;
                        @endphp
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $detail->item->nama_item ?? 'N/A' }}</td>
                            <td class="text-center">Rp {{ number_format($detail->harga_perpcs ?? 0, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $detail->quantity ?? 0 }}</td>
                            <td class="text-center">Rp {{ number_format($lineTotal, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 24px; font-style: italic;">
                                Tidak ada item
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <hr class="hr-items-bottom">

        <!-- Bottom Section: Payment (left) + Summary (right) -->
        @php
            $totalInvoice   = $invoice->total_harga ?? $subtotal;
            $biayaLainLain  = 0;
            $diskon         = max(0, $subtotal - $totalInvoice);
            $finalTotal     = $totalInvoice;
        @endphp
        <div class="bottom-section">
            <!-- Payment Info -->
            <div class="payment-block">
                <div class="payment-label">METODE PEMBAYARAN</div>
                <div class="payment-detail">
                    Transfer Bank<br>
                    Bank Mandiri<br>
                    1570003560449<br>
                    A/n Vivi Susanti SA
                </div>
            </div>

            <!-- Financial Summary -->
            <div class="summary-block">
                <div class="summary-row">
                    <span class="sum-label">Subtotal</span>
                    <span class="sum-val">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                    <span class="sum-label">Biaya lain-lain</span>
                    <span class="sum-val">Rp {{ number_format($biayaLainLain, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                    <span class="sum-label">Diskon</span>
                    <span class="sum-val">Rp {{ number_format($diskon, 0, ',', '.') }}</span>
                </div>
                <div class="summary-total-row">
                    <span>Total Price</span>
                    <span>Rp {{ number_format($finalTotal, 0, ',', '.') }}</span>
                </div>
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

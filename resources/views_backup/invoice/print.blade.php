<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->no_invoice }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            background: #f5f5f5;
            padding: 20px;
        }

        .print-container {
            background: white;
            max-width: 900px;
            margin: 0 auto;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #7C5CDB;
            padding-bottom: 20px;
        }

        .company-name {
            font-size: 28px;
            font-weight: bold;
            color: #7C5CDB;
            margin-bottom: 5px;
        }

        .company-subtitle {
            color: #6B7280;
            font-size: 14px;
        }

        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            color: #1F2937;
        }

        .invoice-number {
            font-size: 16px;
            color: #6B7280;
            margin-bottom: 20px;
        }

        .info-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .info-box {
            border: 1px solid #E5E7EB;
            padding: 15px;
            border-radius: 8px;
            background: #F9FAFB;
        }

        .info-box h4 {
            color: #7C5CDB;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            font-size: 13px;
        }

        .info-row label {
            color: #6B7280;
            font-weight: bold;
        }

        .info-row span {
            color: #374151;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        thead {
            background: #F3F4F6;
            border-top: 2px solid #7C5CDB;
            border-bottom: 2px solid #7C5CDB;
        }

        th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            color: #374151;
            font-size: 13px;
        }

        tbody tr {
            border-bottom: 1px solid #E5E7EB;
        }

        tbody tr:hover {
            background: #F9FAFB;
        }

        td {
            padding: 12px;
            font-size: 13px;
        }

        .qty {
            text-align: center;
        }

        .money {
            text-align: right;
        }

        .summary-section {
            display: flex;
            justify-content: flex-end;
            margin: 30px 0;
        }

        .summary-box {
            background: #F5F3FF;
            border: 2px solid #E9D5FF;
            border-radius: 8px;
            padding: 20px;
            min-width: 300px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 13px;
            border-bottom: 1px solid #E9D5FF;
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .summary-row label {
            color: #6B7280;
            font-weight: bold;
        }

        .summary-row span {
            color: #374151;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            font-size: 18px;
            font-weight: bold;
            color: #7C5CDB;
            border-top: 2px solid #E9D5FF;
            margin-top: 10px;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #E5E7EB;
            text-align: center;
            color: #6B7280;
            font-size: 12px;
        }

        .signature-section {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 40px;
            margin-top: 40px;
            text-align: center;
        }

        .signature-box {
            border-top: 1px solid #333;
            padding-top: 40px;
            font-size: 12px;
        }

        .signature-box p {
            margin: 5px 0;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .print-container {
                box-shadow: none;
                margin: 0;
                padding: 20px;
            }

            .no-print {
                display: none !important;
            }
        }

        .print-button {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px;
            background: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%);
            border-radius: 8px;
        }

        .print-button button {
            padding: 10px 20px;
            background: white;
            color: #7C5CDB;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .print-button button:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="print-container">
    <!-- Print Button -->
    <div class="print-button no-print">
        <button onclick="window.print()">🖨️ Cetak Invoice</button>
    </div>

    <!-- Header -->
    <div class="header">
        <div class="company-name">V</div>
        <div class="company-subtitle">PT. Vandeesa Indonesia</div>
        <div class="invoice-title">INVOICE</div>
        <div class="invoice-number">No: {{ $invoice->no_invoice }}</div>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <!-- Customer Info -->
        <div class="info-box">
            <h4>👤 Informasi Pelanggan</h4>
            <div class="info-row">
                <label>Nama</label>
                <span>{{ $invoice->pelanggan->nama ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <label>No Telp</label>
                <span>{{ $invoice->pelanggan->no_telpn ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <label>Member</label>
                <span>{{ $invoice->member->nama ?? 'N/A' }}</span>
            </div>
        </div>

        <!-- Invoice Info -->
        <div class="info-box">
            <h4>📋 Informasi Invoice</h4>
            <div class="info-row">
                <label>Tanggal</label>
                <span>{{ \Carbon\Carbon::parse($invoice->tanggal)->format('d F Y') }}</span>
            </div>
            <div class="info-row">
                <label>Kasir</label>
                <span>{{ $invoice->kasir->nama_pg ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <label>Pegawai</label>
                <span>{{ $invoice->pegawai->nama_pg ?? 'N/A' }}</span>
            </div>
        </div>
    </div>

    <!-- Detail Table -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Item</th>
                <th class="qty">Qty</th>
                <th class="money">Harga Per PCS</th>
                <th class="money">Harga Reseller</th>
                <th class="money">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invoice->detail as $index => $detail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->item->nama_item ?? 'N/A' }}</td>
                <td class="qty">{{ $detail->quantity }}</td>
                <td class="money">Rp {{ number_format($detail->harga_perpcs, 0, ',', '.') }}</td>
                <td class="money">Rp {{ number_format($detail->harga_reseller, 0, ',', '.') }}</td>
                <td class="money">Rp {{ number_format($detail->harga_perpcs * $detail->quantity, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 30px;">Tidak ada detail item</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Summary Section -->
    <div class="summary-section">
        <div class="summary-box">
            <div class="summary-row">
                <label>Subtotal</label>
                <span>Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <label>Pajak (0%)</label>
                <span>Rp 0</span>
            </div>
            <div class="summary-row">
                <label>Diskon</label>
                <span>Rp 0</span>
            </div>
            <div class="total-row">
                <label>Total</label>
                <span>Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <p><strong>Diperiksa Oleh</strong></p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>{{ $invoice->pegawai->nama_pg ?? '(_________________)' }}</p>
        </div>
        <div class="signature-box">
            <p><strong>Disetujui Oleh</strong></p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>(_______________)</p>
        </div>
        <div class="signature-box">
            <p><strong>Diterima Oleh</strong></p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>{{ $invoice->pelanggan->nama ?? '(_________________)' }}</p>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini adalah bukti transaksi yang sah dan berlaku sebagai pengganti uang tunai.</p>
        <p>Terima kasih atas kepercayaan Anda. — PT. Vandeesa Indonesia</p>
    </div>
</div>

</body>
</html>

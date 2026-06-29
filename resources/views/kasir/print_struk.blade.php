<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran - {{ $invoice->no_invoice }}</title>
    <style>
        @page {
            margin: 0;
            size: 80mm auto; /* Typical thermal paper size */
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            background: #e2e2e2;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
        }
        
        .receipt-container {
            background: #fff;
            width: 80mm;
            max-width: 320px; /* limits width on screen */
            padding: 20px;
            box-sizing: border-box;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            position: relative;
        }

        /* Zigzag border effect at top and bottom simulating torn paper */
        .receipt-container::before,
        .receipt-container::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            height: 10px;
            background-size: 10px 10px;
        }
        .receipt-container::before {
            top: -10px;
            background-image: radial-gradient(circle at 50% 0, transparent 50%, #fff 51%);
        }
        .receipt-container::after {
            bottom: -10px;
            background-image: radial-gradient(circle at 50% 100%, transparent 50%, #fff 51%);
        }

        .text-center {
            text-align: center;
        }

        h2.shop-name {
            font-size: 24px;
            margin: 0 0 5px 0;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .date-time {
            font-size: 12px;
            margin-bottom: 15px;
            color: #333;
        }

        .divider {
            border-bottom: 2px solid #000;
            margin: 10px 0;
        }

        .items-list {
            list-style: none;
            padding: 0;
            margin: 15px 0;
            font-size: 13px;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .item-name {
            flex: 1;
            padding-right: 10px;
            display: flex;
        }
        .item-index {
            margin-right: 8px;
        }

        .item-price {
            white-space: nowrap;
        }
        
        .item-qty {
            font-size: 11px;
            color: #555;
            margin-left: 15px; /* Indent under name */
            margin-bottom: 5px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            text-transform: uppercase;
        }

        .barcode {
            margin-top: 20px;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        /* Print styles */
        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .receipt-container {
                box-shadow: none;
                width: 100%;
                max-width: none;
                padding: 5px;
            }
            .receipt-container::before,
            .receipt-container::after {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="receipt-container">
        <div class="text-center">
            <h2 class="shop-name">VANDEESA</h2>
            <div class="date-time">
                {{ \Carbon\Carbon::parse($invoice->tanggal)->locale('id')->translatedFormat('l, d/m/Y') }} <br>
                {{ \Carbon\Carbon::now('Asia/Jakarta')->format('H:i') }} WIB<br>
                Kasir: {{ $invoice->kasir ? $invoice->kasir->nama_pg : '-' }}<br>
                Pelanggan: {{ $invoice->nama_pelanggan }}
            </div>
        </div>

        <div class="divider"></div>

        <ul class="items-list">
            @php $subtotal = 0; @endphp
            @foreach($invoice->detail as $index => $detail)
                @php 
                    $itemTotal = $detail->harga_perpcs * $detail->quantity;
                    $subtotal += $itemTotal; 
                @endphp
                <li>
                    <div class="item-row">
                        <div class="item-name">
                            <span class="item-index">{{ $index + 1 }}.</span>
                            {{ $detail->item->nama_item }}
                        </div>
                        <div class="item-price">
                            Rp {{ number_format($itemTotal, 0, ',', '.') }}
                        </div>
                    </div>
                    @if($detail->quantity > 1)
                    <div class="item-qty">
                        {{ $detail->quantity }} x Rp {{ number_format($detail->harga_perpcs, 0, ',', '.') }}
                    </div>
                    @endif
                </li>
            @endforeach
        </ul>

        <div class="divider"></div>

        @if($invoice->diskon > 0)
        <div class="summary-row">
            <span>Subtotal:</span>
            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span>Diskon:</span>
            <span>- Rp {{ number_format($invoice->diskon, 0, ',', '.') }}</span>
        </div>
        @endif

        <div class="total-row">
            <span>TOTAL:</span>
            <span>Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}</span>
        </div>

        <div class="divider" style="margin-top: 15px;"></div>

        <div class="text-center barcode">
            #{{ $invoice->no_invoice }}#
        </div>
        
        <div class="text-center" style="margin-top: 15px; font-size: 11px;">
            Terima Kasih Atas Kunjungan Anda!
        </div>
    </div>

</body>
</html>

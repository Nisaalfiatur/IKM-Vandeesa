@extends('layouts.app')

@section('content')
<div>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1>📄 Detail Invoice</h1>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('invoice.print', $invoice->no_invoice) }}" class="btn btn-info" target="_blank">
                🖨️ Cetak
            </a>
            <a href="{{ route('invoice.index') }}" class="btn btn-secondary">
                ← Kembali
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
        <!-- Left Column -->
        <div class="card">
            <h3 style="margin-bottom: 15px; color: #374151;">ℹ️ Informasi Invoice</h3>
            <div class="info-row">
                <label>No Invoice</label>
                <span>{{ $invoice->no_invoice }}</span>
            </div>
            <div class="info-row">
                <label>Tanggal</label>
                <span>{{ \Carbon\Carbon::parse($invoice->tanggal)->format('d F Y') }}</span>
            </div>
            <div class="info-row">
                <label>Total Harga</label>
                <span style="color: #7C5CDB; font-weight: 600; font-size: 18px;">
                    Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- Right Column -->
        <div class="card">
            <h3 style="margin-bottom: 15px; color: #374151;">👥 Data Pihak Terkait</h3>
            <div class="info-row">
                <label>Pelanggan</label>
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
            <div class="info-row">
                <label>Kasir</label>
                <span>{{ $invoice->kasir->nama_pg ?? 'N/A' }}</span>
            </div>
        </div>
    </div>

    <!-- Detail Items Table -->
    <div class="card">
        <h3 style="margin-bottom: 15px; color: #374151;">📦 Detail Barang</h3>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Harga Per PCS</th>
                    <th>Harga Reseller</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoice->detail as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $detail->item->nama_item ?? 'N/A' }}</strong></td>
                    <td style="text-align: center;">{{ $detail->quantity }}</td>
                    <td style="text-align: right;">Rp {{ number_format($detail->harga_perpcs, 0, ',', '.') }}</td>
                    <td style="text-align: right;">Rp {{ number_format($detail->harga_reseller, 0, ',', '.') }}</td>
                    <td style="text-align: right; color: #7C5CDB; font-weight: 600;">
                        Rp {{ number_format($detail->harga_perpcs * $detail->quantity, 0, ',', '.') }}
                    </td>
                    <td style="text-align: center;">
                        <a href="{{ route('invoice.deleteDetail', [$invoice->no_invoice, $detail->id_item]) }}"
                           class="btn-icon-delete" title="Hapus Item"
                           onclick="return confirm('Yakin ingin menghapus item ini?')">
                            🗑️
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #9CA3AF; padding: 30px;">
                        Belum ada detail item
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="text-align: right; margin-top: 20px; padding-top: 20px; border-top: 2px solid #E9D5FF;">
            <p style="font-size: 18px; font-weight: 600; margin: 0;">
                Total: <span style="color: #7C5CDB;">Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}</span>
            </p>
        </div>
    </div>

    <!-- Form Tambah Detail Item -->
    <div class="card" style="margin-top: 20px;">
        <h3 style="margin-bottom: 15px; color: #374151;">➕ Tambah Item Penjualan</h3>

        <form method="POST" action="{{ route('invoice.storeDetail', $invoice->no_invoice) }}" class="form-add-detail">
            @csrf

            <div style="display: grid; grid-template-columns: 2fr 1fr 1.5fr 1.5fr auto; gap: 15px; align-items: flex-end;">
                <div>
                    <label for="id_item">Item</label>
                    <select id="id_item" name="id_item" class="item-select" required onchange="updatePrice(this)">
                        <option value="">-- Pilih Item --</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id_item }}" data-harga="{{ $item->harga }}">
                                {{ $item->nama_item }} (Rp {{ number_format($item->harga, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="quantity">Qty</label>
                    <input type="number" id="quantity" name="quantity" min="1" value="1" required>
                </div>

                <div>
                    <label for="harga_perpcs">Harga Per PCS</label>
                    <input type="number" id="harga_perpcs" name="harga_perpcs" min="0" required>
                </div>

                <div>
                    <label for="harga_reseller">Harga Reseller</label>
                    <input type="number" id="harga_reseller" name="harga_reseller" min="0" required>
                </div>

                <button type="submit" class="btn-submit-detail">💾 Simpan</button>
            </div>
        </form>
    </div>

    <!-- Action Buttons -->
    <div style="display: flex; gap: 10px; margin-top: 30px;">
        <a href="{{ route('invoice.edit', $invoice->no_invoice) }}" class="btn btn-warning">
            ✏️ Edit Invoice
        </a>
        <a href="{{ route('invoice.delete', $invoice->no_invoice) }}" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus invoice ini?')">
            🗑️ Hapus Invoice
        </a>
    </div>
</div>

<style>
    .btn {
        padding: 10px 15px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-info {
        background: #E0E7FF;
        color: #4F46E5;
    }

    .btn-info:hover {
        background: #C7D2FE;
    }

    .btn-secondary {
        background: #F3F4F6;
        color: #6B7280;
    }

    .btn-secondary:hover {
        background: #E5E7EB;
    }

    .btn-warning {
        background: #FEF3C7;
        color: #F59E0B;
    }

    .btn-warning:hover {
        background: #FCD34D;
    }

    .btn-danger {
        background: #FEE2E2;
        color: #EF4444;
    }

    .btn-danger:hover {
        background: #FECACA;
    }

    .card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #E5E7EB;
        font-size: 14px;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-row label {
        font-weight: 600;
        color: #6B7280;
    }

    .info-row span {
        color: #374151;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #E5E7EB;
    }

    th {
        background: #F9FAFB;
        font-weight: 600;
        color: #374151;
    }

    tr:hover {
        background: #F5F3FF;
    }

    .btn-icon-delete {
        padding: 8px 12px;
        background: #FEE2E2;
        color: #EF4444;
        border: none;
        border-radius: 6px;
        font-size: 18px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-icon-delete:hover {
        background: #FECACA;
        transform: scale(1.1);
    }

    .form-add-detail {
        background: #F9FAFB;
        padding: 15px;
        border-radius: 8px;
        border: 2px dashed #E9D5FF;
    }

    .form-add-detail label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
        font-size: 13px;
    }

    .form-add-detail input,
    .form-add-detail select {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #D1D5DB;
        border-radius: 6px;
        font-size: 13px;
        font-family: inherit;
    }

    .form-add-detail input:focus,
    .form-add-detail select:focus {
        outline: none;
        border-color: #7C5CDB;
        box-shadow: 0 0 0 3px rgba(123, 92, 219, 0.1);
    }

    .btn-submit-detail {
        padding: 10px 15px;
        background: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%);
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 13px;
    }

    .btn-submit-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(123, 92, 219, 0.3);
    }
</style>

<script>
    function updatePrice(select) {
        const harga = select.options[select.selectedIndex].getAttribute('data-harga');
        const hargaPerpcsInput = document.getElementById('harga_perpcs');
        const hargaResellerInput = document.getElementById('harga_reseller');

        if (harga) {
            hargaPerpcsInput.value = harga;
            hargaResellerInput.value = harga;
        }
    }
</script>
@endsection

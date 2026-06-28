@extends('layouts.app')

@section('content')
<div>
    <h1>✏️ Edit Invoice</h1>

    @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('invoice.update', $invoice->no_invoice) }}" class="form-container">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="no_invoice">No Invoice</label>
            <input type="text" id="no_invoice" name="no_invoice" value="{{ $invoice->no_invoice }}" readonly>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="id_pelanggan">Pelanggan</label>
                <select id="id_pelanggan" name="id_pelanggan" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->id_pelanggan }}" {{ $invoice->id_pelanggan === $pelanggan->id_pelanggan ? 'selected' : '' }}>
                            {{ $pelanggan->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_member">Member</label>
                <select id="id_member" name="id_member" required>
                    <option value="">-- Pilih Member --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id_member }}" {{ $invoice->id_member === $member->id_member ? 'selected' : '' }}>
                            {{ $member->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="id_pegawai">Pegawai</label>
                <select id="id_pegawai" name="id_pegawai" required>
                    <option value="">-- Pilih Pegawai --</option>
                    @foreach($pegawais as $pegawai)
                        <option value="{{ $pegawai->id_pegawai }}" {{ $invoice->id_pegawai === $pegawai->id_pegawai ? 'selected' : '' }}>
                            {{ $pegawai->nama_pg }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_pg_kasir">Kasir</label>
                <select id="id_pg_kasir" name="id_pg_kasir" required>
                    <option value="">-- Pilih Kasir --</option>
                    @foreach($pegawais as $pegawai)
                        <option value="{{ $pegawai->id_pegawai }}" {{ $invoice->id_pg_kasir === $pegawai->id_pegawai ? 'selected' : '' }}>
                            {{ $pegawai->nama_pg }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal" value="{{ $invoice->tanggal }}" required>
        </div>

        <!-- Detail Items -->
        <div class="form-group">
            <label>Detail Invoice - Item Penjualan</label>

            <div class="items-container" id="itemsContainer">
                @foreach($invoice->detail as $index => $detail)
                <div class="item-row">
                    <div class="item-field">
                        <label>Item</label>
                        <select name="items[{{ $index }}][id_item]" class="item-select" required onchange="updatePrice(this)">
                            <option value="">-- Pilih Item --</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id_item }}" data-harga="{{ $item->harga }}" {{ $detail->id_item === $item->id_item ? 'selected' : '' }}>
                                    {{ $item->nama_item }} (Rp {{ number_format($item->harga, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="item-field">
                        <label>Qty</label>
                        <input type="number" name="items[{{ $index }}][quantity]" class="item-quantity" min="1" value="{{ $detail->quantity }}" required onchange="calculateTotal()">
                    </div>

                    <div class="item-field">
                        <label>Harga Per PCS</label>
                        <input type="number" name="items[{{ $index }}][harga_perpcs]" class="item-harga-perpcs" min="0" value="{{ $detail->harga_perpcs }}" required>
                    </div>

                    <div class="item-field">
                        <label>Harga Reseller</label>
                        <input type="number" name="items[{{ $index }}][harga_reseller]" class="item-harga-reseller" min="0" value="{{ $detail->harga_reseller }}" required>
                    </div>

                    <div class="item-field">
                        <label>&nbsp;</label>
                        <button type="button" class="btn-remove" onclick="removeItem(this)">❌ Hapus</button>
                    </div>
                </div>
                @endforeach
            </div>

            <button type="button" class="btn-add" onclick="addItem()">➕ Tambah Item</button>
        </div>

        <div class="form-group" style="text-align: right; margin-top: 30px;">
            <p style="font-size: 18px; font-weight: 600;">
                Total Harga: <span style="color: #7C5CDB;" id="totalHargaDisplay">Rp 0</span>
            </p>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn-submit">💾 Update Invoice</button>
            <a href="{{ route('invoice.index') }}" class="btn-cancel">❌ Batal</a>
        </div>
    </form>
</div>

<style>
    .form-container {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px 12px;
        border: 2px solid #E9D5FF;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #7C5CDB;
        box-shadow: 0 0 0 3px rgba(123, 92, 219, 0.1);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .items-container {
        background: #F5F3FF;
        padding: 15px;
        border-radius: 8px;
        border: 2px dashed #E9D5FF;
        margin-bottom: 15px;
    }

    .item-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1.5fr 1.5fr auto;
        gap: 10px;
        margin-bottom: 15px;
        padding: 15px;
        background: white;
        border-radius: 8px;
        border: 1px solid #E5E7EB;
    }

    .item-row:last-child {
        margin-bottom: 0;
    }

    .item-field label {
        font-size: 12px;
        margin-bottom: 6px;
    }

    .item-field input,
    .item-field select {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #D1D5DB;
        border-radius: 6px;
        font-size: 13px;
    }

    .btn-remove {
        padding: 8px 10px;
        background: #FEE2E2;
        color: #EF4444;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-remove:hover {
        background: #FECACA;
    }

    .btn-add {
        display: inline-block;
        padding: 10px 15px;
        background: #E0E7FF;
        color: #4F46E5;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .btn-add:hover {
        background: #C7D2FE;
    }

    .btn-submit {
        padding: 12px 20px;
        background: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(123, 92, 219, 0.3);
    }

    .btn-cancel {
        padding: 12px 20px;
        background: #F3F4F6;
        color: #6B7280;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #E5E7EB;
    }

    .alert-error {
        background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
        color: #991B1B;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 4px solid #EF4444;
    }

    .alert-error p {
        margin: 0;
    }
</style>

<script>
    let itemCount = {{ count($invoice->detail) }};

    function updatePrice(select) {
        const harga = select.options[select.selectedIndex].getAttribute('data-harga');
        const row = select.closest('.item-row');
        const hargaPerpcsInput = row.querySelector('.item-harga-perpcs');
        const hargaResellerInput = row.querySelector('.item-harga-reseller');

        if (harga) {
            hargaPerpcsInput.value = harga;
            hargaResellerInput.value = harga;
        }
        calculateTotal();
    }

    function addItem() {
        const container = document.getElementById('itemsContainer');
        const newRow = document.createElement('div');
        newRow.className = 'item-row';
        newRow.innerHTML = `
            <div class="item-field">
                <label>Item</label>
                <select name="items[${itemCount}][id_item]" class="item-select" required onchange="updatePrice(this)">
                    <option value="">-- Pilih Item --</option>
                    @foreach($items as $item)
                        <option value="{{ $item->id_item }}" data-harga="{{ $item->harga }}">
                            {{ $item->nama_item }} (Rp {{ number_format($item->harga, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="item-field">
                <label>Qty</label>
                <input type="number" name="items[${itemCount}][quantity]" class="item-quantity" min="1" value="1" required onchange="calculateTotal()">
            </div>
            <div class="item-field">
                <label>Harga Per PCS</label>
                <input type="number" name="items[${itemCount}][harga_perpcs]" class="item-harga-perpcs" min="0" required>
            </div>
            <div class="item-field">
                <label>Harga Reseller</label>
                <input type="number" name="items[${itemCount}][harga_reseller]" class="item-harga-reseller" min="0" required>
            </div>
            <div class="item-field">
                <label>&nbsp;</label>
                <button type="button" class="btn-remove" onclick="removeItem(this)">❌ Hapus</button>
            </div>
        `;
        container.appendChild(newRow);
        itemCount++;
        calculateTotal();
    }

    function removeItem(button) {
        button.closest('.item-row').remove();
        calculateTotal();
    }

    function calculateTotal() {
        const rows = document.querySelectorAll('.item-row');
        let total = 0;

        rows.forEach(row => {
            const hargaPerpcs = parseFloat(row.querySelector('.item-harga-perpcs').value) || 0;
            const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
            total += hargaPerpcs * quantity;
        });

        document.getElementById('totalHargaDisplay').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    // Calculate total on page load
    document.addEventListener('DOMContentLoaded', calculateTotal);
</script>
@endsection

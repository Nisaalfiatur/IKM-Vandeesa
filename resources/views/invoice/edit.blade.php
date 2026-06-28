@extends('layouts.app')

@section('content')
<div class="edit-wrapper">
    <div class="header-container">
        <h1 class="page-title"><span class="floating-emoji">✏️</span> Edit Invoice ✨</h1>
        <p class="subtitle">Update your invoice details below 🚀</p>
    </div>

    @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $error)
                <p>⚠️ {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('invoice.update', $invoice->no_invoice) }}" class="form-container">
        @csrf
        @method('PUT')

        <div class="form-section-title">📝 Basic Info</div>

        <div class="form-group">
            <label for="no_invoice">No Invoice 🏷️</label>
            <input type="text" id="no_invoice" name="no_invoice" value="{{ $invoice->no_invoice }}" readonly class="readonly-input">
        </div>

        <div class="form-row">
            <div class="form-group" style="grid-column: span 2;">
                <label for="id_pelanggan">Pelanggan / Member / Reseller 👤</label>
                <select id="id_pelanggan" name="id_pelanggan" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach($allPelanggans as $p)
                        <option value="{{ $p['value'] }}" {{ $selectedPelanggan === $p['value'] ? 'selected' : '' }}>
                            {{ $p['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal 📅</label>
            <input type="date" id="tanggal" name="tanggal" value="{{ $invoice->tanggal }}" required>
        </div>

        <div class="form-group">
            <label for="diskon">Diskon (Rp) 💸</label>
            <input type="number" id="diskon" name="diskon" value="{{ old('diskon', $invoice->diskon ?? 0) }}" min="0" placeholder="0">
        </div>

        <div class="form-section-title" style="margin-top: 30px;">🛒 Detail Items</div>
        <!-- Detail Items -->
        <div class="form-group">
            <div class="items-container" id="itemsContainer">
                @if(count($invoice->detail) == 0)
                    <div id="emptyState" class="empty-state">
                        <div class="empty-icon">👻</div>
                        <p>No items yet! Click below to add one.</p>
                    </div>
                @endif
                @foreach($invoice->detail as $index => $detail)
                <div class="item-row">
                    <div class="item-field">
                        <label>Item 📦</label>
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
                        <label>Qty 🔢</label>
                        <input type="number" name="items[{{ $index }}][quantity]" class="item-quantity" min="1" value="{{ $detail->quantity }}" required onchange="calculateTotal()">
                    </div>

                    <div class="item-field">
                        <label>Harga PCS 💸</label>
                        <input type="number" name="items[{{ $index }}][harga_perpcs]" class="item-harga-perpcs" min="0" value="{{ $detail->harga_perpcs }}" required readonly style="background: #F9FAFB; cursor: not-allowed;" onchange="calculateTotal()">
                    </div>

                    <div class="item-field btn-remove-wrapper">
                        <button type="button" class="btn-remove" onclick="removeItem(this)" title="Hapus">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <button type="button" class="btn-add" onclick="addItem()">✨ Tambah Item ➕</button>
        </div>

        <div class="total-harga-container">
            <p>Total Harga: <span id="totalHargaDisplay">Rp 0</span> 💰</p>
        </div>

        <div class="action-buttons">
            <button type="submit" class="btn-submit">💾 Update Invoice 🚀</button>
            <a href="{{ route('invoice.index') }}" class="btn-cancel">❌ Batal</a>
        </div>
    </form>
</div>

<style>
    .edit-wrapper {
        font-family: 'Inter', 'Segoe UI', sans-serif;
        color: #374151;
        max-width: 900px;
        margin: 0 auto;
    }

    .header-container {
        margin-bottom: 25px;
        text-align: center;
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        background: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .subtitle {
        color: #6B7280;
        font-size: 15px;
    }

    .floating-emoji {
        display: inline-block;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
        100% { transform: translateY(0px); }
    }

    .form-container {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(123, 92, 219, 0.08);
        border: 1px solid rgba(233, 213, 255, 0.5);
    }

    .form-section-title {
        font-size: 18px;
        font-weight: 700;
        color: #6B46C1;
        margin-bottom: 15px;
        border-bottom: 2px solid #F5F3FF;
        padding-bottom: 8px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #4B5563;
        margin-bottom: 8px;
        font-size: 14px;
        transition: color 0.3s;
    }

    .form-group:focus-within label {
        color: #7C5CDB;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #E9D5FF;
        border-radius: 10px;
        font-size: 14px;
        font-family: inherit;
        background: #FDFBFF;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-sizing: border-box;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #7C5CDB;
        box-shadow: 0 0 0 4px rgba(123, 92, 219, 0.15);
        background: #FFFFFF;
        transform: translateY(-1px);
    }

    .readonly-input {
        background: #F3F4F6 !important;
        cursor: not-allowed;
        color: #6B7280;
        border-color: #D1D5DB !important;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .items-container {
        background: #F5F3FF;
        padding: 20px;
        border-radius: 12px;
        border: 2px dashed #D8B4FE;
        margin-bottom: 15px;
        display: flex;
        flex-direction: column;
        gap: 15px;
        min-height: 100px;
        justify-content: center;
    }

    .empty-state {
        text-align: center;
        padding: 20px;
        color: #8B5CF6;
        font-weight: 500;
    }

    .empty-icon {
        font-size: 40px;
        margin-bottom: 10px;
        animation: float 3s ease-in-out infinite;
    }

    .item-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1.5fr auto;
        gap: 15px;
        padding: 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(123, 92, 219, 0.05);
        border: 1px solid #E9D5FF;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        align-items: end;
    }

    .item-row:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(123, 92, 219, 0.1);
        border-color: #C084FC;
    }

    .item-field label {
        font-size: 12px;
        font-weight: 600;
        color: #6B7280;
        margin-bottom: 6px;
        display: block;
    }

    .item-field input,
    .item-field select {
        width: 100%;
        padding: 10px 12px;
        border: 2px solid #E5E7EB;
        border-radius: 8px;
        font-size: 13px;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .item-field input:focus,
    .item-field select:focus {
        outline: none;
        border-color: #7C5CDB;
        box-shadow: 0 0 0 3px rgba(123, 92, 219, 0.1);
    }

    .btn-remove-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        padding-bottom: 2px;
    }

    .btn-remove {
        padding: 10px;
        background: #FEE2E2;
        color: #EF4444;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 42px;
        width: 42px;
    }

    .btn-remove:hover {
        background: #FECACA;
        transform: scale(1.05) rotate(5deg);
    }

    .btn-add {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 20px;
        background: #EDE9FE;
        color: #6B46C1;
        border: 2px dashed #C084FC;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 700;
        transition: all 0.3s ease;
        margin-top: 5px;
        width: 100%;
    }

    .btn-add:hover {
        background: #DDD6FE;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(123, 92, 219, 0.15);
        border-style: solid;
    }

    .total-harga-container {
        text-align: right;
        margin-top: 30px;
        padding: 20px;
        background: linear-gradient(135deg, #F5F3FF 0%, #EDE9FE 100%);
        border-radius: 12px;
        border: 1px solid #D8B4FE;
    }

    .total-harga-container p {
        margin: 0;
        font-size: 20px;
        font-weight: 800;
        color: #374151;
    }

    .total-harga-container span {
        color: #7C5CDB;
        font-size: 24px;
        text-shadow: 0 2px 4px rgba(123, 92, 219, 0.2);
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        justify-content: flex-end;
    }

    .btn-submit {
        padding: 14px 28px;
        background: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%);
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 700;
        font-size: 15px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(123, 92, 219, 0.2);
    }

    .btn-submit:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 25px rgba(123, 92, 219, 0.3);
    }

    .btn-cancel {
        padding: 14px 24px;
        background: #F3F4F6;
        color: #4B5563;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 700;
        font-size: 15px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #E5E7EB;
        color: #1F2937;
        transform: translateY(-2px);
    }

    .alert-error {
        background: linear-gradient(135deg, #FEF2F2 0%, #FEE2E2 100%);
        color: #991B1B;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        border-left: 5px solid #EF4444;
        box-shadow: 0 4px 6px rgba(239, 68, 68, 0.1);
    }

    .alert-error p {
        margin: 5px 0;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .form-row, .item-row {
            grid-template-columns: 1fr;
        }
        .item-row {
            gap: 10px;
        }
        .btn-remove-wrapper {
            justify-content: flex-start;
        }
    }
</style>

<script>
    let itemCount = {{ count($invoice->detail) }};

    function updatePrice(select) {
        const harga = select.options[select.selectedIndex].getAttribute('data-harga');
        const row = select.closest('.item-row');
        const hargaPerpcsInput = row.querySelector('.item-harga-perpcs');

        if (harga) {
            hargaPerpcsInput.value = harga;
        }
        calculateTotal();
    }

    function addItem() {
        const container = document.getElementById('itemsContainer');
        const emptyState = document.getElementById('emptyState');
        if (emptyState) {
            emptyState.remove();
        }

        const newRow = document.createElement('div');
        newRow.className = 'item-row';
        newRow.innerHTML = `
            <div class="item-field">
                <label>Item 📦</label>
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
                <label>Qty 🔢</label>
                <input type="number" name="items[${itemCount}][quantity]" class="item-quantity" min="1" value="1" required onchange="calculateTotal()">
            </div>
            <div class="item-field">
                <label>Harga PCS 💸</label>
                <input type="number" name="items[${itemCount}][harga_perpcs]" class="item-harga-perpcs" min="0" required readonly style="background: #F9FAFB; cursor: not-allowed;" onchange="calculateTotal()">
            </div>
            <div class="item-field btn-remove-wrapper">
                <button type="button" class="btn-remove" onclick="removeItem(this)" title="Hapus">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                </button>
            </div>
        `;
        container.appendChild(newRow);
        itemCount++;
        calculateTotal();
    }

    function removeItem(button) {
        button.closest('.item-row').remove();
        calculateTotal();
        
        const container = document.getElementById('itemsContainer');
        if (container.querySelectorAll('.item-row').length === 0) {
            container.innerHTML = `
                <div id="emptyState" class="empty-state">
                    <div class="empty-icon">👻</div>
                    <p>No items yet! Click below to add one.</p>
                </div>
            `;
        }
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

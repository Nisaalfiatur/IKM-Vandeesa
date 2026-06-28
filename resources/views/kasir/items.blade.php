@extends('layouts.app')

@section('content')
<div class="pos-header">
    <h1>Mesin Kasir (POS)</h1>
    <p>Pilih item untuk ditambahkan ke keranjang penjualan.</p>
</div>

@if($errors->any())
    <div class="alert-error bounce-in" style="background: #FEF2F2; border: 1px solid #FCA5A5; border-radius: 12px; padding: 16px; margin-bottom: 24px; color: #991B1B;">
        <div style="font-weight: bold; margin-bottom: 8px;">Terjadi Kesalahan:</div>
        <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="pos-layout">
    <!-- Area Kiri: Katalog Item -->
    <div class="pos-catalog">
        <div class="kasir-items-grid">
            @forelse($items as $item)
            <div class="kasir-card" onclick="addToCart({{ $item->toJson() }})">
                <div class="kasir-card-image">
                    @if($item->gambar)
                        <img src="{{ asset('images/items/' . $item->gambar) }}" alt="{{ $item->nama_item }}">
                    @else
                        <div class="kasir-card-placeholder">📦</div>
                    @endif
                </div>

                <div class="kasir-card-body">
                    <h3 class="kasir-card-title">{{ $item->nama_item }}</h3>
                    <div class="kasir-card-id">ID: {{ $item->id_item }}</div>
                    <div class="kasir-card-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                    
                    <div class="kasir-card-stock">
                        <span class="kasir-stock-badge @if($item->stok_item > 5) in-stock @elseif($item->stok_item > 0) low-stock @else out-stock @endif">
                            Stok: {{ $item->stok_item }}
                        </span>
                    </div>
                    
                    <button type="button" class="kasir-card-button" @if($item->stok_item <= 0) disabled style="background:#ccc; cursor:not-allowed;" @endif>
                        + Tambah
                    </button>
                </div>
            </div>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #9CA3AF;">
                <div style="font-size: 48px; margin-bottom: 15px;">📭</div>
                <h3>Belum Ada Item</h3>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Area Kanan: Keranjang & Checkout -->
    <div class="pos-sidebar">
        <div class="pos-cart-card">
            <h2 class="cart-title">🛒 Keranjang</h2>
            
            <form method="POST" action="{{ route('kasir.checkout') }}" id="checkoutForm">
                @csrf
                <input type="hidden" name="cart" id="cartData" value="[]">

                <!-- Meta Informasi Checkout -->
                <div class="cart-meta">
                    <div class="form-group">
                        <label>No Invoice</label>
                        <input type="text" name="no_invoice" value="{{ $nextInvoiceNumber }}" readonly class="readonly-input">
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label>Pelanggan</label>
                        <select name="id_pelanggan" id="id_pelanggan" required class="form-input" onchange="calculateTotal()">
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($pelanggans as $pelanggan)
                                <option value="{{ $pelanggan->id_pelanggan }}">{{ $pelanggan->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" style="display:none;">
                        <!-- Kasir ter-assign otomatis ke user yang login (jika memungkinkan) atau dipilih -->
                        <label>Kasir</label>
                        <select name="id_pg_kasir" required class="form-input">
                            @foreach($pegawais as $pegawai)
                                <!-- Pilih pegawai pertama atau sesuaikan dengan login -->
                                <option value="{{ $pegawai->id_pegawai }}" selected>{{ $pegawai->nama_pg }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Pegawai (Sales)</label>
                        <select name="id_pegawai" required class="form-input">
                            <option value="">-- Pilih Sales --</option>
                            @foreach($pegawais as $pegawai)
                                <option value="{{ $pegawai->id_pegawai }}">{{ $pegawai->nama_pg }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- List Item Keranjang -->
                <div class="cart-items" id="cartItemsContainer">
                    <div class="empty-cart-msg" id="emptyCartMsg">Keranjang masih kosong</div>
                    <!-- Cart items will be rendered here by JS -->
                </div>

                <!-- Ringkasan Total -->
                <div class="cart-summary">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="subtotalLabel">Rp 0</span>
                    </div>

                    <div class="summary-row" style="align-items: center;">
                        <span>Diskon (Rp)</span>
                        <span>
                            <input type="number" id="diskonInput" name="diskon" value="0" min="0" class="form-input" style="width: 120px; text-align: right; padding: 4px 8px;" oninput="calculateTotal()">
                        </span>
                    </div>

                    <div class="summary-row total">
                        <span>Total Bayar</span>
                        <span id="totalLabel">Rp 0</span>
                    </div>
                </div>

                <button type="button" class="btn-checkout" onclick="submitCheckout()">
                    Proses Checkout ➔
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    let cart = [];

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(number);
    }

    function addToCart(item) {
        if (item.stok_item <= 0) {
            alert('Stok item habis!');
            return;
        }

        const existingItem = cart.find(i => i.id === item.id_item);
        if (existingItem) {
            if (existingItem.quantity < item.stok_item) {
                existingItem.quantity += 1;
            } else {
                alert('Maksimal stok tercapai!');
            }
        } else {
            cart.push({
                id: item.id_item,
                name: item.nama_item,
                harga: item.harga,
                quantity: 1,
                maxStok: item.stok_item
            });
        }
        renderCart();
    }

    function updateQuantity(id, delta) {
        const itemIndex = cart.findIndex(i => i.id === id);
        if (itemIndex > -1) {
            const item = cart[itemIndex];
            const newQty = item.quantity + delta;
            
            if (newQty > 0 && newQty <= item.maxStok) {
                item.quantity = newQty;
            } else if (newQty <= 0) {
                cart.splice(itemIndex, 1);
            }
            renderCart();
        }
    }

    function calculateTotal() {
        let subtotal = 0;
        cart.forEach(item => {
            subtotal += item.harga * item.quantity;
        });

        let diskon = parseFloat(document.getElementById('diskonInput').value) || 0;
        let total = subtotal - diskon;
        if (total < 0) total = 0;

        document.getElementById('subtotalLabel').innerText = formatRupiah(subtotal);
        document.getElementById('totalLabel').innerText = formatRupiah(total);
        
        // Update hidden input form
        document.getElementById('cartData').value = JSON.stringify(cart);
    }

    function renderCart() {
        const container = document.getElementById('cartItemsContainer');
        const emptyMsg = document.getElementById('emptyCartMsg');
        
        // Bersihkan isi cart kecuali empty msg (nanti ditangani)
        container.innerHTML = '';

        if (cart.length === 0) {
            container.appendChild(emptyMsg);
            emptyMsg.style.display = 'block';
        } else {
            emptyMsg.style.display = 'none';
            container.appendChild(emptyMsg); // keep it in DOM

            cart.forEach(item => {
                const div = document.createElement('div');
                div.className = 'cart-item';
                div.innerHTML = `
                    <div class="cart-item-info">
                        <div class="cart-item-name">${item.name}</div>
                        <div class="cart-item-price">${formatRupiah(item.harga)}</div>
                    </div>
                    <div class="cart-item-actions">
                        <button type="button" class="qty-btn" onclick="updateQuantity('${item.id}', -1)">-</button>
                        <span class="qty-val">${item.quantity}</span>
                        <button type="button" class="qty-btn" onclick="updateQuantity('${item.id}', 1)">+</button>
                    </div>
                `;
                container.appendChild(div);
            });
        }
        calculateTotal();
    }

    function submitCheckout() {
        if (cart.length === 0) {
            alert('Keranjang belanja kosong! Silakan tambah item terlebih dahulu.');
            return;
        }

        const form = document.getElementById('checkoutForm');
        if (!form.reportValidity()) {
            return; // Biarkan HTML5 validation berjalan
        }

        form.submit();
    }

    // Inisialisasi
    document.addEventListener('DOMContentLoaded', () => {
        renderCart();
    });
</script>

<style>
    .pos-header { margin-bottom: 24px; }
    .pos-header h1 { font-size: 24px; font-weight: 800; color: #1F2937; margin-bottom: 6px; }
    .pos-header p { color: #6B7280; font-size: 15px; margin: 0; }

    .pos-layout {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 24px;
        align-items: start;
    }

    /* Kiri - Katalog */
    .kasir-items-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }

    .kasir-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(123, 92, 219, 0.05);
        transition: all 0.2s ease;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        border: 1px solid transparent;
    }
    .kasir-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(123, 92, 219, 0.15);
        border-color: rgba(123, 92, 219, 0.3);
    }
    .kasir-card-image {
        width: 100%; height: 160px;
        background: #F3F4F6;
        display: flex; align-items: center; justify-content: center;
    }
    .kasir-card-image img { width: 100%; height: 100%; object-fit: cover; }
    .kasir-card-placeholder { font-size: 48px; }
    .kasir-card-body { padding: 14px; flex: 1; display: flex; flex-direction: column; }
    .kasir-card-title { font-size: 14px; font-weight: 600; color: #1F2937; margin: 0 0 4px 0; line-height: 1.3; }
    .kasir-card-id { font-size: 11px; color: #9CA3AF; margin-bottom: 8px; }
    .kasir-card-price { font-size: 16px; font-weight: 700; color: #7C5CDB; margin-bottom: 8px; }
    .kasir-stock-badge {
        display: inline-block; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; margin-bottom: 12px;
    }
    .in-stock { background: #DCFCE7; color: #166534; }
    .low-stock { background: #FEF3C7; color: #B45309; }
    .out-stock { background: #FEE2E2; color: #991B1B; }
    
    .kasir-card-button {
        display: block; width: 100%; padding: 10px;
        background: rgba(123, 92, 219, 0.1); color: #7C5CDB;
        border: none; border-radius: 8px; font-size: 13px; font-weight: 700;
        cursor: pointer; transition: 0.2s; margin-top: auto;
    }
    .kasir-card:hover .kasir-card-button {
        background: #7C5CDB; color: white;
    }

    /* Kanan - Keranjang */
    .pos-cart-card {
        background: white; border-radius: 20px; padding: 24px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.06);
        position: sticky; top: 24px;
        display: flex; flex-direction: column; max-height: calc(100vh - 40px);
    }
    .cart-title { font-size: 20px; font-weight: 800; margin: 0 0 20px 0; border-bottom: 2px solid #F3F4F6; padding-bottom: 12px;}

    .cart-meta { margin-bottom: 16px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .cart-meta .form-group { margin-bottom: 8px; }
    .cart-meta .form-group.full { grid-column: span 2; }
    .cart-meta label { display: block; font-size: 12px; font-weight: 600; color: #6B7280; margin-bottom: 4px;}
    .form-input, .readonly-input {
        width: 100%; padding: 8px 12px; border: 1px solid #E5E7EB; border-radius: 8px; font-size: 13px; font-family: inherit;
    }
    .form-input:focus { outline: none; border-color: #7C5CDB; box-shadow: 0 0 0 2px rgba(123,92,219,0.2); }
    .readonly-input { background: #F3F4F6; color: #6B7280; pointer-events: none; }

    .cart-items {
        flex: 1; overflow-y: auto; margin-bottom: 20px; padding-right: 8px;
        border-top: 1px dashed #E5E7EB; border-bottom: 1px dashed #E5E7EB; padding: 16px 0;
    }
    .empty-cart-msg { text-align: center; color: #9CA3AF; font-size: 14px; padding: 20px 0; }
    
    .cart-item { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
    .cart-item:last-child { margin-bottom: 0; }
    .cart-item-name { font-size: 14px; font-weight: 600; color: #1F2937; margin-bottom: 2px; }
    .cart-item-price { font-size: 13px; color: #7C5CDB; font-weight: 600; }
    .cart-item-actions { display: flex; align-items: center; gap: 8px; background: #F3F4F6; border-radius: 8px; padding: 4px; }
    .qty-btn { background: white; border: none; width: 24px; height: 24px; border-radius: 6px; cursor: pointer; font-weight: bold; color: #4B5563; display:flex; align-items:center; justify-content:center; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .qty-btn:hover { background: #E5E7EB; }
    .qty-val { font-size: 13px; font-weight: 700; width: 20px; text-align: center; }

    .cart-summary { margin-bottom: 20px; }
    .summary-row { display: flex; justify-content: space-between; font-size: 14px; color: #4B5563; margin-bottom: 8px; }
    .summary-row.total { font-size: 18px; font-weight: 800; color: #1F2937; margin-top: 12px; padding-top: 12px; border-top: 2px solid #F3F4F6; }

    .btn-checkout {
        width: 100%; padding: 16px; background: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%);
        color: white; border: none; border-radius: 12px; font-size: 16px; font-weight: 700;
        cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(123, 92, 219, 0.3);
    }
    .btn-checkout:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(123, 92, 219, 0.4); }

    @media (max-width: 1024px) {
        .pos-layout { grid-template-columns: 1fr; }
        .pos-cart-card { position: static; max-height: none; }
    }
</style>
@endsection

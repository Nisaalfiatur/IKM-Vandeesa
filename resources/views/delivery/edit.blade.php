@extends('layouts.app')

@section('content')
<div>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1>✏️ Edit Delivery Order: {{ $delivery->no_do }}</h1>
        <a href="{{ route('delivery.index') }}" class="btn btn-secondary">
            ← Kembali
        </a>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div style="background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%); color: #991B1B; padding: 16px 20px; border-radius: 10px; margin-bottom: 24px; border-left: 4px solid #EF4444;">
            <div style="font-weight: 700; margin-bottom: 8px; font-size: 14px;">⚠️ Terdapat kesalahan pada form:</div>
            <ul style="margin: 0; padding-left: 20px; font-size: 13px; line-height: 1.8;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <form action="{{ route('delivery.update', $delivery->no_do) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                {{-- No DO (readonly, not submitted) --}}
                <div>
                    <label for="no_do_display"><strong>No Delivery Order</strong></label>
                    <input type="text" id="no_do_display" value="{{ $delivery->no_do }}" readonly disabled
                           style="background: #F9FAFB; color: #6B7280; cursor: not-allowed;">
                </div>

                {{-- Tanggal --}}
                <div>
                    <label for="tanggal"><strong>Tanggal</strong></label>
                    <input type="date" name="tanggal" id="tanggal"
                           value="{{ old('tanggal', $delivery->tanggal) }}" required
                           style="{{ $errors->has('tanggal') ? 'border-color: #EF4444;' : '' }}">
                    @if($errors->has('tanggal'))
                        <span style="color: #EF4444; font-size: 12px; margin-top: -10px; display: block;">{{ $errors->first('tanggal') }}</span>
                    @endif
                </div>

                {{-- No Invoice --}}
                <div>
                    <label for="no_invoice"><strong>No Invoice</strong></label>
                    <select name="no_invoice" id="no_invoice" required
                            style="{{ $errors->has('no_invoice') ? 'border-color: #EF4444;' : '' }}">
                        <option value="">-- Pilih Invoice --</option>
                        @foreach($invoices as $invoice)
                            <option value="{{ $invoice->no_invoice }}" {{ old('no_invoice', $delivery->no_invoice) == $invoice->no_invoice ? 'selected' : '' }}>
                                {{ $invoice->no_invoice }}
                            </option>
                        @endforeach
                    </select>
                    @if($errors->has('no_invoice'))
                        <span style="color: #EF4444; font-size: 12px; margin-top: -10px; display: block;">{{ $errors->first('no_invoice') }}</span>
                    @endif
                </div>





                {{-- Status --}}
                <div>
                    <label for="status"><strong>Status</strong></label>
                    <select name="status" id="status" required
                            style="{{ $errors->has('status') ? 'border-color: #EF4444;' : '' }}">
                        <option value="">-- Pilih Status --</option>
                        <option value="Menunggu" {{ old('status', $delivery->status) == 'Menunggu' ? 'selected' : '' }}>🟡 Menunggu</option>
                        <option value="Diproses" {{ old('status', $delivery->status) == 'Diproses' ? 'selected' : '' }}>🔵 Diproses</option>
                        <option value="Dikirim" {{ old('status', $delivery->status) == 'Dikirim' ? 'selected' : '' }}>🟣 Dikirim</option>
                        <option value="Selesai" {{ old('status', $delivery->status) == 'Selesai' ? 'selected' : '' }}>🟢 Selesai</option>
                        <option value="Dibatalkan" {{ old('status', $delivery->status) == 'Dibatalkan' ? 'selected' : '' }}>🔴 Dibatalkan</option>
                    </select>
                    @if($errors->has('status'))
                        <span style="color: #EF4444; font-size: 12px; margin-top: -10px; display: block;">{{ $errors->first('status') }}</span>
                    @endif
                </div>
            </div>

            {{-- Selected Invoice Preview --}}
            <div id="invoicePreview" style="margin-top: 25px; display: none;">
                <h3 style="color: #6B46C1; margin-bottom: 10px;">📋 Detail Invoice Dipilih</h3>
                <div class="invoice-preview-box" id="invoicePreviewContent"></div>
            </div>

            <div style="margin-top: 25px; display: flex; gap: 12px; align-items: center;">
                <button type="submit" class="btn btn-primary">
                    💾 Update Delivery Order
                </button>
                <a href="{{ route('delivery.index') }}" class="btn btn-secondary">Batal</a>
                <a href="{{ route('delivery.delete', $delivery->no_do) }}" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus delivery order ini? 🥺')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px; vertical-align: middle;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                    Hapus DO
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    label {
        display: block;
        margin-bottom: 5px;
        color: #374151;
        font-size: 14px;
    }

    input, select {
        width: 100%;
        padding: 10px 12px;
        border: 2px solid #E9D5FF;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s ease;
        background: white;
    }

    input:focus, select:focus {
        outline: none;
        border-color: #7C5CDB;
        box-shadow: 0 0 0 3px rgba(123, 92, 219, 0.1);
    }

    input[readonly] {
        background: #F9FAFB;
        color: #6B7280;
        cursor: not-allowed;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        display: inline-block;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(123, 92, 219, 0.3);
    }

    .btn-secondary {
        background: linear-gradient(135deg, #9CA3AF 0%, #6B7280 100%);
        color: white;
    }

    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(107, 114, 128, 0.3);
    }

    .btn-danger {
        background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        color: white;
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
        color: white;
    }

    .card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .invoice-preview-box {
        background: #F5F3FF;
        border: 2px solid #E9D5FF;
        border-radius: 8px;
        padding: 15px;
        font-size: 13px;
    }
</style>

<script>
    // Invoice data untuk preview
    const invoices = @json($invoicesFormatted);

    function showInvoicePreview(selectedNo) {
        const preview = document.getElementById('invoicePreview');
        const previewContent = document.getElementById('invoicePreviewContent');

        if (!selectedNo) {
            preview.style.display = 'none';
            return;
        }

        const invoice = invoices.find(i => i.no_invoice === selectedNo);
        if (!invoice) {
            preview.style.display = 'none';
            return;
        }

        let itemsHtml = '';
        invoice.items.forEach(item => {
            itemsHtml += `<div style="display: flex; justify-content: space-between; padding: 4px 0; border-bottom: 1px solid #E9D5FF;">
                <span>${item.nama} (x${item.qty})</span>
                <span style="color: #7C5CDB; font-weight: 600;">Rp ${Number(item.harga).toLocaleString('id-ID')}</span>
            </div>`;
        });

        previewContent.innerHTML = `
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 12px;">
                <div><strong>Pelanggan:</strong> ${invoice.pelanggan}</div>
                <div><strong>Tanggal:</strong> ${invoice.tanggal}</div>
                <div><strong>Total:</strong> <span style="color: #7C5CDB; font-weight: 700;">Rp ${Number(invoice.total_harga).toLocaleString('id-ID')}</span></div>
            </div>
            <div style="margin-top: 10px;">
                <strong>Items:</strong>
                ${itemsHtml || '<div style="color: #9CA3AF;">Tidak ada item</div>'}
            </div>
        `;

        preview.style.display = 'block';
    }

    document.getElementById('no_invoice').addEventListener('change', function() {
        showInvoicePreview(this.value);
    });

    // Trigger preview on page load for the currently selected invoice
    document.addEventListener('DOMContentLoaded', function() {
        const invoiceSelect = document.getElementById('no_invoice');
        if (invoiceSelect.value) {
            showInvoicePreview(invoiceSelect.value);
        }
    });
</script>
@endsection

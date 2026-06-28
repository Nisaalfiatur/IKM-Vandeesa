@extends('layouts.app')

@section('content')
<style>
    .page-header-create {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
    }
    .page-header-create h1 {
        font-size: 1.65rem;
        font-weight: 700;
        color: #1E1B4B;
        margin: 0;
        letter-spacing: -0.5px;
    }
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 20px;
        background: #F5F3FF;
        color: #6B46C1;
        border: 1.5px solid #E9D5FF;
        border-radius: 10px;
        font-size: 0.88rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-back:hover {
        background: #EDE9FE;
        border-color: #D8B4FE;
        color: #7C5CDB;
        transform: translateX(-3px);
    }

    /* Validation Errors */
    .validation-errors {
        background: linear-gradient(135deg, #FEE2E2 0%, #FFF1F2 100%);
        border: 1.5px solid #FECACA;
        border-left: 4px solid #EF4444;
        border-radius: 12px;
        padding: 18px 22px;
        margin-bottom: 24px;
        animation: shakeIn 0.4s ease;
    }
    @keyframes shakeIn {
        0%, 100% { transform: translateX(0); }
        20% { transform: translateX(-6px); }
        40% { transform: translateX(6px); }
        60% { transform: translateX(-4px); }
        80% { transform: translateX(4px); }
    }
    .validation-errors h4 {
        color: #991B1B;
        font-size: 0.92rem;
        font-weight: 700;
        margin: 0 0 10px 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .validation-errors ul {
        margin: 0;
        padding-left: 18px;
        list-style: none;
    }
    .validation-errors ul li {
        color: #B91C1C;
        font-size: 0.82rem;
        padding: 3px 0;
        position: relative;
        padding-left: 14px;
    }
    .validation-errors ul li::before {
        content: '•';
        position: absolute;
        left: 0;
        color: #EF4444;
        font-weight: 700;
    }

    /* Form Card */
    .form-card {
        background: #fff;
        border-radius: 16px;
        border: 1.5px solid #E9D5FF;
        box-shadow: 0 4px 24px rgba(124, 92, 219, 0.07), 0 1.5px 6px rgba(124, 92, 219, 0.04);
        overflow: hidden;
    }
    .form-card-header {
        background: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%);
        padding: 20px 28px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-card-header span.icon {
        font-size: 1.35rem;
    }
    .form-card-header h3 {
        color: #fff;
        font-size: 1.05rem;
        font-weight: 700;
        margin: 0;
    }
    .form-card-header p {
        color: rgba(255,255,255,0.75);
        font-size: 0.78rem;
        margin: 2px 0 0 0;
    }
    .form-card-body {
        padding: 30px 28px 28px;
    }

    /* Two Column Grid */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 22px 28px;
    }
    .form-group {
        display: flex;
        flex-direction: column;
    }
    .form-group.full-width {
        grid-column: 1 / -1;
    }
    .form-group label {
        font-size: 0.82rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 7px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .form-group label .required {
        color: #EF4444;
        font-weight: 700;
    }
    .form-group input,
    .form-group select {
        padding: 11px 15px;
        border: 1.5px solid #E5E7EB;
        border-radius: 10px;
        font-size: 0.88rem;
        color: #374151;
        background: #fff;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        outline: none;
        width: 100%;
        box-sizing: border-box;
    }
    .form-group input:focus,
    .form-group select:focus {
        border-color: #7C5CDB;
        box-shadow: 0 0 0 3.5px rgba(124, 92, 219, 0.13);
        background: #FDFCFF;
    }
    .form-group input.is-invalid,
    .form-group select.is-invalid {
        border-color: #EF4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    .form-group input[readonly] {
        background: #F5F3FF;
        color: #6B46C1;
        font-weight: 700;
        border-color: #D8B4FE;
        cursor: default;
    }
    .field-error {
        color: #EF4444;
        font-size: 0.75rem;
        margin-top: 5px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Invoice Preview */
    .invoice-preview {
        grid-column: 1 / -1;
        margin-top: 4px;
    }
    .invoice-preview-card {
        background: linear-gradient(135deg, #F5F3FF 0%, #EDE9FE 100%);
        border: 1.5px solid #D8B4FE;
        border-radius: 14px;
        overflow: hidden;
        max-height: 0;
        opacity: 0;
        transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.4s ease, padding 0.4s ease;
        padding: 0 22px;
    }
    .invoice-preview-card.active {
        max-height: 600px;
        opacity: 1;
        padding: 22px;
    }
    .invoice-preview-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: #6B46C1;
        margin: 0 0 14px 0;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    .preview-info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 16px;
    }
    .preview-info-item {
        background: rgba(255,255,255,0.8);
        border-radius: 10px;
        padding: 12px 14px;
        border: 1px solid rgba(124, 92, 219, 0.12);
    }
    .preview-info-item .label {
        font-size: 0.7rem;
        color: #9CA3AF;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .preview-info-item .value {
        font-size: 0.88rem;
        color: #374151;
        font-weight: 600;
    }
    .preview-items-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: rgba(255,255,255,0.85);
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid rgba(124, 92, 219, 0.12);
    }
    .preview-items-table thead th {
        background: rgba(124, 92, 219, 0.08);
        padding: 10px 14px;
        font-size: 0.73rem;
        font-weight: 700;
        color: #6B46C1;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: left;
        border-bottom: 1px solid rgba(124, 92, 219, 0.1);
    }
    .preview-items-table tbody td {
        padding: 9px 14px;
        font-size: 0.82rem;
        color: #374151;
        border-bottom: 1px solid #F3F4F6;
    }
    .preview-items-table tbody tr:last-child td {
        border-bottom: none;
    }
    .preview-empty {
        text-align: center;
        padding: 20px;
        color: #9CA3AF;
        font-size: 0.82rem;
    }

    /* Action Buttons */
    .form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 14px;
        margin-top: 30px;
        padding-top: 24px;
        border-top: 1.5px solid #F3F4F6;
    }
    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 30px;
        background: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 0.92rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(124, 92, 219, 0.3);
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(124, 92, 219, 0.4);
        background: linear-gradient(135deg, #6B46C1 0%, #5B21B6 100%);
    }
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 12px 26px;
        background: #F9FAFB;
        color: #6B7280;
        border: 1.5px solid #E5E7EB;
        border-radius: 12px;
        font-size: 0.88rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-cancel:hover {
        background: #F3F4F6;
        color: #374151;
        border-color: #D1D5DB;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .preview-info-grid {
            grid-template-columns: 1fr;
        }
        .form-actions {
            flex-direction: column-reverse;
        }
        .form-actions .btn-submit,
        .form-actions .btn-cancel {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="page-header-create">
    <h1>🚚 Buat Delivery Order Baru</h1>
    <a href="{{ route('delivery.index') }}" class="btn-back">
        ← Kembali
    </a>
</div>

{{-- Validation Errors --}}
@if ($errors->any())
    <div class="validation-errors">
        <h4>⚠️ Terdapat kesalahan pada form:</h4>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-card">
    <div class="form-card-header">
        <span class="icon">📋</span>
        <div>
            <h3>Form Delivery Order</h3>
            <p>Lengkapi data di bawah untuk membuat delivery order baru</p>
        </div>
    </div>

    <div class="form-card-body">
        <form action="{{ route('delivery.store') }}" method="POST">
            @csrf

            <div class="form-grid">
                {{-- No DO --}}
                <div class="form-group">
                    <label>
                        🔖 No Delivery Order
                    </label>
                    <input type="text" name="no_do" value="{{ old('no_do', $nextDONumber) }}" readonly>
                    @if ($errors->has('no_do'))
                        <span class="field-error">⚠ {{ $errors->first('no_do') }}</span>
                    @endif
                </div>

                {{-- Tanggal --}}
                <div class="form-group">
                    <label>
                        📅 Tanggal <span class="required">*</span>
                    </label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="{{ $errors->has('tanggal') ? 'is-invalid' : '' }}">
                    @if ($errors->has('tanggal'))
                        <span class="field-error">⚠ {{ $errors->first('tanggal') }}</span>
                    @endif
                </div>

                {{-- No Invoice --}}
                <div class="form-group">
                    <label>
                        📄 No Invoice <span class="required">*</span>
                    </label>
                    <select name="no_invoice" id="invoiceSelect" class="{{ $errors->has('no_invoice') ? 'is-invalid' : '' }}">
                        <option value="">-- Pilih Invoice --</option>
                        @foreach ($invoices as $invoice)
                            <option value="{{ $invoice->no_invoice }}" {{ old('no_invoice') == $invoice->no_invoice ? 'selected' : '' }}>
                                {{ $invoice->no_invoice }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('no_invoice'))
                        <span class="field-error">⚠ {{ $errors->first('no_invoice') }}</span>
                    @endif
                </div>





                {{-- Status --}}
                <div class="form-group">
                    <label>
                        📊 Status <span class="required">*</span>
                    </label>
                    <select name="status" class="{{ $errors->has('status') ? 'is-invalid' : '' }}">
                        <option value="">-- Pilih Status --</option>
                        <option value="Menunggu" {{ old('status', 'Menunggu') == 'Menunggu' ? 'selected' : '' }}>Menunggu 🟡</option>
                        <option value="Diproses" {{ old('status') == 'Diproses' ? 'selected' : '' }}>Diproses 🔵</option>
                        <option value="Dikirim" {{ old('status') == 'Dikirim' ? 'selected' : '' }}>Dikirim 🟣</option>
                        <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai 🟢</option>
                        <option value="Dibatalkan" {{ old('status') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan 🔴</option>
                    </select>
                    @if ($errors->has('status'))
                        <span class="field-error">⚠ {{ $errors->first('status') }}</span>
                    @endif
                </div>

                {{-- Invoice Preview --}}
                <div class="invoice-preview">
                    <div class="invoice-preview-card" id="invoicePreview">
                        <h4 class="invoice-preview-title">📋 Detail Invoice yang Dipilih</h4>
                        <div class="preview-info-grid" id="previewInfoGrid">
                            <div class="preview-info-item">
                                <div class="label">Pelanggan</div>
                                <div class="value" id="prevPelanggan">-</div>
                            </div>
                            <div class="preview-info-item">
                                <div class="label">Tanggal Invoice</div>
                                <div class="value" id="prevTanggal">-</div>
                            </div>
                            <div class="preview-info-item">
                                <div class="label">Total Harga</div>
                                <div class="value" id="prevTotal">-</div>
                            </div>
                        </div>
                        <table class="preview-items-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Item</th>
                                    <th>Qty</th>
                                    <th>Harga Per Pcs</th>
                                </tr>
                            </thead>
                            <tbody id="previewItemsBody">
                                <tr>
                                    <td colspan="4" class="preview-empty">Pilih invoice untuk melihat detail</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="form-actions">
                <a href="{{ route('delivery.index') }}" class="btn-cancel">
                    ✖ Cancel
                </a>
                <button type="submit" class="btn-submit">
                    💾 Simpan Delivery Order
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const invoicesData = @json($invoices->keyBy('no_invoice'));
        const invoiceSelect = document.getElementById('invoiceSelect');
        const previewCard = document.getElementById('invoicePreview');
        const prevPelanggan = document.getElementById('prevPelanggan');
        const prevTanggal = document.getElementById('prevTanggal');
        const prevTotal = document.getElementById('prevTotal');
        const previewItemsBody = document.getElementById('previewItemsBody');

        function formatCurrency(num) {
            return 'Rp ' + Number(num).toLocaleString('id-ID');
        }

        function formatDate(dateStr) {
            if (!dateStr) return '-';
            const d = new Date(dateStr);
            return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
        }

        function updatePreview() {
            const selected = invoiceSelect.value;

            if (!selected || !invoicesData[selected]) {
                previewCard.classList.remove('active');
                return;
            }

            const invoice = invoicesData[selected];

            const namaPelanggan = invoice.pelanggan ? invoice.pelanggan.nama 
                : (invoice.member ? invoice.member.nama 
                : (invoice.reseller ? invoice.reseller.nama : '-'));
                
            prevPelanggan.textContent = namaPelanggan;
            prevTanggal.textContent = formatDate(invoice.tanggal);
            prevTotal.textContent = invoice.total_harga ? formatCurrency(invoice.total_harga) : '-';

            let itemsHtml = '';
            const details = invoice.detail || [];

            if (details.length === 0) {
                itemsHtml = '<tr><td colspan="4" class="preview-empty">Tidak ada item</td></tr>';
            } else {
                details.forEach(function(detail, index) {
                    const item = detail.item || {};
                    itemsHtml += '<tr>' +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + (item.nama_item || '-') + '</td>' +
                        '<td>' + (detail.quantity || 0) + '</td>' +
                        '<td>' + formatCurrency(detail.harga_perpcs || 0) + '</td>' +
                        '</tr>';
                });
            }

            previewItemsBody.innerHTML = itemsHtml;
            previewCard.classList.add('active');
        }

        invoiceSelect.addEventListener('change', updatePreview);

        // Trigger preview if old value is selected
        if (invoiceSelect.value) {
            updatePreview();
        }
    });
</script>
@endsection

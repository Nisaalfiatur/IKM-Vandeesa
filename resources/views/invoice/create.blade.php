@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="page-header">
        <h1 class="page-title">✨ Buat Invoice Baru</h1>
        <p class="page-subtitle">Silakan isi form di bawah untuk membuat invoice penjualan baru 🚀</p>
    </div>

    @if($errors->any())
        <div class="alert-error bounce-in">
            <div class="alert-icon">⚠️</div>
            <div class="alert-content">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    <div class="card form-card slide-up">
        <form method="POST" action="{{ route('invoice.store') }}">
            @csrf

            <div class="form-group">
                <label for="no_invoice">📄 No Invoice</label>
                <input type="text" id="no_invoice" name="no_invoice" value="{{ $nextInvoiceNumber }}" readonly class="input-readonly">
            </div>

            <div class="form-grid">
                <div class="form-group" style="grid-column: span 2;">
                    <label for="id_pelanggan">👥 Pelanggan</label>
                    <div class="select-wrapper">
                        <select id="id_pelanggan" name="id_pelanggan" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($allPelanggans as $p)
                                <option value="{{ $p['value'] }}">{{ $p['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="tanggal">📅 Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="info-alert slide-up-delay">
                <div class="info-icon">💡</div>
                <div class="info-text">
                    <strong>Info Penting:</strong> Setelah invoice dibuat, Anda akan dialihkan ke halaman detail untuk menambahkan item penjualan.
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <span>💾 Simpan Invoice</span>
                </button>
                <a href="{{ route('invoice.index') }}" class="btn-secondary">
                    <span>❌ Batal</span>
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    /* Typography & Variables */
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --primary-gradient: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%);
        --primary-light: #F5F3FF;
        --text-main: #1F2937;
        --text-muted: #6B7280;
        --border-color: #E5E7EB;
        --focus-ring: rgba(123, 92, 219, 0.25);
        --shadow-soft: 0 4px 15px rgba(123, 92, 219, 0.08);
        --shadow-hover: 0 10px 25px rgba(123, 92, 219, 0.15);
    }

    .page-container {
        font-family: 'Plus Jakarta Sans', sans-serif;
        max-width: 800px;
        margin: 0 auto;
        color: var(--text-main);
        padding: 20px 0;
    }

    /* Headers */
    .page-header {
        margin-bottom: 30px;
        text-align: center;
        animation: slideDown 0.5s ease-out;
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        margin: 0 0 10px 0;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .page-subtitle {
        color: var(--text-muted);
        font-size: 15px;
        margin: 0;
    }

    /* Alerts */
    .alert-error {
        background: #FEF2F2;
        border: 1px solid #FCA5A5;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        color: #991B1B;
    }

    .alert-icon {
        font-size: 20px;
        animation: bounce 2s infinite;
    }

    .alert-content p {
        margin: 0 0 4px 0;
        font-size: 14px;
    }
    .alert-content p:last-child {
        margin: 0;
    }

    .info-alert {
        background: #EEF2FF;
        border-radius: 12px;
        padding: 16px;
        margin: 24px 0;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        border: 1px solid #C7D2FE;
    }

    .info-icon {
        font-size: 20px;
        animation: float 3s ease-in-out infinite;
    }

    .info-text {
        font-size: 14px;
        color: #3730A3;
        line-height: 1.5;
    }

    /* Card & Form elements */
    .card {
        background: white;
        border-radius: 20px;
        padding: 32px;
        box-shadow: var(--shadow-soft);
        border: 1px solid rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(10px);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        box-shadow: var(--shadow-hover);
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #4B5563;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid var(--border-color);
        border-radius: 12px;
        font-size: 14px;
        font-family: inherit;
        background: white;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-sizing: border-box;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #7C5CDB;
        box-shadow: 0 0 0 4px var(--focus-ring);
        transform: translateY(-1px);
    }

    .input-readonly {
        background: #F9FAFB !important;
        color: #6B7280;
        cursor: not-allowed;
    }

    .select-wrapper {
        position: relative;
    }
    .select-wrapper::after {
        content: '⌄';
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 18px;
        color: #9CA3AF;
        pointer-events: none;
    }
    .form-group select {
        appearance: none;
        padding-right: 40px;
    }

    /* Buttons */
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
    }

    .btn-primary, .btn-secondary {
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-family: inherit;
    }

    .btn-primary {
        background: var(--primary-gradient);
        color: white;
        flex: 1;
        box-shadow: 0 4px 15px rgba(123, 92, 219, 0.2);
    }

    .btn-primary:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 25px rgba(123, 92, 219, 0.3);
    }

    .btn-primary:active {
        transform: translateY(0) scale(0.98);
    }

    .btn-secondary {
        background: #F3F4F6;
        color: #4B5563;
        flex: 1;
    }

    .btn-secondary:hover {
        background: #E5E7EB;
        transform: translateY(-2px);
        color: #1F2937;
    }

    /* Animations */
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-3px); }
    }

    .slide-up {
        animation: slideUp 0.6s ease-out forwards;
    }

    .slide-up-delay {
        opacity: 0;
        animation: slideUp 0.6s ease-out 0.2s forwards;
    }

    .bounce-in {
        animation: bounce 0.5s cubic-bezier(0.36, 0, 0.66, -0.56) forwards;
    }

    @media (max-width: 640px) {
        .form-grid {
            grid-template-columns: 1fr;
            gap: 0;
        }
        .form-actions {
            flex-direction: column;
        }
    }
</style>
@endsection

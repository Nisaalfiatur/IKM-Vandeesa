@extends('layouts.app')

@section('content')
<div>
    <h1>➕ Buat Invoice Baru</h1>

    @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('invoice.store') }}" class="form-container">
        @csrf

        <div class="form-group">
            <label for="no_invoice">No Invoice</label>
            <input type="text" id="no_invoice" name="no_invoice" value="{{ $nextInvoiceNumber }}" readonly>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="id_pelanggan">Pelanggan</label>
                <select id="id_pelanggan" name="id_pelanggan" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->id_pelanggan }}">{{ $pelanggan->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_member">Member</label>
                <select id="id_member" name="id_member" required>
                    <option value="">-- Pilih Member --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id_member }}">{{ $member->nama }}</option>
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
                        <option value="{{ $pegawai->id_pegawai }}">{{ $pegawai->nama_pg }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_pg_kasir">Kasir</label>
                <select id="id_pg_kasir" name="id_pg_kasir" required>
                    <option value="">-- Pilih Kasir --</option>
                    @foreach($pegawais as $pegawai)
                        <option value="{{ $pegawai->id_pegawai }}">{{ $pegawai->nama_pg }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" required>
        </div>

        <div style="background: #FEF3C7; padding: 15px; border-radius: 8px; margin-top: 20px; margin-bottom: 20px; border-left: 4px solid #F59E0B;">
            <p style="margin: 0; font-size: 14px; color: #92400E;">
                <strong>ℹ️ Info:</strong> Setelah invoice dibuat, Anda akan dialihkan ke halaman detail untuk menambahkan item penjualan.
            </p>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn-submit">💾 Simpan Invoice</button>
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
@endsection

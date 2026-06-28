@extends('layouts.app')

@section('content')
<div class="master-container">
    <div class="master-page-header">
        <div class="master-header-left">
            <div class="master-breadcrumb">
                <a href="{{ route('pelanggan.index') }}" style="color:#9CA3AF;text-decoration:none;">Master Pelanggan</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                <span class="master-breadcrumb-active">Edit Pelanggan</span>
            </div>
            <h1 class="master-page-title">
                <div class="master-title-icon" style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </div>
                Edit Pelanggan
            </h1>
            <p class="master-page-subtitle">Perbarui informasi data pelanggan</p>
        </div>
    </div>

    <div class="master-card" style="padding: 32px;">
        <div class="master-form-header">
            <div class="master-avatar" style="width:52px;height:52px;border-radius:14px;font-size:20px;background:linear-gradient(135deg,#10B981,#059669);">
                {{ strtoupper(substr($pelanggan->nama, 0, 1)) }}
            </div>
            <div>
                <h2 style="font-size:18px;font-weight:700;color:#1F2937;margin:0 0 2px 0;">{{ $pelanggan->nama }}</h2>
                <p style="font-size:13px;color:#6B7280;margin:0;">{{ $pelanggan->id_pelanggan }} &mdash; {{ $pelanggan->no_telpn ?: 'Tidak ada telepon' }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('pelanggan.update', $pelanggan->id_pelanggan) }}">
            @csrf
            @method('PUT')

            <div class="master-form-grid">
                <div class="master-form-group">
                    <label class="master-form-label">ID Pelanggan</label>
                    <input type="text" class="master-form-input" value="{{ $pelanggan->id_pelanggan }}" readonly>
                    <span class="master-form-hint">ID tidak dapat diubah</span>
                </div>

                <div class="master-form-group">
                    <label class="master-form-label">Nama Pelanggan <span class="required">*</span></label>
                    <input type="text" name="nama"
                        class="master-form-input {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                        value="{{ old('nama', $pelanggan->nama) }}"
                        placeholder="Masukkan nama lengkap">
                    @error('nama')<span class="master-error-text"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                </div>

                <div class="master-form-group master-form-grid-full">
                    <label class="master-form-label">No Telepon</label>
                    <input type="text" name="no_telpn"
                        class="master-form-input {{ $errors->has('no_telpn') ? 'is-invalid' : '' }}"
                        value="{{ old('no_telpn', $pelanggan->no_telpn) }}"
                        placeholder="Contoh: 081234567890">
                    @error('no_telpn')<span class="master-error-text"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="master-form-actions">
                <button type="submit" class="master-btn-submit" style="background:linear-gradient(135deg,#F59E0B,#D97706);box-shadow:0 4px 14px rgba(245,158,11,0.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('pelanggan.index') }}" class="master-btn-cancel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@include('partials.master-styles')
@endsection

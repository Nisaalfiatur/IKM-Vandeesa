@extends('layouts.app')

@section('content')
<div class="master-container">
    <div class="master-page-header">
        <div class="master-header-left">
            <div class="master-breadcrumb">
                <a href="{{ route('pelanggan.index') }}" style="color:#9CA3AF;text-decoration:none;">Master Pelanggan</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                <span class="master-breadcrumb-active">Tambah Pelanggan</span>
            </div>
            <h1 class="master-page-title">
                <div class="master-title-icon" style="background: linear-gradient(135deg, #10B981, #059669);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                </div>
                Tambah Pelanggan
            </h1>
            <p class="master-page-subtitle">Isi data lengkap untuk menambahkan pelanggan baru</p>
        </div>
    </div>

    <div class="master-card" style="padding: 32px;">
        <div class="master-form-header">
            <div class="master-form-header-icon" style="background: linear-gradient(135deg, #10B981, #059669);">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <h2>Data Pelanggan Baru</h2>
                <p>Lengkapi semua field yang diperlukan</p>
            </div>
        </div>

        <form method="POST" action="{{ route('pelanggan.store') }}">
            @csrf
            <div class="master-form-grid">
                <div class="master-form-group">
                    <label class="master-form-label">ID Pelanggan <span class="required">*</span></label>
                    <input type="text" name="id_pelanggan" class="master-form-input {{ $errors->has('id_pelanggan') ? 'is-invalid' : '' }}" value="{{ old('id_pelanggan', $nextId) }}" readonly style="background: #F5F3FF; color: #6B46C1; font-weight: 700; cursor: default;">
                    @error('id_pelanggan')<span class="master-error-text"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                </div>

                <div class="master-form-group">
                    <label class="master-form-label">Nama Pelanggan <span class="required">*</span></label>
                    <input type="text" name="nama" class="master-form-input {{ $errors->has('nama') ? 'is-invalid' : '' }}" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap">
                    @error('nama')<span class="master-error-text"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                </div>

                <div class="master-form-group master-form-grid-full">
                    <label class="master-form-label">No Telepon</label>
                    <input type="text" name="no_telpn" class="master-form-input {{ $errors->has('no_telpn') ? 'is-invalid' : '' }}" value="{{ old('no_telpn') }}" placeholder="Contoh: 081234567890">
                    @error('no_telpn')<span class="master-error-text"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="master-form-actions">
                <button type="submit" class="master-btn-submit" style="background:linear-gradient(135deg,#10B981,#059669);box-shadow:0 4px 14px rgba(16,185,129,0.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Pelanggan
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

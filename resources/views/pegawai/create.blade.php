@extends('layouts.app')

@section('content')
<div class="master-container">

    {{-- Page Header --}}
    <div class="master-page-header">
        <div class="master-header-left">
            <div class="master-breadcrumb">
                <a href="{{ route('pegawai.index') }}" style="color:#9CA3AF;text-decoration:none;">Master Pegawai</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                <span class="master-breadcrumb-active">Tambah Pegawai</span>
            </div>
            <h1 class="master-page-title">
                <div class="master-title-icon" style="background: linear-gradient(135deg, #4F46E5, #6366F1);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                Tambah Pegawai
            </h1>
            <p class="master-page-subtitle">Isi data lengkap untuk menambahkan pegawai baru</p>
        </div>
    </div>

    <div class="master-card" style="padding: 32px;">
        <div class="master-form-header">
            <div class="master-form-header-icon" style="background: linear-gradient(135deg, #4F46E5, #6366F1);">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
            </div>
            <div>
                <h2>Data Pegawai Baru</h2>
                <p>Lengkapi semua field yang diperlukan</p>
            </div>
        </div>

        <form method="POST" action="{{ route('pegawai.store') }}" id="pegawaiForm">
            @csrf

            <div class="master-form-grid">
                <div class="master-form-group">
                    <label class="master-form-label">ID Pegawai <span class="required">*</span></label>
                    <input type="text" name="id_pegawai"
                        class="master-form-input {{ $errors->has('id_pegawai') ? 'is-invalid' : '' }}"
                        value="{{ old('id_pegawai', $nextId) }}" readonly style="background: #F5F3FF; color: #6B46C1; font-weight: 700; cursor: default;">
                    @error('id_pegawai')
                    <span class="master-error-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="master-form-group">
                    <label class="master-form-label">Nama Pegawai <span class="required">*</span></label>
                    <input type="text" name="nama_pg"
                        class="master-form-input {{ $errors->has('nama_pg') ? 'is-invalid' : '' }}"
                        value="{{ old('nama_pg') }}"
                        placeholder="Masukkan nama lengkap">
                    @error('nama_pg')
                    <span class="master-error-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                <div class="master-form-group master-form-grid-full">
                    <label class="master-form-label">Jabatan <span class="required">*</span></label>
                    <input type="text" name="jabatan"
                        class="master-form-input {{ $errors->has('jabatan') ? 'is-invalid' : '' }}"
                        value="{{ old('jabatan') }}"
                        placeholder="Contoh: Kasir, Admin, Manajer">
                    @error('jabatan')
                    <span class="master-error-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="master-form-actions">
                <button type="submit" class="master-btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Pegawai
                </button>
                <a href="{{ route('pegawai.index') }}" class="master-btn-cancel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@include('partials.master-styles')
@endsection

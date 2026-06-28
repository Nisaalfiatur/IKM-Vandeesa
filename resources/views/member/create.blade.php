@extends('layouts.app')

@section('content')
<div class="master-container">
    <div class="master-page-header">
        <div class="master-header-left">
            <div class="master-breadcrumb">
                <a href="{{ route('member.index') }}" style="color:#9CA3AF;text-decoration:none;">Master Member</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                <span class="master-breadcrumb-active">Tambah Member</span>
            </div>
            <h1 class="master-page-title">
                <div class="master-title-icon" style="background: linear-gradient(135deg, #8B5CF6, #7C3AED);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
                Tambah Member
            </h1>
            <p class="master-page-subtitle">Daftarkan member baru ke program loyalitas</p>
        </div>
    </div>

    <div class="master-card" style="padding: 32px;">
        <div class="master-form-header">
            <div class="master-form-header-icon" style="background: linear-gradient(135deg, #8B5CF6, #7C3AED);">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
            </div>
            <div>
                <h2>Data Member Baru</h2>
                <p>Lengkapi semua field yang diperlukan</p>
            </div>
        </div>

        <form method="POST" action="{{ route('member.store') }}">
            @csrf
            <div class="master-form-grid">
                <div class="master-form-group">
                    <label class="master-form-label">ID Member <span class="required">*</span></label>
                    <input type="text" name="id_member"
                        class="master-form-input {{ $errors->has('id_member') ? 'is-invalid' : '' }}"
                        value="{{ old('id_member', $nextId) }}" readonly style="background: #F5F3FF; color: #6B46C1; font-weight: 700; cursor: default;">
                    @error('id_member')<span class="master-error-text"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                </div>

                <div class="master-form-group">
                    <label class="master-form-label">Nama <span class="required">*</span></label>
                    <input type="text" name="nama"
                        class="master-form-input {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                        value="{{ old('nama') }}" placeholder="Nama lengkap member">
                    @error('nama')<span class="master-error-text"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                </div>

                <div class="master-form-group">
                    <label class="master-form-label">Kategori <span class="required">*</span></label>
                    <select name="kategori" class="master-form-select {{ $errors->has('kategori') ? 'is-invalid' : '' }}">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="online"  {{ old('kategori') === 'online'  ? 'selected' : '' }}>🌐 Online</option>
                        <option value="offline" {{ old('kategori') === 'offline' ? 'selected' : '' }}>🏪 Offline</option>
                    </select>
                    @error('kategori')<span class="master-error-text"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                </div>

                <div class="master-form-group">
                    <label class="master-form-label">No Telepon</label>
                    <input type="text" name="no_telp"
                        class="master-form-input {{ $errors->has('no_telp') ? 'is-invalid' : '' }}"
                        value="{{ old('no_telp') }}" placeholder="Contoh: 081234567890">
                    @error('no_telp')<span class="master-error-text"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                </div>

                <div class="master-form-group">
                    <label class="master-form-label">Email</label>
                    <input type="email" name="email"
                        class="master-form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        value="{{ old('email') }}" placeholder="contoh@email.com">
                    @error('email')<span class="master-error-text"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                </div>

                <div class="master-form-group">
                    <label class="master-form-label">Tanggal Daftar</label>
                    <input type="date" name="tgl_daftar"
                        class="master-form-input {{ $errors->has('tgl_daftar') ? 'is-invalid' : '' }}"
                        value="{{ old('tgl_daftar', date('Y-m-d')) }}">
                    @error('tgl_daftar')<span class="master-error-text"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                </div>


            </div>

            <div class="master-form-actions">
                <button type="submit" class="master-btn-submit" style="background:linear-gradient(135deg,#8B5CF6,#7C3AED);box-shadow:0 4px 14px rgba(139,92,246,0.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Member
                </button>
                <a href="{{ route('member.index') }}" class="master-btn-cancel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@include('partials.master-styles')
@endsection

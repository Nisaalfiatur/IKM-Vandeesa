@extends('layouts.app')

@section('content')
<div class="master-container">
    <div class="master-page-header">
        <div class="master-header-left">
            <div class="master-breadcrumb">
                <a href="{{ route('reseller.index') }}">Reseller</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                <span class="master-breadcrumb-active">Edit Reseller</span>
            </div>
            <h1 class="master-page-title">Edit Reseller</h1>
            <p class="master-page-subtitle">Ubah informasi kemitraan reseller</p>
        </div>
    </div>

    <div class="master-card master-form-container" style="padding: 28px;">
        <div class="master-form-header">
            <div class="master-form-header-icon" style="background: linear-gradient(135deg, #10B981, #059669);">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </div>
            <div>
                <h2>Informasi Kemitraan Reseller</h2>
                <p>Perbarui detail data mitra reseller di bawah ini.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('reseller.update', $reseller->id_reseller) }}">
            @csrf
            @method('PUT')

            <div class="master-form-grid">
                <div class="master-form-group">
                    <label class="master-form-label">ID Reseller</label>
                    <input type="text" value="{{ $reseller->id_reseller }}" class="master-form-input" readonly>
                    <span class="master-form-hint">ID Reseller bersifat unik dan tidak dapat diubah</span>
                </div>

                <div class="master-form-group">
                    <label class="master-form-label">Nama Reseller <span class="required">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $reseller->nama) }}" class="master-form-input" required>
                </div>

                <div class="master-form-group">
                    <label class="master-form-label">No Telepon <span class="required">*</span></label>
                    <input type="text" name="no_telp" value="{{ old('no_telp', $reseller->no_telp) }}" class="master-form-input" required>
                </div>

                <div class="master-form-group">
                    <label class="master-form-label">Nama Brand <span class="required">*</span></label>
                    <input type="text" name="nama_brand" value="{{ old('nama_brand', $reseller->nama_brand) }}" class="master-form-input" required>
                </div>

                <div class="master-form-group master-form-grid-full">
                    <label class="master-form-label">Email Reseller <span class="required">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $reseller->email) }}" class="master-form-input" required>
                </div>

                <div class="master-form-group master-form-grid-full">
                    <label class="master-form-label">Alamat Lengkap <span class="required">*</span></label>
                    <textarea name="alamat" class="master-form-textarea" required>{{ old('alamat', $reseller->alamat) }}</textarea>
                </div>
            </div>

            <div class="master-form-actions">
                <button type="submit" class="master-btn-submit" style="background: linear-gradient(135deg, #10B981, #059669); box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Perbarui Reseller
                </button>
                <a href="{{ route('reseller.index') }}" class="master-btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>

@include('partials.master-styles')
@endsection

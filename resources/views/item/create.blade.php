@extends('layouts.app')

@section('content')
<div class="master-container">
    <div class="master-page-header">
        <div class="master-header-left">
            <div class="master-breadcrumb">
                <a href="{{ route('item.index') }}" style="color:#9CA3AF;text-decoration:none;">Master Item</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                <span class="master-breadcrumb-active">Tambah Item</span>
            </div>
            <h1 class="master-page-title">
                <div class="master-title-icon" style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                </div>
                Tambah Item
            </h1>
            <p class="master-page-subtitle">Tambahkan produk baru ke katalog</p>
        </div>
    </div>

    <div class="master-card" style="padding: 32px;">
        <div class="master-form-header">
            <div class="master-form-header-icon" style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
            </div>
            <div>
                <h2>Data Item Baru</h2>
                <p>Lengkapi semua field yang diperlukan</p>
            </div>
        </div>

        <form method="POST" action="{{ route('item.store') }}" enctype="multipart/form-data" id="itemForm">
            @csrf

            <div class="master-form-grid">
                <div class="master-form-group">
                    <label class="master-form-label">ID Item <span class="required">*</span></label>
                    <input type="text" name="id_item"
                        class="master-form-input {{ $errors->has('id_item') ? 'is-invalid' : '' }}"
                        value="{{ old('id_item') }}"
                        placeholder="Contoh: ITM001">
                    @error('id_item')<span class="master-error-text"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                </div>

                <div class="master-form-group">
                    <label class="master-form-label">Nama Item <span class="required">*</span></label>
                    <input type="text" name="nama_item"
                        class="master-form-input {{ $errors->has('nama_item') ? 'is-invalid' : '' }}"
                        value="{{ old('nama_item') }}"
                        placeholder="Contoh: Gamis Anak - Motif Bunga">
                    @error('nama_item')<span class="master-error-text"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                </div>

                <div class="master-form-group">
                    <label class="master-form-label">Stok Item <span class="required">*</span></label>
                    <input type="number" name="stok_item" min="0"
                        class="master-form-input {{ $errors->has('stok_item') ? 'is-invalid' : '' }}"
                        value="{{ old('stok_item') }}"
                        placeholder="Contoh: 100">
                    @error('stok_item')<span class="master-error-text"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                </div>

                <div class="master-form-group">
                    <label class="master-form-label">Harga <span class="required">*</span></label>
                    <input type="text" name="harga"
                        class="master-form-input {{ $errors->has('harga') ? 'is-invalid' : '' }}"
                        value="{{ old('harga') }}"
                        placeholder="Contoh: 150000">
                    @error('harga')<span class="master-error-text"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                </div>

                <div class="master-form-group master-form-grid-full">
                    <label class="master-form-label">Gambar Item</label>
                    <label class="master-file-upload-area" for="gambarInput" id="uploadArea">
                        <input type="file" name="gambar" id="gambarInput" accept="image/*" onchange="previewImage(this)">
                        <div id="uploadPlaceholder">
                            <div class="master-file-upload-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                            <div class="master-file-upload-text">Klik untuk pilih gambar</div>
                            <div class="master-file-upload-hint">Format: JPG, PNG, GIF — Maks. 2MB</div>
                        </div>
                        <img id="imagePreview" src="" alt="Preview" class="master-img-preview" style="display:none;">
                    </label>
                    @error('gambar')<span class="master-error-text"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="master-form-actions">
                <button type="submit" class="master-btn-submit" style="background:linear-gradient(135deg,#F59E0B,#D97706);box-shadow:0 4px 14px rgba(245,158,11,0.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Item
                </button>
                <a href="{{ route('item.index') }}" class="master-btn-cancel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@include('partials.master-styles')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('uploadPlaceholder');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection

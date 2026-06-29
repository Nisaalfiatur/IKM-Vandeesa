@extends('layouts.app')

@section('content')
<div class="master-container">
    <div class="master-page-header">
        <div class="master-header-left">
            <div class="master-breadcrumb">
                <a href="{{ route('item.index') }}" style="color:#9CA3AF;text-decoration:none;">Master Item</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                <span class="master-breadcrumb-active">Edit Item</span>
            </div>
            <h1 class="master-page-title">
                <div class="master-title-icon" style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </div>
                Edit Item
            </h1>
            <p class="master-page-subtitle">Perbarui informasi data item</p>
        </div>
    </div>

    <div class="master-card" style="padding: 32px;">
        {{-- Item header with current image --}}
        <div class="master-form-header" style="align-items:flex-start;">
            @if($item->gambar)
                <img src="{{ asset('images/items/' . $item->gambar) }}" alt="{{ $item->nama_item }}"
                    style="width:64px;height:64px;object-fit:cover;border-radius:14px;border:2px solid #E5E7EB;flex-shrink:0;">
            @else
                <div style="width:64px;height:64px;border-radius:14px;background:linear-gradient(135deg,#FEF3C7,#FDE68A);display:flex;align-items:center;justify-content:center;color:#D97706;flex-shrink:0;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                </div>
            @endif
            <div>
                <h2 style="font-size:18px;font-weight:700;color:#1F2937;margin:0 0 4px 0;">{{ $item->nama_item }}</h2>
                <p style="font-size:13px;color:#6B7280;margin:0;">{{ $item->id_item }} &mdash; Stok: {{ $item->stok_item }} pcs &mdash; Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('item.update', $item->id_item) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="master-form-grid">
                <div class="master-form-group">
                    <label class="master-form-label">ID Item</label>
                    <input type="text" class="master-form-input" value="{{ $item->id_item }}" readonly>
                    <span class="master-form-hint">ID tidak dapat diubah</span>
                </div>

                <div class="master-form-group">
                    <label class="master-form-label">Nama Item <span class="required">*</span></label>
                    <input type="text" name="nama_item"
                        class="master-form-input {{ $errors->has('nama_item') ? 'is-invalid' : '' }}"
                        value="{{ old('nama_item', $item->nama_item) }}"
                        placeholder="Nama item">
                    @error('nama_item')<span class="master-error-text"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                </div>

                <div class="master-form-group">
                    <label class="master-form-label">Stok Item <span class="required">*</span></label>
                    <input type="number" name="stok_item" min="0"
                        class="master-form-input {{ $errors->has('stok_item') ? 'is-invalid' : '' }}"
                        value="{{ old('stok_item', $item->stok_item) }}"
                        placeholder="Jumlah stok">
                    @error('stok_item')<span class="master-error-text"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                </div>

                <div class="master-form-group">
                    <label class="master-form-label">Harga Jual <span class="required">*</span></label>
                    <input type="text" name="harga"
                        class="master-form-input {{ $errors->has('harga') ? 'is-invalid' : '' }}"
                        value="{{ old('harga', $item->harga) }}"
                        placeholder="Contoh: 150000">
                    @error('harga')<span class="master-error-text"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                </div>

                <div class="master-form-group">
                    <label class="master-form-label">Harga Modal <span style="font-size: 11px; font-weight: normal; color: #6B7280;">(Opsional)</span></label>
                    <input type="text" name="harga_modal"
                        class="master-form-input {{ $errors->has('harga_modal') ? 'is-invalid' : '' }}"
                        value="{{ old('harga_modal', $item->harga_modal) }}"
                        placeholder="Contoh: 100000">
                    @error('harga_modal')<span class="master-error-text"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                </div>

                <div class="master-form-group master-form-grid-full">
                    <label class="master-form-label">Ganti Gambar Item</label>
                    <label class="master-file-upload-area" for="gambarInputEdit">
                        <input type="file" name="gambar" id="gambarInputEdit" accept="image/*" onchange="previewEditImage(this)">
                        <div id="editUploadPlaceholder">
                            <div class="master-file-upload-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                            @if($item->gambar)
                                <div class="master-file-upload-text">Klik untuk ganti gambar</div>
                                <div class="master-file-upload-hint">Gambar saat ini: {{ $item->gambar }}</div>
                            @else
                                <div class="master-file-upload-text">Klik untuk pilih gambar</div>
                                <div class="master-file-upload-hint">Format: JPG, PNG, GIF — Maks. 2MB</div>
                            @endif
                        </div>
                        <img id="editImagePreview" src="" alt="Preview" class="master-img-preview" style="display:none;">
                    </label>
                    @error('gambar')<span class="master-error-text"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>{{ $message }}</span>@enderror
                    <span class="master-form-hint">Kosongkan jika tidak ingin mengubah gambar</span>
                </div>
            </div>

            <div class="master-form-actions">
                <button type="submit" class="master-btn-submit" style="background:linear-gradient(135deg,#F59E0B,#D97706);box-shadow:0 4px 14px rgba(245,158,11,0.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Perubahan
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
function previewEditImage(input) {
    const preview = document.getElementById('editImagePreview');
    const placeholder = document.getElementById('editUploadPlaceholder');
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

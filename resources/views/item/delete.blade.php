@extends('layouts.app')

@section('content')
<div class="master-container">
    <div class="master-page-header">
        <div class="master-header-left">
            <div class="master-breadcrumb">
                <a href="{{ route('item.index') }}" style="color:#9CA3AF;text-decoration:none;">Master Item</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                <span class="master-breadcrumb-active" style="color:#EF4444;">Hapus Item</span>
            </div>
            <h1 class="master-page-title">
                <div class="master-title-icon" style="background: linear-gradient(135deg, #EF4444, #DC2626);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                </div>
                Konfirmasi Hapus
            </h1>
            <p class="master-page-subtitle">Tindakan ini tidak dapat dibatalkan</p>
        </div>
    </div>

    <div class="master-delete-card">
        <div class="master-delete-header">
            <div class="master-delete-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
            </div>
            <div>
                <h2>Hapus Data Item?</h2>
                <p>Anda akan menghapus data item berikut dari sistem.</p>
            </div>
        </div>

        {{-- Item preview --}}
        @if($item->gambar)
        <div style="display:flex;align-items:center;gap:16px;padding:16px;background:#FFFBEB;border-radius:12px;margin-bottom:20px;border:1px solid #FDE68A;">
            <img src="{{ asset('images/items/' . $item->gambar) }}" alt="{{ $item->nama_item }}"
                style="width:72px;height:72px;object-fit:cover;border-radius:10px;border:2px solid #FDE68A;">
            <div>
                <div style="font-weight:700;color:#1F2937;font-size:15px;">{{ $item->nama_item }}</div>
                <div style="font-size:13px;color:#6B7280;margin-top:4px;">{{ $item->id_item }}</div>
            </div>
        </div>
        @endif

        <div class="master-delete-detail">
            <div class="master-delete-row">
                <span class="master-delete-key">ID Item</span>
                <span class="master-delete-val"><span class="master-id-badge" style="color:#D97706;background:#FFFBEB;border-color:#FDE68A;">{{ $item->id_item }}</span></span>
            </div>
            <div class="master-delete-row">
                <span class="master-delete-key">Nama Item</span>
                <span class="master-delete-val">{{ $item->nama_item }}</span>
            </div>
            <div class="master-delete-row">
                <span class="master-delete-key">Stok Item</span>
                <span class="master-delete-val">{{ $item->stok_item }} pcs</span>
            </div>
            <div class="master-delete-row">
                <span class="master-delete-key">Harga</span>
                <span class="master-delete-val" style="font-weight:700;">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="master-delete-warning">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            Data yang dihapus tidak dapat dikembalikan. Pastikan Anda telah memilih data yang tepat.
        </div>

        <div class="master-delete-actions">
            <form action="{{ route('item.destroy', $item->id_item) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="master-btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    Ya, Hapus Sekarang
                </button>
            </form>
            <a href="{{ route('item.index') }}" class="master-btn-cancel">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Batal
            </a>
        </div>
    </div>
</div>
@include('partials.master-styles')
@endsection

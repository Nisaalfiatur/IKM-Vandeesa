@extends('layouts.app')

@section('content')
<div class="master-container">
    <div class="master-page-header">
        <div class="master-header-left">
            <div class="master-breadcrumb">
                <a href="{{ route('reseller.index') }}">Reseller</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                <span class="master-breadcrumb-active">Konfirmasi Hapus</span>
            </div>
            <h1 class="master-page-title">Hapus Reseller</h1>
            <p class="master-page-subtitle">Penghapusan data mitra reseller permanen</p>
        </div>
    </div>

    <div class="master-delete-card">
        <div class="master-delete-header">
            <div class="master-delete-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
            </div>
            <div>
                <h2>Hapus Data Reseller?</h2>
                <p>Anda akan menghapus data reseller berikut dari sistem secara permanen.</p>
            </div>
        </div>

        <div class="master-delete-detail">
            <div class="master-delete-row">
                <div class="master-delete-key">ID Reseller</div>
                <div class="master-delete-val"><span class="master-id-badge">{{ $reseller->id_reseller }}</span></div>
            </div>
            <div class="master-delete-row">
                <div class="master-delete-key">Nama Reseller</div>
                <div class="master-delete-val" style="font-weight: 600;">{{ $reseller->nama }}</div>
            </div>
            <div class="master-delete-row">
                <div class="master-delete-key">Nama Brand</div>
                <div class="master-delete-val" style="color: #059669; font-weight: 600;">🏷️ {{ $reseller->nama_brand }}</div>
            </div>
            <div class="master-delete-row">
                <div class="master-delete-key">Email</div>
                <div class="master-delete-val">{{ $reseller->email }}</div>
            </div>
        </div>

        <div class="master-delete-warning" style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; background: #FEF3C7; border-radius: 10px; margin-bottom: 24px; border: 1px solid #FDE68A; font-size: 13px; color: #92400E; font-weight: 500;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            <span>Tindakan ini tidak dapat dibatalkan. Seluruh data terkait reseller ini akan terhapus.</span>
        </div>

        <form method="POST" action="{{ route('reseller.destroy', $reseller->id_reseller) }}">
            @csrf
            @method('DELETE')

            <div class="master-actions">
                <button type="submit" class="master-btn-submit" style="background: linear-gradient(135deg, #EF4444, #DC2626); box-shadow: 0 4px 14px rgba(239, 68, 68, 0.35);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    Ya, Hapus Data
                </button>
                <a href="{{ route('reseller.index') }}" class="master-btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>

@include('partials.master-styles')
@endsection

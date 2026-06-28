@extends('layouts.app')

@section('content')
<div class="master-container">
    <div class="master-page-header">
        <div class="master-header-left">
            <div class="master-breadcrumb">
                <a href="{{ route('member.index') }}" style="color:#9CA3AF;text-decoration:none;">Master Member</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                <span class="master-breadcrumb-active" style="color:#EF4444;">Hapus Member</span>
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
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <div>
                <h2>Hapus Data Member?</h2>
                <p>Anda akan menghapus data member berikut dari sistem.</p>
            </div>
        </div>

        <div class="master-delete-detail">
            <div class="master-delete-row">
                <span class="master-delete-key">ID Member</span>
                <span class="master-delete-val"><span class="master-id-badge" style="color:#7C3AED;background:#EDE9FE;border-color:#C4B5FD;">{{ $member->id_member }}</span></span>
            </div>
            <div class="master-delete-row">
                <span class="master-delete-key">Nama</span>
                <span class="master-delete-val">{{ $member->nama }}</span>
            </div>
            <div class="master-delete-row">
                <span class="master-delete-key">Kategori</span>
                <span class="master-delete-val">
                    @if(strtolower($member->kategori)==='online')
                        <span class="master-kategori-online">🌐 Online</span>
                    @else
                        <span class="master-kategori-offline">🏪 Offline</span>
                    @endif
                </span>
            </div>
            <div class="master-delete-row">
                <span class="master-delete-key">Email</span>
                <span class="master-delete-val">{{ $member->email ?: '-' }}</span>
            </div>

        </div>

        <div class="master-delete-warning">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            Data yang dihapus tidak dapat dikembalikan. Pastikan Anda telah memilih data yang tepat.
        </div>

        <div class="master-delete-actions">
            <form method="POST" action="{{ route('member.destroy', $member->id_member) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="master-btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    Ya, Hapus Sekarang
                </button>
            </form>
            <a href="{{ route('member.index') }}" class="master-btn-cancel">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Batal
            </a>
        </div>
    </div>
</div>
@include('partials.master-styles')
@endsection

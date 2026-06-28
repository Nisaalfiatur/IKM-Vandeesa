@extends('layouts.app')

@section('content')
<div class="master-container">

    {{-- Page Header --}}
    <div class="master-page-header">
        <div class="master-header-left">
            <div class="master-breadcrumb">
                <span>Master Data</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                <span class="master-breadcrumb-active">Pelanggan</span>
            </div>
            <h1 class="master-page-title">
                <div class="master-title-icon" style="background: linear-gradient(135deg, #10B981, #059669);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                Master Pelanggan
            </h1>
            <p class="master-page-subtitle">Kelola data seluruh pelanggan perusahaan</p>
        </div>
        <a href="{{ route('pelanggan.create') }}" class="master-btn-create" style="background: linear-gradient(135deg, #10B981, #059669); box-shadow: 0 4px 14px rgba(16,185,129,0.35);">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Pelanggan
        </a>
    </div>

    @if(session('success'))
    <div class="master-alert master-alert-success" id="masterAlert">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.style.display='none'" class="master-alert-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>
    @endif

    {{-- Stats --}}
    <div class="master-stats-row">
        <div class="master-stat-card" style="--accent: #10B981;">
            <div class="master-stat-icon" style="background: linear-gradient(135deg, #DCFCE7, #BBF7D0); color: #10B981;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <div class="master-stat-number">{{ count($pelanggan) }}</div>
                <div class="master-stat-label">Total Pelanggan</div>
            </div>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="master-card master-filter-card">
        <div class="master-filter-bar">
            <div class="master-search-box">
                <svg class="master-search-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="masterSearchInput" class="master-search-input" placeholder="Cari nama pelanggan atau no telepon..." autocomplete="off">
                <button type="button" id="masterClearSearch" class="master-clear-btn" style="display:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="master-result-count">
                <span id="masterResultCount">{{ count($pelanggan) }}</span> data ditemukan
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="master-card master-table-card">
        @if(count($pelanggan) > 0)
        <div class="master-table-responsive">
            <table class="master-table" id="masterTable">
                <thead>
                    <tr>
                        <th style="width:52px;">No</th>
                        <th>ID Pelanggan</th>
                        <th>Nama</th>
                        <th>No Telepon</th>
                        <th style="width:140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pelanggan as $p)
                    <tr class="master-row" data-search="{{ strtolower($p->id_pelanggan . ' ' . $p->nama . ' ' . $p->no_telpn) }}">
                        <td class="master-row-num">{{ $loop->iteration }}</td>
                        <td><span class="master-id-badge" style="color:#10B981;background:#F0FDF4;border-color:#BBF7D0;">{{ $p->id_pelanggan }}</span></td>
                        <td>
                            <div class="master-entity-info">
                                <div class="master-avatar" style="background: linear-gradient(135deg, #10B981, #059669);">
                                    {{ strtoupper(substr($p->nama, 0, 1)) }}
                                </div>
                                <span class="master-entity-name">{{ $p->nama }}</span>
                            </div>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px;color:#6B7280;font-size:13.5px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.41 2 2 0 0 1 3.6 1.21h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 9a16 16 0 0 0 6.06 6.06l.9-.9a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 21.79 17z"/></svg>
                                {{ $p->no_telpn ?: '-' }}
                            </div>
                        </td>
                        <td>
                            <div class="master-actions">
                                <a href="{{ route('pelanggan.edit', $p->id_pelanggan) }}" class="master-btn-action master-btn-edit" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                @if(auth()->user()->role === 'admin')
                                <a href="{{ route('pelanggan.delete', $p->id_pelanggan) }}" class="master-btn-action master-btn-delete" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="master-empty-state">
            <div class="master-empty-icon" style="background: linear-gradient(135deg,#DCFCE7,#BBF7D0); color:#10B981;">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <h3>Belum Ada Data Pelanggan</h3>
            <p>Mulai tambahkan data pelanggan pertama Anda.</p>
            <a href="{{ route('pelanggan.create') }}" class="master-btn-create" style="margin-top:16px;background:linear-gradient(135deg,#10B981,#059669);box-shadow:0 4px 14px rgba(16,185,129,0.35);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Pelanggan
            </a>
        </div>
        @endif

        <div class="master-no-results" id="masterNoResults" style="display:none;">
            <div class="master-empty-icon"><svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="8" y1="11" x2="14" y2="11"/></svg></div>
            <h3>Tidak Ada Hasil</h3>
            <p>Tidak ditemukan data yang sesuai dengan pencarian Anda.</p>
        </div>
    </div>
</div>

@include('partials.master-styles')
<script>
(function(){
    const si=document.getElementById('masterSearchInput'),cl=document.getElementById('masterClearSearch'),rc=document.getElementById('masterResultCount'),nr=document.getElementById('masterNoResults'),rows=document.querySelectorAll('.master-row');
    function f(){const q=si.value.toLowerCase().trim();cl.style.display=q?'flex':'none';let v=0;rows.forEach(r=>{const m=r.dataset.search.includes(q);r.style.display=m?'':'none';if(m)v++;});rc.textContent=v;nr.style.display=(v===0&&rows.length>0)?'flex':'none';let n=1;rows.forEach(r=>{if(r.style.display!=='none')r.querySelector('.master-row-num').textContent=n++;});}
    si.addEventListener('input',f);cl.addEventListener('click',()=>{si.value='';f();si.focus();});
    const a=document.getElementById('masterAlert');if(a)setTimeout(()=>{a.style.opacity='0';setTimeout(()=>a.style.display='none',400);},4000);
})();
</script>
@endsection

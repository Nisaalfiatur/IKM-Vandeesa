@extends('layouts.app')

@section('content')
<div class="master-container">

    <div class="master-page-header">
        <div class="master-header-left">
            <div class="master-breadcrumb">
                <span>Master Data</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                <span class="master-breadcrumb-active">Member</span>
            </div>
            <h1 class="master-page-title">
                <div class="master-title-icon" style="background: linear-gradient(135deg, #8B5CF6, #7C3AED);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
                Master Member
            </h1>
            <p class="master-page-subtitle">Kelola data member & program loyalitas</p>
        </div>
        <a href="{{ route('member.create') }}" class="master-btn-create" style="background:linear-gradient(135deg,#8B5CF6,#7C3AED);box-shadow:0 4px 14px rgba(139,92,246,0.35);">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Member
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
        <div class="master-stat-card" style="--accent:#8B5CF6;">
            <div class="master-stat-icon" style="background:linear-gradient(135deg,#EDE9FE,#DDD6FE);color:#7C3AED;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <div>
                <div class="master-stat-number">{{ count($members) }}</div>
                <div class="master-stat-label">Total Member</div>
            </div>
        </div>
        <div class="master-stat-card" style="--accent:#3B82F6;">
            <div class="master-stat-icon" style="background:linear-gradient(135deg,#EFF6FF,#DBEAFE);color:#2563EB;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2.05 6.41A10.09 10.09 0 0 1 12 2a10 10 0 0 1 9.95 8.59"/><path d="M2.05 17.59A10.09 10.09 0 0 0 12 22a10 10 0 0 0 9.95-8.59"/></svg>
            </div>
            <div>
                <div class="master-stat-number">{{ $members->where('kategori', 'online')->count() }}</div>
                <div class="master-stat-label">Member Online</div>
            </div>
        </div>
        <div class="master-stat-card" style="--accent:#F59E0B;">
            <div class="master-stat-icon" style="background:linear-gradient(135deg,#FEF3C7,#FDE68A);color:#D97706;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            </div>
            <div>
                <div class="master-stat-number">{{ $members->where('kategori', 'offline')->count() }}</div>
                <div class="master-stat-label">Member Offline</div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="master-card master-filter-card">
        <div class="master-filter-bar">
            <div class="master-search-box">
                <svg class="master-search-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="masterSearchInput" class="master-search-input" placeholder="Cari nama, email, atau telepon..." autocomplete="off">
                <button type="button" id="masterClearSearch" class="master-clear-btn" style="display:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="master-filter-select-wrap">
                <svg class="master-filter-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                <select id="kategoriFilter" class="master-filter-select">
                    <option value="">Semua Kategori</option>
                    <option value="online">Online</option>
                    <option value="offline">Offline</option>
                </select>
            </div>
            <div class="master-result-count">
                <span id="masterResultCount">{{ count($members) }}</span> member ditemukan
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="master-card master-table-card">
        @if(count($members) > 0)
        <div class="master-table-responsive">
            <table class="master-table" id="masterTable">
                <thead>
                    <tr>
                        <th style="width:52px;">No</th>
                        <th>ID Member</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>No Telepon</th>
                        <th>Email</th>
                        <th>Tgl Daftar</th>

                        <th style="width:140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                    <tr class="master-row"
                        data-search="{{ strtolower($member->id_member . ' ' . $member->nama . ' ' . $member->email . ' ' . $member->no_telp) }}"
                        data-kategori="{{ strtolower($member->kategori) }}">
                        <td class="master-row-num">{{ $loop->iteration }}</td>
                        <td><span class="master-id-badge" style="color:#7C3AED;background:#EDE9FE;border-color:#C4B5FD;">{{ $member->id_member }}</span></td>
                        <td>
                            <div class="master-entity-info">
                                <div class="master-avatar" style="background:linear-gradient(135deg,#8B5CF6,#7C3AED);">
                                    {{ strtoupper(substr($member->nama, 0, 1)) }}
                                </div>
                                <span class="master-entity-name">{{ $member->nama }}</span>
                            </div>
                        </td>
                        <td>
                            @if(strtolower($member->kategori) === 'online')
                                <span class="master-kategori-online">🌐 Online</span>
                            @else
                                <span class="master-kategori-offline">🏪 Offline</span>
                            @endif
                        </td>
                        <td style="color:#6B7280;font-size:13.5px;">{{ $member->no_telp ?: '-' }}</td>
                        <td style="color:#6B7280;font-size:13.5px;">{{ $member->email ?: '-' }}</td>
                        <td style="color:#6B7280;font-size:13.5px;">
                            {{ $member->tgl_daftar ? \Carbon\Carbon::parse($member->tgl_daftar)->format('d M Y') : '-' }}
                        </td>

                        <td>
                            <div class="master-actions">
                                <a href="{{ route('member.edit', $member->id_member) }}" class="master-btn-action master-btn-edit" title="Edit Member">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <a href="{{ route('member.delete', $member->id_member) }}" class="master-btn-action master-btn-delete" title="Hapus Member">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="master-empty-state">
            <div class="master-empty-icon" style="background:linear-gradient(135deg,#EDE9FE,#DDD6FE);color:#7C3AED;">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <h3>Belum Ada Data Member</h3>
            <p>Mulai tambahkan member pertama Anda.</p>
            <a href="{{ route('member.create') }}" class="master-btn-create" style="margin-top:16px;background:linear-gradient(135deg,#8B5CF6,#7C3AED);box-shadow:0 4px 14px rgba(139,92,246,0.35);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Member
            </a>
        </div>
        @endif

        <div class="master-no-results" id="masterNoResults" style="display:none;">
            <div class="master-empty-icon"><svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="8" y1="11" x2="14" y2="11"/></svg></div>
            <h3>Tidak Ada Hasil</h3>
            <p>Tidak ditemukan member yang sesuai dengan filter Anda.</p>
        </div>
    </div>
</div>

@include('partials.master-styles')
<script>
(function(){
    const si=document.getElementById('masterSearchInput'),cl=document.getElementById('masterClearSearch'),rc=document.getElementById('masterResultCount'),nr=document.getElementById('masterNoResults'),rows=document.querySelectorAll('.master-row'),kf=document.getElementById('kategoriFilter');
    function f(){
        const q=si.value.toLowerCase().trim(),kv=kf.value.toLowerCase();
        cl.style.display=q?'flex':'none';
        let v=0;
        rows.forEach(r=>{
            const ms=r.dataset.search.includes(q),mk=!kv||r.dataset.kategori===kv,show=ms&&mk;
            r.style.display=show?'':'none';
            if(show)v++;
        });
        rc.textContent=v;
        nr.style.display=(v===0&&rows.length>0)?'flex':'none';
        let n=1;rows.forEach(r=>{if(r.style.display!=='none')r.querySelector('.master-row-num').textContent=n++;});
    }
    si.addEventListener('input',f);kf.addEventListener('change',f);
    cl.addEventListener('click',()=>{si.value='';f();si.focus();});
    const a=document.getElementById('masterAlert');if(a)setTimeout(()=>{a.style.opacity='0';setTimeout(()=>a.style.display='none',400);},4000);
})();
</script>
@endsection

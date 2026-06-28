@extends('layouts.app')

@section('content')
<div class="master-container">

    {{-- Page Header --}}
    <div class="master-page-header">
        <div class="master-header-left">
            <div class="master-breadcrumb">
                <span>Master Data</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                <span class="master-breadcrumb-active">Pegawai</span>
            </div>
            <h1 class="master-page-title">
                <div class="master-title-icon" style="background: linear-gradient(135deg, #4F46E5, #6366F1);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                Master Pegawai
            </h1>
            <p class="master-page-subtitle">Kelola data seluruh pegawai perusahaan</p>
        </div>
        <a href="{{ route('pegawai.create') }}" class="master-btn-create">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Pegawai
        </a>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
    <div class="master-alert master-alert-success" id="masterAlert">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.style.display='none'" class="master-alert-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>
    @endif

    {{-- Stats Cards --}}
    <div class="master-stats-row">
        <div class="master-stat-card" style="--accent: #4F46E5;">
            <div class="master-stat-icon" style="background: linear-gradient(135deg, #E0E7FF, #C7D2FE); color: #4F46E5;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <div class="master-stat-number">{{ count($pegawai) }}</div>
                <div class="master-stat-label">Total Pegawai</div>
            </div>
        </div>
    </div>

    {{-- Search & Filter --}}
    <div class="master-card master-filter-card">
        <div class="master-filter-bar">
            <div class="master-search-box">
                <svg class="master-search-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="masterSearchInput" class="master-search-input" placeholder="Cari nama pegawai atau jabatan..." autocomplete="off">
                <button type="button" id="masterClearSearch" class="master-clear-btn" style="display:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="master-result-count">
                <span id="masterResultCount">{{ count($pegawai) }}</span> data ditemukan
            </div>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="master-card master-table-card">
        @if(count($pegawai) > 0)
        <div class="master-table-responsive">
            <table class="master-table" id="masterTable">
                <thead>
                    <tr>
                        <th style="width:52px;">No</th>
                        <th>ID Pegawai</th>
                        <th>Nama Pegawai</th>
                        <th>Jabatan</th>
                        <th style="width:140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pegawai as $pg)
                    <tr class="master-row"
                        data-search="{{ strtolower($pg->id_pegawai . ' ' . $pg->nama_pg . ' ' . $pg->jabatan) }}">
                        <td class="master-row-num">{{ $loop->iteration }}</td>
                        <td>
                            <span class="master-id-badge">{{ $pg->id_pegawai }}</span>
                        </td>
                        <td>
                            <div class="master-entity-info">
                                <div class="master-avatar" style="background: linear-gradient(135deg, #4F46E5, #6366F1);">
                                    {{ strtoupper(substr($pg->nama_pg, 0, 1)) }}
                                </div>
                                <span class="master-entity-name">{{ $pg->nama_pg }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="master-role-badge">{{ $pg->jabatan }}</span>
                        </td>
                        <td>
                            <div class="master-actions">
                                <a href="{{ route('pegawai.edit', $pg->id_pegawai) }}" class="master-btn-action master-btn-edit" title="Edit Pegawai">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <a href="{{ route('pegawai.delete', $pg->id_pegawai) }}" class="master-btn-action master-btn-delete" title="Hapus Pegawai">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
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
            <div class="master-empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <h3>Belum Ada Data Pegawai</h3>
            <p>Mulai tambahkan data pegawai pertama Anda.</p>
            <a href="{{ route('pegawai.create') }}" class="master-btn-create" style="margin-top: 16px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Pegawai
            </a>
        </div>
        @endif

        <div class="master-no-results" id="masterNoResults" style="display:none;">
            <div class="master-empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
            </div>
            <h3>Tidak Ada Hasil</h3>
            <p>Tidak ditemukan data yang sesuai dengan pencarian Anda.</p>
        </div>
    </div>
</div>

@include('partials.master-styles')

<script>
(function() {
    const searchInput = document.getElementById('masterSearchInput');
    const clearBtn    = document.getElementById('masterClearSearch');
    const resultCount = document.getElementById('masterResultCount');
    const noResults   = document.getElementById('masterNoResults');
    const rows        = document.querySelectorAll('.master-row');

    function filterTable() {
        const q = searchInput.value.toLowerCase().trim();
        clearBtn.style.display = q ? 'flex' : 'none';
        let visible = 0;
        rows.forEach(row => {
            const match = row.dataset.search.includes(q);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        resultCount.textContent = visible;
        noResults.style.display = (visible === 0 && rows.length > 0) ? 'flex' : 'none';
        // Re-number visible rows
        let n = 1;
        rows.forEach(row => { if (row.style.display !== 'none') { row.querySelector('.master-row-num').textContent = n++; } });
    }

    searchInput.addEventListener('input', filterTable);
    clearBtn.addEventListener('click', () => { searchInput.value = ''; filterTable(); searchInput.focus(); });

    // Auto-dismiss alert
    const alert = document.getElementById('masterAlert');
    if (alert) setTimeout(() => { alert.style.opacity = '0'; setTimeout(() => alert.style.display = 'none', 400); }, 4000);
})();
</script>
@endsection

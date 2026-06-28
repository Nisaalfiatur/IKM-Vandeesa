@extends('layouts.app')

@section('content')
<div class="master-container">

    {{-- Page Header --}}
    <div class="master-page-header">
        <div class="master-header-left">
            <div class="master-breadcrumb">
                <span>Transaksi</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                <span class="master-breadcrumb-active">Invoice</span>
            </div>
            <h1 class="master-page-title">
                <div class="master-title-icon" style="background: linear-gradient(135deg, #7C5CDB, #6B46C1);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                </div>
                Daftar Invoice
            </h1>
            <p class="master-page-subtitle">Kelola dan pantau seluruh transaksi invoice penjualan</p>
        </div>
        <a href="{{ route('invoice.create') }}" class="master-btn-create" style="background: linear-gradient(135deg, #7C5CDB, #6B46C1); box-shadow: 0 4px 14px rgba(124, 92, 219, 0.35);">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Buat Invoice Baru
        </a>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
    <div class="master-alert master-alert-success" id="masterAlert" style="background: linear-gradient(135deg, #F5F3FF, #EDE9FE); color: #6B46C1; border-left: 4px solid #7C5CDB;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.style.display='none'" class="master-alert-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>
    @endif

    {{-- Stats Cards --}}
    <div class="master-stats-row">
        <div class="master-stat-card" style="--accent: #7C5CDB;">
            <div class="master-stat-icon" style="background: linear-gradient(135deg, #EDE9FE, #DDD6FE); color: #6B46C1;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
                <div class="master-stat-number">{{ count($invoices) }}</div>
                <div class="master-stat-label">Total Invoice</div>
            </div>
        </div>
        <div class="master-stat-card" style="--accent: #10B981;">
            <div class="master-stat-icon" style="background: linear-gradient(135deg, #D1FAE5, #A7F3D0); color: #059669;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div>
                <div class="master-stat-number" style="font-size: 20px; font-weight: 800; padding-top: 4px;">
                    Rp {{ number_format($invoices->sum('total_harga'), 0, ',', '.') }}
                </div>
                <div class="master-stat-label">Akumulasi Omset</div>
            </div>
        </div>
    </div>

    {{-- Search & Filter --}}
    <div class="master-card master-filter-card">
        <div class="master-filter-bar">
            <div class="master-search-box">
                <svg class="master-search-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="masterSearchInput" class="master-search-input" placeholder="Cari nomor invoice, pelanggan, kasir..." autocomplete="off">
                <button type="button" id="masterClearSearch" class="master-clear-btn" style="display:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="master-result-count">
                <span id="masterResultCount">{{ count($invoices) }}</span> data ditemukan
            </div>
        </div>
    </div>

    {{-- Data Table --}}
    <style>
        .master-table-card .master-table thead th {
            background: linear-gradient(135deg, #F5F3FF, #EDE9FE) !important;
            color: #4C1D95 !important;
            border-bottom: 2px solid #E9D5FF !important;
        }
        .master-table-card .master-table tbody tr:hover {
            background: #FAFAFF !important;
        }
    </style>
    <div class="master-card master-table-card">
        @if(count($invoices) > 0)
        <div class="master-table-responsive">
            <table class="master-table" id="masterTable">
                <thead>
                    <tr>
                        <th style="width:52px;">No</th>
                        <th>No Invoice</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th style="text-align: right;">Total Harga</th>
                        <th>Kasir</th>
                        <th style="width:180px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                    <tr class="master-row"
                        data-search="{{ strtolower($invoice->no_invoice . ' ' . ($invoice->pelanggan->nama ?? 'n/a') . ' ' . ($invoice->kasir->nama_pg ?? 'n/a')) }}">
                        <td class="master-row-num">{{ $loop->iteration }}</td>
                        <td>
                            <span class="master-id-badge" style="color: #7C5CDB; background: #F5F3FF; border-color: #DDD6FE;">
                                {{ $invoice->no_invoice }}
                            </span>
                        </td>
                        <td>
                            <div class="master-entity-info">
                                <div class="master-avatar" style="background: linear-gradient(135deg, #E0E7FF, #C7D2FE); color: #4F46E5;">
                                    👤
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                    <span class="master-entity-name">
                                        @if($invoice->pelanggan)
                                            {{ $invoice->pelanggan->nama }}
                                        @elseif($invoice->member)
                                            {{ $invoice->member->nama }}
                                        @elseif($invoice->reseller)
                                            {{ $invoice->reseller->nama }}
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                    <div>
                                        @if($invoice->pelanggan)
                                            <span style="background: #F3F4F6; color: #4B5563; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 700; letter-spacing: 0.5px;">UMUM</span>
                                        @elseif($invoice->member)
                                            <span style="background: #DBEAFE; color: #1D4ED8; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 700; letter-spacing: 0.5px;">MEMBER</span>
                                        @elseif($invoice->reseller)
                                            <span style="background: #D1FAE5; color: #047857; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 700; letter-spacing: 0.5px;">RESELLER</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="font-size: 13.5px; color: #4B5563; white-space: nowrap;">
                                📅 {{ \Carbon\Carbon::parse($invoice->tanggal)->format('d M Y') }}
                            </span>
                        </td>
                        <td style="text-align: right; font-weight: 700; color: #7C5CDB; font-size: 14.5px;">
                            Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}
                        </td>
                        <td>
                            <span class="master-role-badge" style="background: linear-gradient(135deg, #ECFEFF, #CFFAFE); color: #0891B2; border-color: #A5F3FC;">
                                👩‍💻 {{ $invoice->kasir->nama_pg ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            <div class="master-actions" style="justify-content: center; gap: 8px;">
                                <a href="{{ route('invoice.show', $invoice->no_invoice) }}" class="master-btn-action master-btn-edit" title="Lihat Detail" style="color: #4F46E5; border-color: #C7D2FE; background: #EEF2FF;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                                <a href="{{ route('invoice.print', $invoice->no_invoice) }}" class="master-btn-action" title="Cetak" target="_blank" style="color: #7C5CDB; border-color: #DDD6FE; background: #F5F3FF;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                                </a>
                                <a href="{{ route('invoice.edit', $invoice->no_invoice) }}" class="master-btn-action" title="Edit" style="color: #D97706; border-color: #FDE68A; background: #FEF3C7;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                @if(auth()->user()->role === 'admin')
                                <a href="{{ route('invoice.delete', $invoice->no_invoice) }}" class="master-btn-action master-btn-delete" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
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
            <div class="master-empty-icon" style="background: linear-gradient(135deg, #F5F3FF, #EDE9FE); color: #7C5CDB;">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>
            </div>
            <h3>Belum Ada Invoice</h3>
            <p>Mulai buat lembar invoice penjualan pertama Anda.</p>
            <a href="{{ route('invoice.create') }}" class="master-btn-create" style="margin-top: 16px; background: linear-gradient(135deg, #7C5CDB, #6B46C1);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Buat Invoice
            </a>
        </div>
        @endif

        <div class="master-no-results" id="masterNoResults" style="display:none;">
            <div class="master-empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
            </div>
            <h3>Tidak Ada Hasil</h3>
            <p>Tidak ditemukan invoice yang sesuai dengan kriteria pencarian Anda.</p>
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

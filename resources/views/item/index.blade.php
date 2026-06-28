@extends('layouts.app')

@section('content')
<div class="master-container">

    {{-- Page Header --}}
    <div class="master-page-header">
        <div class="master-header-left">
            <div class="master-breadcrumb">
                <span>Master Data</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                <span class="master-breadcrumb-active">Item</span>
            </div>
            <h1 class="master-page-title">
                <div class="master-title-icon" style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                </div>
                Master Item
            </h1>
            <p class="master-page-subtitle">Kelola katalog produk & stok item</p>
        </div>
        <a href="{{ route('item.create') }}" class="master-btn-create" style="background:linear-gradient(135deg,#F59E0B,#D97706);box-shadow:0 4px 14px rgba(245,158,11,0.35);">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Item
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

    @if(session('error'))
    <div class="master-alert master-alert-error" id="masterAlertError" style="background-color: #FEE2E2; border: 1px solid #FECACA; color: #DC2626;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span>{{ session('error') }}</span>
        <button onclick="this.parentElement.style.display='none'" class="master-alert-close" style="color: #DC2626; opacity: 0.8;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>
    @endif

    {{-- Stats --}}
    <div class="master-stats-row">
        <div class="master-stat-card" style="--accent:#F59E0B;">
            <div class="master-stat-icon" style="background:linear-gradient(135deg,#FEF3C7,#FDE68A);color:#D97706;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
            </div>
            <div>
                <div class="master-stat-number">{{ count($items) }}</div>
                <div class="master-stat-label">Total Item</div>
            </div>
        </div>
        <div class="master-stat-card" style="--accent:#10B981;">
            <div class="master-stat-icon" style="background:linear-gradient(135deg,#DCFCE7,#BBF7D0);color:#10B981;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
            </div>
            <div>
                <div class="master-stat-number">{{ $items->sum('stok_item') }}</div>
                <div class="master-stat-label">Total Stok</div>
            </div>
        </div>
        <div class="master-stat-card" style="--accent:#EF4444;">
            <div class="master-stat-icon" style="background:linear-gradient(135deg,#FEE2E2,#FECACA);color:#EF4444;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <div>
                <div class="master-stat-number">{{ $items->where('stok_item', '<=', 5)->count() }}</div>
                <div class="master-stat-label">Stok Rendah</div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="master-card master-filter-card">
        <div class="master-filter-bar">
            <div class="master-search-box">
                <svg class="master-search-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="masterSearchInput" class="master-search-input" placeholder="Cari nama item atau ID..." autocomplete="off">
                <button type="button" id="masterClearSearch" class="master-clear-btn" style="display:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="master-filter-select-wrap">
                <svg class="master-filter-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                <select id="stokFilter" class="master-filter-select">
                    <option value="">Semua Stok</option>
                    <option value="low">Stok Rendah (≤5)</option>
                    <option value="ok">Stok Aman (>5)</option>
                </select>
            </div>
            <div class="master-result-count">
                <span id="masterResultCount">{{ count($items) }}</span> item ditemukan
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="master-card master-table-card">
        @if(count($items) > 0)
        <div class="master-table-responsive">
            <table class="master-table" id="masterTable">
                <thead>
                    <tr>
                        <th style="width:52px;">No</th>
                        <th style="width:80px;">Gambar</th>
                        <th>ID Item</th>
                        <th>Nama Item</th>
                        <th style="width:110px;">Stok</th>
                        <th style="width:150px;">Harga</th>
                        <th style="width:140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr class="master-row"
                        data-search="{{ strtolower($item->id_item . ' ' . $item->nama_item) }}"
                        data-stok="{{ $item->stok_item }}">
                        <td class="master-row-num">{{ $loop->iteration }}</td>
                        <td>
                            @if($item->gambar)
                                <img src="{{ asset('images/items/' . $item->gambar) }}"
                                    alt="{{ $item->nama_item }}"
                                    style="width:54px;height:54px;object-fit:cover;border-radius:10px;border:2px solid #E5E7EB;">
                            @else
                                <div style="width:54px;height:54px;border-radius:10px;background:linear-gradient(135deg,#FEF3C7,#FDE68A);display:flex;align-items:center;justify-content:center;color:#D97706;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                </div>
                            @endif
                        </td>
                        <td><span class="master-id-badge" style="color:#D97706;background:#FFFBEB;border-color:#FDE68A;">{{ $item->id_item }}</span></td>
                        <td>
                            <span class="master-entity-name">{{ $item->nama_item }}</span>
                        </td>
                        <td>
                            @php $stokClass = $item->stok_item <= 5 ? 'stok-low' : 'stok-ok'; @endphp
                            <span class="master-stok-badge {{ $stokClass }}">
                                {{ $item->stok_item }} pcs
                            </span>
                        </td>
                        <td>
                            <span style="font-weight:700;color:#1F2937;font-size:14px;">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </span>
                        </td>
                        <td>
                            <div class="master-actions">
                                <a href="{{ route('item.edit', $item->id_item) }}" class="master-btn-action master-btn-edit" title="Edit Item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <a href="{{ route('item.delete', $item->id_item) }}" class="master-btn-action master-btn-delete" title="Hapus Item">
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
            <div class="master-empty-icon" style="background:linear-gradient(135deg,#FEF3C7,#FDE68A);color:#D97706;">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
            </div>
            <h3>Belum Ada Data Item</h3>
            <p>Mulai tambahkan produk pertama Anda ke katalog.</p>
            <a href="{{ route('item.create') }}" class="master-btn-create" style="margin-top:16px;background:linear-gradient(135deg,#F59E0B,#D97706);box-shadow:0 4px 14px rgba(245,158,11,0.35);">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Item
            </a>
        </div>
        @endif

        <div class="master-no-results" id="masterNoResults" style="display:none;">
            <div class="master-empty-icon"><svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="8" y1="11" x2="14" y2="11"/></svg></div>
            <h3>Tidak Ada Hasil</h3>
            <p>Tidak ditemukan item yang sesuai dengan filter Anda.</p>
        </div>
    </div>
</div>

@include('partials.master-styles')

<style>
    .master-stok-badge { display:inline-flex;align-items:center;padding:5px 12px;border-radius:20px;font-size:12.5px;font-weight:700; }
    .stok-low  { background:linear-gradient(135deg,#FEF2F2,#FEE2E2);color:#DC2626;border:1px solid #FECACA; }
    .stok-ok   { background:linear-gradient(135deg,#F0FDF4,#DCFCE7);color:#16A34A;border:1px solid #BBF7D0; }
</style>

<script>
(function(){
    const si=document.getElementById('masterSearchInput'),cl=document.getElementById('masterClearSearch'),rc=document.getElementById('masterResultCount'),nr=document.getElementById('masterNoResults'),rows=document.querySelectorAll('.master-row'),sf=document.getElementById('stokFilter');
    function f(){
        const q=si.value.toLowerCase().trim(),sv=sf.value;
        cl.style.display=q?'flex':'none';
        let v=0;
        rows.forEach(r=>{
            const ms=r.dataset.search.includes(q);
            const stok=parseInt(r.dataset.stok);
            const mf=!sv||(sv==='low'&&stok<=5)||(sv==='ok'&&stok>5);
            const show=ms&&mf;
            r.style.display=show?'':'none';
            if(show)v++;
        });
        rc.textContent=v;
        nr.style.display=(v===0&&rows.length>0)?'flex':'none';
        let n=1;rows.forEach(r=>{if(r.style.display!=='none')r.querySelector('.master-row-num').textContent=n++;});
    }
    si.addEventListener('input',f);sf.addEventListener('change',f);
    cl.addEventListener('click',()=>{si.value='';f();si.focus();});
    const a=document.getElementById('masterAlert');if(a)setTimeout(()=>{a.style.opacity='0';setTimeout(()=>a.style.display='none',400);},4000);
    const ea=document.getElementById('masterAlertError');if(ea)setTimeout(()=>{ea.style.opacity='0';setTimeout(()=>ea.style.display='none',400);},4000);
})();
</script>
@endsection

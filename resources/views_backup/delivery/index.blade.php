@extends('layouts.app')

@section('content')
<div class="delivery-container">
    {{-- Page Header --}}
    <div class="page-header-delivery">
        <div class="header-left">
            <h1 class="page-title-delivery">
                <span class="title-icon">🚚</span>
                Daftar Delivery Order
            </h1>
            <p class="page-subtitle-delivery">Kelola semua delivery order dengan mudah dan efisien</p>
        </div>
        <a href="{{ route('delivery.create') }}" class="btn btn-primary btn-create-delivery">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Buat DO Baru
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert-success alert-delivery-success">
            <div class="alert-icon-delivery">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <span>{{ session('success') }}</span>
            <button type="button" class="alert-close-delivery" onclick="this.parentElement.style.display='none'">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
    @endif

    {{-- Summary Stats Cards --}}
    <div class="stats-grid-delivery">
        <div class="stat-card-delivery stat-total">
            <div class="stat-icon-delivery">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
            </div>
            <div class="stat-info-delivery">
                <span class="stat-number-delivery">{{ $deliveries->count() }}</span>
                <span class="stat-label-delivery">Total DO</span>
            </div>
        </div>
        <div class="stat-card-delivery stat-waiting">
            <div class="stat-icon-delivery">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="stat-info-delivery">
                <span class="stat-number-delivery">{{ $deliveries->where('status', 'Menunggu')->count() }}</span>
                <span class="stat-label-delivery">Menunggu</span>
            </div>
        </div>
        <div class="stat-card-delivery stat-shipped">
            <div class="stat-icon-delivery">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
            </div>
            <div class="stat-info-delivery">
                <span class="stat-number-delivery">{{ $deliveries->where('status', 'Dikirim')->count() }}</span>
                <span class="stat-label-delivery">Dikirim</span>
            </div>
        </div>
        <div class="stat-card-delivery stat-completed">
            <div class="stat-icon-delivery">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="stat-info-delivery">
                <span class="stat-number-delivery">{{ $deliveries->where('status', 'Selesai')->count() }}</span>
                <span class="stat-label-delivery">Selesai</span>
            </div>
        </div>
    </div>

    {{-- Search & Filter Bar --}}
    <div class="card filter-card-delivery">
        <div class="filter-bar-delivery">
            <div class="search-box-delivery">
                <svg class="search-icon-delivery" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="searchInput" class="search-input-delivery" placeholder="Cari no DO, invoice, atau reseller..." autocomplete="off">
                <button type="button" id="clearSearch" class="clear-search-delivery" style="display:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="filter-select-wrapper-delivery">
                <svg class="filter-icon-delivery" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                <select id="statusFilter" class="filter-select-delivery">
                    <option value="">Semua Status</option>
                    <option value="Menunggu">Menunggu</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Dikirim">Dikirim</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Dibatalkan">Dibatalkan</option>
                </select>
            </div>
            <div class="filter-count-delivery">
                <span id="resultCount">{{ $deliveries->count() }}</span> data ditemukan
            </div>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="card table-card-delivery">
        @if($deliveries->count() > 0)
            <div class="table-responsive">
                <table class="table delivery-table" id="deliveryTable">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>No DO</th>
                            <th>No Invoice</th>
                            <th>Reseller</th>
                            <th>Pegawai</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deliveries as $delivery)
                            <tr class="delivery-row"
                                data-no-do="{{ strtolower($delivery->no_do) }}"
                                data-invoice="{{ strtolower($delivery->no_invoice) }}"
                                data-reseller="{{ strtolower(optional($delivery->reseller)->nama ?? '') }}"
                                data-status="{{ $delivery->status }}">
                                <td class="row-number">{{ $loop->iteration }}</td>
                                <td>
                                    <span class="do-number-delivery">{{ $delivery->no_do }}</span>
                                </td>
                                <td>
                                    <span class="invoice-number-delivery">{{ $delivery->no_invoice }}</span>
                                </td>
                                <td>
                                    <div class="reseller-info-delivery">
                                        <div class="reseller-avatar-delivery">
                                            {{ strtoupper(substr(optional($delivery->reseller)->nama ?? 'N', 0, 1)) }}
                                        </div>
                                        <span>{{ optional($delivery->reseller)->nama ?? '-' }}</span>
                                    </div>
                                </td>
                                <td>{{ optional($delivery->pegawai)->nama ?? '-' }}</td>
                                <td>
                                    <span class="date-delivery">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                        {{ \Carbon\Carbon::parse($delivery->tanggal)->format('d M Y') }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($delivery->status) {
                                            'Menunggu' => 'status-waiting',
                                            'Diproses' => 'status-processing',
                                            'Dikirim' => 'status-shipped',
                                            'Selesai' => 'status-completed',
                                            'Dibatalkan' => 'status-cancelled',
                                            default => 'status-waiting',
                                        };
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">{{ $delivery->status }}</span>
                                </td>
                                <td>
                                    <div class="action-buttons-delivery">
                                        <a href="{{ route('delivery.show', $delivery->no_do) }}" class="btn-action-delivery btn-detail-delivery" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>
                                        <a href="{{ route('delivery.print', $delivery->no_do) }}" class="btn-action-delivery btn-print-delivery" title="Cetak" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                                        </a>
                                        <a href="{{ route('delivery.edit', $delivery->no_do) }}" class="btn-action-delivery btn-edit-delivery" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>
                                        <form action="{{ route('delivery.destroy', $delivery->no_do) }}" method="POST" class="inline-form-delivery" onsubmit="return confirm('Apakah Anda yakin ingin menghapus delivery order {{ $delivery->no_do }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-delivery btn-delete-delivery" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state-delivery">
                <div class="empty-icon-delivery">
                    <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                </div>
                <h3>Belum Ada Delivery Order</h3>
                <p>Data delivery order masih kosong. Mulai buat delivery order pertama Anda.</p>
                <a href="{{ route('delivery.create') }}" class="btn btn-primary btn-create-delivery" style="margin-top: 12px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Buat DO Baru
                </a>
            </div>
        @endif

        {{-- No Results from Filter --}}
        <div class="no-results-delivery" id="noResults" style="display: none;">
            <div class="empty-icon-delivery">
                <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
            </div>
            <h3>Tidak Ada Hasil</h3>
            <p>Tidak ditemukan data yang sesuai dengan filter pencarian Anda.</p>
        </div>
    </div>
</div>

<style>
    /* Container */
    .delivery-container {
        animation: fadeInDelivery 0.5s ease-out;
    }

    @keyframes fadeInDelivery {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Page Header */
    .page-header-delivery {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title-delivery {
        font-size: 26px;
        font-weight: 800;
        color: #1F2937;
        margin: 0 0 4px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .title-icon {
        font-size: 30px;
        animation: bounceDeliveryTruck 2s ease-in-out infinite;
    }

    @keyframes bounceDeliveryTruck {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(4px); }
        75% { transform: translateX(-2px); }
    }

    .page-subtitle-delivery {
        color: #6B7280;
        font-size: 14px;
        margin: 0;
    }

    .btn-create-delivery {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 24px;
        background: linear-gradient(135deg, #7C5CDB, #6B46C1);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(107, 70, 193, 0.3);
    }

    .btn-create-delivery:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(107, 70, 193, 0.45);
        background: linear-gradient(135deg, #6B46C1, #5B3AA8);
        color: #fff;
    }

    /* Alert */
    .alert-delivery-success {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        animation: slideDownDelivery 0.4s ease-out;
    }

    @keyframes slideDownDelivery {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .alert-icon-delivery {
        flex-shrink: 0;
    }

    .alert-close-delivery {
        margin-left: auto;
        background: none;
        border: none;
        cursor: pointer;
        color: #166534;
        opacity: 0.6;
        padding: 4px;
        transition: opacity 0.2s;
    }

    .alert-close-delivery:hover {
        opacity: 1;
    }

    /* Stats Grid */
    .stats-grid-delivery {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 24px;
    }

    .stat-card-delivery {
        background: #fff;
        border-radius: 16px;
        padding: 22px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        border: 1px solid rgba(229, 231, 235, 0.6);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card-delivery::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        border-radius: 16px 16px 0 0;
    }

    .stat-card-delivery:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    .stat-total::before { background: linear-gradient(90deg, #7C5CDB, #6B46C1); }
    .stat-waiting::before { background: linear-gradient(90deg, #F59E0B, #D97706); }
    .stat-shipped::before { background: linear-gradient(90deg, #4F46E5, #4338CA); }
    .stat-completed::before { background: linear-gradient(90deg, #10B981, #059669); }

    .stat-icon-delivery {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-total .stat-icon-delivery {
        background: linear-gradient(135deg, #F5F3FF, #E9D5FF);
        color: #7C5CDB;
    }

    .stat-waiting .stat-icon-delivery {
        background: linear-gradient(135deg, #FEF3C7, #FDE68A);
        color: #B45309;
        animation: pulseWaiting 2s ease-in-out infinite;
    }

    @keyframes pulseWaiting {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .stat-shipped .stat-icon-delivery {
        background: linear-gradient(135deg, #E0E7FF, #C7D2FE);
        color: #4F46E5;
        animation: slideRightDelivery 3s ease-in-out infinite;
    }

    @keyframes slideRightDelivery {
        0%, 100% { transform: translateX(0); }
        50% { transform: translateX(4px); }
    }

    .stat-completed .stat-icon-delivery {
        background: linear-gradient(135deg, #DCFCE7, #BBF7D0);
        color: #166534;
    }

    .stat-info-delivery {
        display: flex;
        flex-direction: column;
    }

    .stat-number-delivery {
        font-size: 26px;
        font-weight: 800;
        color: #1F2937;
        line-height: 1.1;
    }

    .stat-label-delivery {
        font-size: 13px;
        color: #6B7280;
        font-weight: 500;
        margin-top: 2px;
    }

    /* Filter Card */
    .filter-card-delivery {
        margin-bottom: 24px;
        border-radius: 16px;
    }

    .filter-bar-delivery {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 8px 4px;
        flex-wrap: wrap;
    }

    .search-box-delivery {
        position: relative;
        flex: 1;
        min-width: 260px;
    }

    .search-icon-delivery {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9CA3AF;
        pointer-events: none;
    }

    .search-input-delivery {
        width: 100%;
        padding: 11px 40px 11px 42px;
        border: 2px solid #E5E7EB;
        border-radius: 10px;
        font-size: 14px;
        color: #374151;
        background: #F9FAFB;
        transition: all 0.3s ease;
        outline: none;
    }

    .search-input-delivery:focus {
        border-color: #7C5CDB;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(124, 92, 219, 0.1);
    }

    .search-input-delivery::placeholder {
        color: #9CA3AF;
    }

    .clear-search-delivery {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #9CA3AF;
        padding: 4px;
        border-radius: 50%;
        transition: all 0.2s;
    }

    .clear-search-delivery:hover {
        color: #6B7280;
        background: #F3F4F6;
    }

    .filter-select-wrapper-delivery {
        position: relative;
        min-width: 180px;
    }

    .filter-icon-delivery {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9CA3AF;
        pointer-events: none;
    }

    .filter-select-delivery {
        width: 100%;
        padding: 11px 16px 11px 38px;
        border: 2px solid #E5E7EB;
        border-radius: 10px;
        font-size: 14px;
        color: #374151;
        background: #F9FAFB;
        transition: all 0.3s ease;
        outline: none;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239CA3AF' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
    }

    .filter-select-delivery:focus {
        border-color: #7C5CDB;
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(124, 92, 219, 0.1);
    }

    .filter-count-delivery {
        font-size: 13px;
        color: #6B7280;
        padding: 8px 16px;
        background: #F5F3FF;
        border-radius: 8px;
        font-weight: 500;
        white-space: nowrap;
    }

    .filter-count-delivery span {
        font-weight: 700;
        color: #7C5CDB;
    }

    /* Table Card */
    .table-card-delivery {
        border-radius: 16px;
        overflow: hidden;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .delivery-table thead th {
        background: linear-gradient(135deg, #F5F3FF, #EDE9FE);
        color: #4C1D95;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 14px 16px;
        white-space: nowrap;
        border-bottom: 2px solid #E9D5FF;
    }

    .delivery-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        font-size: 14px;
        border-bottom: 1px solid #F3F4F6;
    }

    .delivery-table tbody tr {
        transition: all 0.2s ease;
    }

    .delivery-table tbody tr:hover {
        background: #FAFAFF;
    }

    .delivery-table tbody tr:last-child td {
        border-bottom: none;
    }

    .row-number {
        text-align: center;
        color: #9CA3AF;
        font-weight: 600;
        font-size: 13px;
    }

    .do-number-delivery {
        font-weight: 700;
        color: #7C5CDB;
        font-size: 13.5px;
        font-family: 'Courier New', monospace;
        background: #F5F3FF;
        padding: 4px 10px;
        border-radius: 6px;
    }

    .invoice-number-delivery {
        font-weight: 600;
        color: #374151;
        font-size: 13.5px;
    }

    .reseller-info-delivery {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .reseller-avatar-delivery {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: linear-gradient(135deg, #7C5CDB, #6B46C1);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 13px;
        flex-shrink: 0;
    }

    .date-delivery {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #6B7280;
        font-size: 13.5px;
    }

    .date-delivery svg {
        color: #9CA3AF;
    }

    /* Action Buttons */
    .action-buttons-delivery {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .inline-form-delivery {
        display: inline;
        margin: 0;
        padding: 0;
    }

    .btn-action-delivery {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1.5px solid transparent;
        cursor: pointer;
        transition: all 0.25s ease;
        text-decoration: none;
        background: transparent;
    }

    .btn-detail-delivery {
        color: #4F46E5;
        border-color: #E0E7FF;
        background: #EEF2FF;
    }
    .btn-detail-delivery:hover {
        background: #4F46E5;
        color: #fff;
        border-color: #4F46E5;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    .btn-print-delivery {
        color: #7C5CDB;
        border-color: #E9D5FF;
        background: #F5F3FF;
    }
    .btn-print-delivery:hover {
        background: #7C5CDB;
        color: #fff;
        border-color: #7C5CDB;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(124, 92, 219, 0.3);
    }

    .btn-edit-delivery {
        color: #B45309;
        border-color: #FEF3C7;
        background: #FFFBEB;
    }
    .btn-edit-delivery:hover {
        background: #F59E0B;
        color: #fff;
        border-color: #F59E0B;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .btn-delete-delivery {
        color: #991B1B;
        border-color: #FEE2E2;
        background: #FEF2F2;
    }
    .btn-delete-delivery:hover {
        background: #EF4444;
        color: #fff;
        border-color: #EF4444;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    /* Empty State */
    .empty-state-delivery {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon-delivery {
        color: #D8B4FE;
        margin-bottom: 18px;
        animation: floatDelivery 3s ease-in-out infinite;
    }

    @keyframes floatDelivery {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    .empty-state-delivery h3,
    .no-results-delivery h3 {
        font-size: 18px;
        color: #374151;
        margin: 0 0 8px 0;
        font-weight: 700;
    }

    .empty-state-delivery p,
    .no-results-delivery p {
        color: #9CA3AF;
        font-size: 14px;
        margin: 0;
    }

    .no-results-delivery {
        text-align: center;
        padding: 50px 20px;
    }

    /* Row animation */
    .delivery-table tbody tr {
        animation: fadeInRowDelivery 0.3s ease-out both;
    }

    @for($i = 0; $i < min($deliveries->count(), 20); $i++)
        .delivery-table tbody tr:nth-child({{ $i + 1 }}) {
            animation-delay: {{ $i * 0.04 }}s;
        }
    @endfor

    @keyframes fadeInRowDelivery {
        from { opacity: 0; transform: translateX(-8px); }
        to { opacity: 1; transform: translateX(0); }
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .stats-grid-delivery {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .page-header-delivery {
            flex-direction: column;
            align-items: flex-start;
        }

        .stats-grid-delivery {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .stat-card-delivery {
            padding: 16px;
        }

        .stat-number-delivery {
            font-size: 22px;
        }

        .filter-bar-delivery {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box-delivery {
            min-width: 100%;
        }

        .filter-select-wrapper-delivery {
            min-width: 100%;
        }

        .filter-count-delivery {
            text-align: center;
        }

        .action-buttons-delivery {
            gap: 4px;
        }

        .btn-action-delivery {
            width: 30px;
            height: 30px;
        }
    }

    @media (max-width: 480px) {
        .stats-grid-delivery {
            grid-template-columns: 1fr;
        }

        .page-title-delivery {
            font-size: 22px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const clearSearch = document.getElementById('clearSearch');
        const resultCount = document.getElementById('resultCount');
        const noResults = document.getElementById('noResults');
        const tableBody = document.querySelector('#deliveryTable tbody');
        const table = document.getElementById('deliveryTable');

        if (!tableBody) return;

        const rows = Array.from(tableBody.querySelectorAll('.delivery-row'));

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const statusValue = statusFilter.value;
            let visibleCount = 0;
            let counter = 0;

            clearSearch.style.display = searchTerm ? 'block' : 'none';

            rows.forEach(function(row) {
                const noDo = row.getAttribute('data-no-do') || '';
                const invoice = row.getAttribute('data-invoice') || '';
                const reseller = row.getAttribute('data-reseller') || '';
                const status = row.getAttribute('data-status') || '';

                const matchesSearch = !searchTerm ||
                    noDo.includes(searchTerm) ||
                    invoice.includes(searchTerm) ||
                    reseller.includes(searchTerm);

                const matchesStatus = !statusValue || status === statusValue;

                if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                    visibleCount++;
                    counter++;
                    row.querySelector('.row-number').textContent = counter;
                } else {
                    row.style.display = 'none';
                }
            });

            resultCount.textContent = visibleCount;

            if (table) {
                table.style.display = visibleCount === 0 ? 'none' : '';
            }
            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        searchInput.addEventListener('input', filterTable);
        statusFilter.addEventListener('change', filterTable);

        clearSearch.addEventListener('click', function() {
            searchInput.value = '';
            clearSearch.style.display = 'none';
            filterTable();
            searchInput.focus();
        });
    });
</script>
@endsection

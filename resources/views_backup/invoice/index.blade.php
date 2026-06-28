@extends('layouts.app')

@section('content')
<div>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1>📄 Daftar Invoice</h1>
        <a href="{{ route('invoice.create') }}" class="btn btn-primary">
            ➕ Buat Invoice Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>No Invoice</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
                    <th>Kasir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                <tr>
                    <td><strong>{{ $invoice->no_invoice }}</strong></td>
                    <td>{{ $invoice->pelanggan->nama ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($invoice->tanggal)->format('d M Y') }}</td>
                    <td style="color: #7C5CDB; font-weight: 600;">Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $invoice->kasir->nama_pg ?? 'N/A' }}</td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('invoice.show', $invoice->no_invoice) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                👁️ Detail
                            </a>
                            <a href="{{ route('invoice.edit', $invoice->no_invoice) }}" class="btn btn-sm btn-warning" title="Edit">
                                ✏️ Edit
                            </a>
                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('invoice.delete', $invoice->no_invoice) }}" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                🗑️ Hapus
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #9CA3AF; padding: 30px;">
                        📭 Belum ada invoice
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .btn {
        padding: 8px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #7C5CDB 0%, #6B46C1 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(123, 92, 219, 0.3);
    }

    .btn-sm {
        padding: 6px 10px;
        font-size: 12px;
    }

    .btn-info {
        background: #E0E7FF;
        color: #4F46E5;
    }

    .btn-info:hover {
        background: #C7D2FE;
    }

    .btn-warning {
        background: #FEF3C7;
        color: #F59E0B;
    }

    .btn-warning:hover {
        background: #FCD34D;
    }

    .btn-danger {
        background: #FEE2E2;
        color: #EF4444;
    }

    .btn-danger:hover {
        background: #FECACA;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #E5E7EB;
    }

    th {
        background: #F9FAFB;
        font-weight: 600;
        color: #374151;
    }

    tr:hover {
        background: #F5F3FF;
    }

    .card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .alert-success {
        background: linear-gradient(135deg, #DCFCE7 0%, #D1FAE5 100%);
        color: #166534;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 4px solid #10B981;
    }
</style>
@endsection

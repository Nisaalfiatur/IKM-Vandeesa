<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\Delivery;
use App\Models\DetailInvoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Laporan Penjualan (Pemasukan, barang terjual, top items)
     */
    public function penjualan(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfYear()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Query invoice pada range tanggal
        $invoices = Invoice::with(['member', 'reseller', 'kasir'])
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();

        // Akumulasi total
        $totalOmset = $invoices->sum('total_harga');
        $totalTransaksi = $invoices->count();

        // Calculate total modal
        $totalModal = DetailInvoice::whereHas('invoice', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]);
            })
            ->selectRaw('SUM(quantity * COALESCE(harga_modal, 0)) as total')
            ->value('total') ?? 0;
            
        $totalLaba = $totalOmset - $totalModal;

        // Detail item terjual
        $soldItems = DetailInvoice::with('item')
            ->whereHas('invoice', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]);
            })
            ->select('id_item', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(quantity * harga_perpcs) as total_omset'))
            ->groupBy('id_item')
            ->orderBy('total_qty', 'desc')
            ->get();

        return view('laporan.penjualan', compact('invoices', 'soldItems', 'startDate', 'endDate', 'totalOmset', 'totalTransaksi', 'totalLaba'));
    }

    /**
     * Laporan Stok (Status Stok Item saat ini, nilai aset stok)
     */
    public function stok()
    {
        $items = Item::all();
        $totalAset = $items->sum(function($item) {
            return $item->stok_item * $item->harga;
        });
        
        $totalStok = $items->sum('stok_item');
        $lowStockCount = $items->where('stok_item', '<=', 10)->count();

        return view('laporan.stok', compact('items', 'totalAset', 'totalStok', 'lowStockCount'));
    }

    /**
     * Laporan Delivery (Status pengiriman, performa kurir/pegawai)
     */
    public function delivery(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfYear()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $deliveries = Delivery::with(['invoice', 'reseller', 'pegawai'])
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();

        $totalDelivery = $deliveries->count();
        $statusCounts = $deliveries->groupBy('status')->map->count();

        return view('laporan.delivery', compact('deliveries', 'startDate', 'endDate', 'totalDelivery', 'statusCounts'));
    }
}

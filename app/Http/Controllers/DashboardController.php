<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Item;
use App\Models\Pelanggan;
use App\Models\Member;
use App\Models\Reseller;
use App\Models\Delivery;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        // Default data untuk semua role
        $totalPenjualan = Invoice::sum('total_harga');
        $jumlahInvoice = Invoice::count();
        $deliveryMenunggu = Delivery::where('status', 'Menunggu')->count();
        $deliveryDiproses = Delivery::where('status', 'Diproses')->count();
        $deliveryDikirim = Delivery::where('status', 'Dikirim')->count();
        $deliverySelesai = Delivery::where('status', 'Selesai')->count();
        $deliveryDibatalkan = Delivery::where('status', 'Dibatalkan')->count();
        $jumlahDelivery = Delivery::count();
        $invoiceTerbaru = Invoice::orderBy('tanggal', 'desc')->limit(5)->get();
        $deliveryTerbaru = Delivery::orderBy('tanggal', 'desc')->limit(5)->get();

        if ($role === 'admin') {
            // Admin: Lihat semua data
            $jumlahItem = Item::count();
            $stokMenipis = Item::where('stok_item', '<=', 5)->count();
            $jumlahPelanggan = Pelanggan::count();
            $jumlahMember = Member::count();
            $jumlahReseller = Reseller::count();

            return view('dashboard', compact(
                'totalPenjualan',
                'jumlahInvoice',
                'jumlahItem',
                'stokMenipis',
                'jumlahPelanggan',
                'jumlahMember',
                'jumlahReseller',
                'jumlahDelivery',
                'deliveryMenunggu',
                'deliveryDiproses',
                'deliveryDikirim',
                'deliverySelesai',
                'deliveryDibatalkan',
                'invoiceTerbaru',
                'deliveryTerbaru'
            ));

        } elseif ($role === 'kasir') {
            // Kasir: Lihat dashboard penjualan saja (tanpa delivery)
            $jumlahItem = Item::count();
            $stokMenipis = Item::where('stok_item', '<=', 5)->count();

            return view('dashboard-kasir', compact(
                'totalPenjualan',
                'jumlahInvoice',
                'jumlahItem',
                'stokMenipis',
                'invoiceTerbaru'
            ));

        } elseif ($role === 'owner') {
            // Owner: Lihat dashboard ringkasan (sales summary)
            return view('dashboard-owner', compact(
                'totalPenjualan',
                'jumlahInvoice',
                'jumlahDelivery',
                'deliveryMenunggu',
                'deliveryDiproses',
                'deliveryDikirim',
                'deliverySelesai',
                'deliveryDibatalkan',
                'invoiceTerbaru',
                'deliveryTerbaru'
            ));
        }

        // Default redirect
        return redirect()->route('dashboard');
    }
}

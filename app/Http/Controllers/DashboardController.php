<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Item;
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
            $jumlahItem = Item::count();
            $stokMenipis = Item::where('stok_item', '<=', 5)->count();
            $jumlahMember = Member::count();
            $jumlahReseller = Reseller::count();

            return view('dashboard', compact(
                'totalPenjualan',
                'jumlahInvoice',
                'jumlahItem',
                'stokMenipis',
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

        return redirect()->route('dashboard');
    }
}

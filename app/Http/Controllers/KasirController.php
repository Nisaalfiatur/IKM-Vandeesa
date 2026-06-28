<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Pelanggan;
use App\Models\Pegawai;
use App\Models\Invoice;
use App\Models\DetailInvoice;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    /**
     * Display items for e-commerce UI / POS
     */
    public function items()
    {
        $items = Item::all();
        $pelanggans = Pelanggan::all();
        $pegawais = Pegawai::all();
        
        $lastInvoice = Invoice::max('no_invoice');
        $nextNumber = $lastInvoice ? (int)substr($lastInvoice, -3) + 1 : 1;
        $nextInvoiceNumber = 'INV' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('kasir.items', compact('items', 'pelanggans', 'pegawais', 'nextInvoiceNumber'));
    }

    /**
     * Display item detail
     */
    public function itemDetail($id)
    {
        $item = Item::findOrFail($id);
        $relatedItems = Item::where('id_item', '!=', $id)->limit(5)->get();
        return view('kasir.item-detail', compact('item', 'relatedItems'));
    }

    /**
     * Handle Checkout from POS
     */
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'no_invoice' => 'required|unique:invoice',
            'id_pelanggan' => 'required',
            'id_pegawai' => 'required',
            'id_pg_kasir' => 'required',
            'tanggal' => 'required|date',
            'cart' => 'required|json',
            'diskon' => 'nullable|numeric|min:0'
        ]);

        $pelanggan = Pelanggan::find($validated['id_pelanggan']);
        $member = null;
        if ($pelanggan) {
            $member = \App\Models\Member::where('nama', $pelanggan->nama)
                            ->orWhere('no_telp', $pelanggan->no_telpn)
                            ->first();
        }
        $id_member = $member ? $member->id_member : null;

        $cart = json_decode($validated['cart'], true);
        
        if (empty($cart)) {
            return back()->withErrors(['cart' => 'Keranjang kosong!']);
        }

        // Calculate initial total
        $totalHarga = 0;
        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['quantity'];
        }

        $diskon = $validated['diskon'] ?? 0;
        $totalHarga -= $diskon;
        if ($totalHarga < 0) $totalHarga = 0;

        // Create Invoice
        $invoice = Invoice::create([
            'no_invoice' => $validated['no_invoice'],
            'id_pelanggan' => $validated['id_pelanggan'],
            'id_pegawai' => $validated['id_pegawai'],
            'id_pg_kasir' => $validated['id_pg_kasir'],
            'id_member' => $id_member,
            'tanggal' => $validated['tanggal'],
            'total_harga' => $totalHarga,
            'diskon' => $diskon,
        ]);

        // Create Details
        foreach ($cart as $item) {
            DetailInvoice::create([
                'no_invoice' => $invoice->no_invoice,
                'id_item' => $item['id'],
                'quantity' => $item['quantity'],
                'harga_perpcs' => $item['harga'],
            ]);
        }

        // Redirect to print struk
        return redirect()->route('kasir.print_struk', $invoice->no_invoice)->with('success', 'Checkout berhasil!');
    }

    /**
     * Print thermal receipt (Struk)
     */
    public function printStruk($id)
    {
        $invoice = Invoice::with(['pelanggan', 'member', 'pegawai', 'kasir', 'detail.item'])->findOrFail($id);
        return view('kasir.print_struk', compact('invoice'));
    }
}

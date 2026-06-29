<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Pegawai;
use App\Models\Invoice;
use App\Models\DetailInvoice;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function items()
    {
        $items = Item::all();
        $allPelanggans = Invoice::buildPelangganOptions();
        $pegawais = Pegawai::all();

        $lastInvoice = Invoice::max('no_invoice');
        $nextNumber = $lastInvoice ? (int) substr($lastInvoice, -3) + 1 : 1;
        $nextInvoiceNumber = 'INV' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('kasir.items', compact('items', 'allPelanggans', 'pegawais', 'nextInvoiceNumber'));
    }

    public function itemDetail($id)
    {
        $item = Item::findOrFail($id);
        $relatedItems = Item::where('id_item', '!=', $id)->limit(5)->get();
        return view('kasir.item-detail', compact('item', 'relatedItems'));
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'no_invoice' => 'required|unique:invoice',
            'id_pelanggan' => 'nullable|string',
            'nama_anonim' => 'nullable|string',
            'id_pegawai' => 'required',
            'id_pg_kasir' => 'required',
            'tanggal' => 'required|date',
            'cart' => 'required|json',
            'diskon' => 'nullable|numeric|min:0',
        ]);

        $raw = $validated['id_pelanggan'];
        $nama_anonim = $validated['nama_anonim'] ?? null;
        $parsed = Invoice::parsePelangganInput($raw);

        $cart = json_decode($validated['cart'], true);

        if (empty($cart)) {
            return back()->withErrors(['cart' => 'Keranjang kosong!']);
        }

        $totalHarga = 0;
        foreach ($cart as $item) {
            $totalHarga += $item['harga'] * $item['quantity'];
        }

        $diskon = $validated['diskon'] ?? 0;
        $totalHarga -= $diskon;
        if ($totalHarga < 0) {
            $totalHarga = 0;
        }

        $invoice = Invoice::create([
            'no_invoice' => $validated['no_invoice'],
            'id_pegawai' => $validated['id_pegawai'],
            'id_pg_kasir' => $validated['id_pg_kasir'],
            'id_member' => $parsed['id_member'],
            'id_reseller' => $parsed['id_reseller'],
            'nama_pelanggan_anonim' => $raw ? null : $nama_anonim,
            'tanggal' => $validated['tanggal'],
            'total_harga' => $totalHarga,
            'diskon' => $diskon,
        ]);

        foreach ($cart as $item) {
            $itemDb = Item::find($item['id']);
            DetailInvoice::create([
                'no_invoice' => $invoice->no_invoice,
                'id_item' => $item['id'],
                'quantity' => $item['quantity'],
                'harga_perpcs' => $item['harga'],
                'harga_modal' => $itemDb ? ($itemDb->harga_modal ?? 0) : 0,
            ]);
        }

        return redirect()->route('kasir.print_struk', $invoice->no_invoice)->with('success', 'Checkout berhasil!');
    }

    public function printStruk($id)
    {
        $invoice = Invoice::with(['member', 'reseller', 'pegawai', 'kasir', 'detail.item'])->findOrFail($id);
        return view('kasir.print_struk', compact('invoice'));
    }
}

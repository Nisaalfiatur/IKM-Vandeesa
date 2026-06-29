<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\DetailInvoice;
use App\Models\Pegawai;
use App\Models\Item;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['member', 'reseller', 'pegawai', 'kasir'])->orderBy('tanggal', 'desc')->get();
        return view('invoice.index', compact('invoices'));
    }

    public function create()
    {
        $allPelanggans = Invoice::buildPelangganOptions();
        $lastInvoice = Invoice::max('no_invoice');
        $nextNumber = $lastInvoice ? (int) substr($lastInvoice, -3) + 1 : 1;
        $nextInvoiceNumber = 'INV' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('invoice.create', compact('allPelanggans', 'nextInvoiceNumber'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_invoice'   => 'required|unique:invoice',
            'id_pelanggan' => 'nullable|string',
            'nama_anonim'  => 'nullable|string',
            'tanggal'      => 'required|date',
        ]);

        $raw = $validated['id_pelanggan'];
        $nama_anonim = $validated['nama_anonim'] ?? null;
        $parsed = Invoice::parsePelangganInput($raw);

        $defaultPegawai = Pegawai::first()?->id_pegawai;

        $invoice = Invoice::create([
            'no_invoice'  => $validated['no_invoice'],
            'id_pegawai'  => $defaultPegawai,
            'id_pg_kasir' => $defaultPegawai,
            'id_member'   => $parsed['id_member'],
            'id_reseller' => $parsed['id_reseller'],
            'nama_pelanggan_anonim' => $raw ? null : $nama_anonim,
            'tanggal'     => $validated['tanggal'],
            'total_harga' => 0,
            'diskon'      => 0,
        ]);

        return redirect()->route('invoice.show', $invoice->no_invoice)->with('success', 'Invoice berhasil dibuat! Sekarang tambahkan item penjualan.');
    }

    public function show($id)
    {
        $invoice = Invoice::with(['member', 'reseller', 'pegawai', 'kasir', 'detail.item'])->findOrFail($id);
        $items = Item::all();
        return view('invoice.show', compact('invoice', 'items'));
    }

    public function storeDetail(Request $request, $invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);

        $validated = $request->validate([
            'id_item' => 'required|exists:item,id_item',
            'quantity' => 'required|numeric|min:1',
            'harga_perpcs' => 'required|numeric|min:0',
        ]);

        $itemDb = Item::findOrFail($validated['id_item']);

        DetailInvoice::create([
            'no_invoice' => $invoiceId,
            'id_item' => $validated['id_item'],
            'quantity' => $validated['quantity'],
            'harga_perpcs' => $validated['harga_perpcs'],
            'harga_modal' => $itemDb->harga_modal ?? 0,
        ]);

        $this->updateInvoiceTotal($invoiceId);

        return redirect()->route('invoice.show', $invoiceId)->with('success', 'Item berhasil ditambahkan!');
    }

    public function deleteDetail($invoiceId, $itemId)
    {
        Invoice::findOrFail($invoiceId);

        DetailInvoice::where('no_invoice', $invoiceId)
            ->where('id_item', $itemId)
            ->delete();

        $this->updateInvoiceTotal($invoiceId);

        return redirect()->route('invoice.show', $invoiceId)->with('success', 'Item berhasil dihapus!');
    }

    public function updateDiskon(Request $request, $invoiceId)
    {
        $request->validate([
            'diskon' => 'required|numeric|min:0',
        ]);

        $invoice = Invoice::findOrFail($invoiceId);
        $invoice->diskon = $request->diskon;
        $invoice->save();

        $this->updateInvoiceTotal($invoiceId);

        return redirect()->route('invoice.show', $invoiceId)->with('success', 'Diskon berhasil diperbarui!');
    }

    private function updateInvoiceTotal($invoiceId)
    {
        $totalHarga = DetailInvoice::where('no_invoice', $invoiceId)
            ->selectRaw('SUM(harga_perpcs * quantity) as total')
            ->value('total') ?? 0;

        $invoice = Invoice::where('no_invoice', $invoiceId)->first();
        if ($invoice) {
            $totalHarga -= $invoice->diskon;
        }
        if ($totalHarga < 0) {
            $totalHarga = 0;
        }

        Invoice::where('no_invoice', $invoiceId)->update(['total_harga' => $totalHarga]);
    }

    public function edit($id)
    {
        $invoice = Invoice::with('detail')->findOrFail($id);
        $allPelanggans = Invoice::buildPelangganOptions();
        $items = Item::all();
        $selectedPelanggan = $invoice->getPelangganSelectValue();

        return view('invoice.edit', compact('invoice', 'allPelanggans', 'selectedPelanggan', 'items'));
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $validated = $request->validate([
            'id_pelanggan' => 'nullable|string',
            'nama_anonim'  => 'nullable|string',
            'tanggal'      => 'required|date',
            'diskon'       => 'nullable|numeric|min:0',
            'items'        => 'required|array',
            'items.*.id_item'      => 'required',
            'items.*.harga_perpcs' => 'required|numeric',
            'items.*.quantity'     => 'required|numeric',
        ]);

        $diskon = $request->diskon ?? 0;
        $raw = $validated['id_pelanggan'];
        $nama_anonim = $validated['nama_anonim'] ?? null;
        $parsed = Invoice::parsePelangganInput($raw);

        $totalHarga = 0;
        foreach ($request->items as $item) {
            $totalHarga += $item['harga_perpcs'] * $item['quantity'];
        }
        $totalHarga -= $diskon;
        if ($totalHarga < 0) {
            $totalHarga = 0;
        }

        $defaultPegawai = Pegawai::first()?->id_pegawai;

        $invoice->update([
            'id_pegawai'   => $defaultPegawai,
            'id_pg_kasir'  => $defaultPegawai,
            'id_member'    => $parsed['id_member'],
            'id_reseller'  => $parsed['id_reseller'],
            'nama_pelanggan_anonim' => $raw ? null : $nama_anonim,
            'tanggal'      => $validated['tanggal'],
            'total_harga'  => $totalHarga,
            'diskon'       => $diskon,
        ]);

        DetailInvoice::where('no_invoice', $id)->delete();
        foreach ($request->items as $item) {
            $itemDb = Item::find($item['id_item']);
            DetailInvoice::create([
                'no_invoice'   => $id,
                'id_item'      => $item['id_item'],
                'harga_perpcs' => $item['harga_perpcs'],
                'quantity'     => $item['quantity'],
                'harga_modal'  => $itemDb ? ($itemDb->harga_modal ?? 0) : 0,
            ]);
        }

        return redirect()->route('invoice.index')->with('success', 'Invoice berhasil diupdate!');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses untuk menghapus invoice.');
        }

        $invoice = Invoice::findOrFail($id);
        DetailInvoice::where('no_invoice', $id)->delete();
        $invoice->delete();

        return redirect()->route('invoice.index')->with('success', 'Invoice berhasil dihapus!');
    }

    public function delete($id)
    {
        return $this->destroy($id);
    }

    public function print($id)
    {
        $invoice = Invoice::with(['member', 'reseller', 'pegawai', 'kasir', 'detail.item'])->findOrFail($id);
        return view('invoice.print', compact('invoice'));
    }
}

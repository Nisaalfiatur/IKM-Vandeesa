<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\DetailInvoice;
use App\Models\Pelanggan;
use App\Models\Member;
use App\Models\Pegawai;
use App\Models\Item;
use App\Models\Reseller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with(['pelanggan', 'member', 'pegawai', 'kasir'])->orderBy('tanggal', 'desc')->get();
        return view('invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pelanggans = Pelanggan::all();
        $members    = Member::all();
        $resellers  = Reseller::all();
        $lastInvoice = Invoice::max('no_invoice');
        $nextNumber = $lastInvoice ? (int)substr($lastInvoice, -3) + 1 : 1;
        $nextInvoiceNumber = 'INV' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Gabungkan semua sumber pelanggan untuk satu dropdown
        $allPelanggans = collect();
        foreach ($pelanggans as $p) {
            $allPelanggans->push([
                'value' => 'pelanggan_' . $p->id_pelanggan,
                'label' => $p->nama,
                'id_pelanggan' => $p->id_pelanggan,
            ]);
        }
        foreach ($members as $m) {
            $allPelanggans->push([
                'value' => 'member_' . $m->id_member,
                'label' => $m->nama,
                'id_pelanggan' => null,
            ]);
        }
        foreach ($resellers as $r) {
            $allPelanggans->push([
                'value' => 'reseller_' . $r->id_reseller,
                'label' => $r->nama,
                'id_pelanggan' => null,
            ]);
        }

        return view('invoice.create', compact('allPelanggans', 'nextInvoiceNumber'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_invoice'   => 'required|unique:invoice',
            'id_pelanggan' => 'required|string',
            'tanggal'      => 'required|date',
        ]);

        // Parse sumber pelanggan dari value dropdown (format: "type_id")
        $raw = $validated['id_pelanggan']; // contoh: "pelanggan_P001", "member_M001", "reseller_R001"
        [$type, $sourceId] = explode('_', $raw, 2);

        $id_pelanggan = null;
        $id_member    = null;
        $id_reseller  = null;

        if ($type === 'pelanggan') {
            $id_pelanggan = $sourceId;
            // Cari member yang cocok
            $pelanggan = Pelanggan::find($sourceId);
            if ($pelanggan) {
                $member = Member::where('nama', $pelanggan->nama)
                    ->orWhere('no_telp', $pelanggan->no_telpn)
                    ->first();
                $id_member = $member?->id_member;
            }
        } elseif ($type === 'member') {
            $member = Member::find($sourceId);
            if ($member) {
                // Cari / buat pelanggan berdasarkan nama member
                $pelanggan = Pelanggan::where('nama', $member->nama)->first();
                $id_pelanggan = $pelanggan?->id_pelanggan;
                $id_member    = $member->id_member;
            }
        } elseif ($type === 'reseller') {
            $reseller = Reseller::find($sourceId);
            if ($reseller) {
                // Cari pelanggan berdasarkan nama reseller
                $pelanggan = Pelanggan::where('nama', $reseller->nama)->first();
                $id_pelanggan = $pelanggan?->id_pelanggan;
                $id_reseller  = $reseller->id_reseller;
            }
        }

        $defaultPegawai = Pegawai::first()?->id_pegawai;

        $invoice = Invoice::create([
            'no_invoice'  => $validated['no_invoice'],
            'id_pelanggan'=> $id_pelanggan,
            'id_pegawai'  => $defaultPegawai,
            'id_pg_kasir' => $defaultPegawai,
            'id_member'   => $id_member,
            'id_reseller' => $id_reseller,
            'tanggal'     => $validated['tanggal'],
            'total_harga' => 0,
            'diskon'      => 0,
        ]);

        return redirect()->route('invoice.show', $invoice->no_invoice)->with('success', 'Invoice berhasil dibuat! Sekarang tambahkan item penjualan.');
    }

    /**
     * Display the specified resource (Detail Invoice).
     */
    public function show($id)
    {
        $invoice = Invoice::with(['pelanggan', 'member', 'pegawai', 'kasir', 'detail.item'])->findOrFail($id);
        $items = Item::all();
        return view('invoice.show', compact('invoice', 'items'));
    }

    /**
     * Store detail invoice item
     */
    public function storeDetail(Request $request, $invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);

        $validated = $request->validate([
            'id_item' => 'required|exists:item,id_item',
            'quantity' => 'required|numeric|min:1',
            'harga_perpcs' => 'required|numeric|min:0',
        ]);

        DetailInvoice::create([
            'no_invoice' => $invoiceId,
            'id_item' => $validated['id_item'],
            'quantity' => $validated['quantity'],
            'harga_perpcs' => $validated['harga_perpcs'],
        ]);

        // Update total harga invoice
        $this->updateInvoiceTotal($invoiceId);

        return redirect()->route('invoice.show', $invoiceId)->with('success', 'Item berhasil ditambahkan!');
    }

    /**
     * Delete detail invoice item
     */
    public function deleteDetail($invoiceId, $itemId)
    {
        $invoice = Invoice::findOrFail($invoiceId);

        DetailInvoice::where('no_invoice', $invoiceId)
            ->where('id_item', $itemId)
            ->delete();

        // Update total harga invoice
        $this->updateInvoiceTotal($invoiceId);

        return redirect()->route('invoice.show', $invoiceId)->with('success', 'Item berhasil dihapus!');
    }

    /**
     * Update diskon invoice dari halaman detail
     */
    public function updateDiskon(Request $request, $invoiceId)
    {
        $request->validate([
            'diskon' => 'required|numeric|min:0',
        ]);

        $invoice = Invoice::findOrFail($invoiceId);
        $invoice->diskon = $request->diskon;
        $invoice->save();

        // Recalculate total harga
        $this->updateInvoiceTotal($invoiceId);

        return redirect()->route('invoice.show', $invoiceId)->with('success', 'Diskon berhasil diperbarui!');
    }

    /**
     * Update invoice total harga berdasarkan detail items
     */
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoice   = Invoice::with('detail')->findOrFail($id);
        $pelanggans = Pelanggan::all();
        $members    = Member::all();
        $resellers  = Reseller::all();
        $items     = Item::all();

        // Gabungkan semua sumber pelanggan
        $allPelanggans = collect();
        foreach ($pelanggans as $p) {
            $allPelanggans->push([
                'value' => 'pelanggan_' . $p->id_pelanggan,
                'label' => $p->nama,
                'id_pelanggan' => $p->id_pelanggan,
            ]);
        }
        foreach ($members as $m) {
            $allPelanggans->push([
                'value' => 'member_' . $m->id_member,
                'label' => $m->nama,
                'id_pelanggan' => null,
            ]);
        }
        foreach ($resellers as $r) {
            $allPelanggans->push([
                'value' => 'reseller_' . $r->id_reseller,
                'label' => $r->nama,
                'id_pelanggan' => null,
            ]);
        }

        // Tentukan selected value saat ini
        $selectedPelanggan = null;
        if ($invoice->id_pelanggan) {
            $selectedPelanggan = 'pelanggan_' . $invoice->id_pelanggan;
        } elseif ($invoice->id_member) {
            $selectedPelanggan = 'member_' . $invoice->id_member;
        } elseif ($invoice->id_reseller) {
            $selectedPelanggan = 'reseller_' . $invoice->id_reseller;
        }

        return view('invoice.edit', compact('invoice', 'allPelanggans', 'selectedPelanggan', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $validated = $request->validate([
            'id_pelanggan' => 'required|string',
            'tanggal'      => 'required|date',
            'diskon'       => 'nullable|numeric|min:0',
            'items'        => 'required|array',
            'items.*.id_item'      => 'required',
            'items.*.harga_perpcs' => 'required|numeric',
            'items.*.quantity'     => 'required|numeric',
        ]);

        $diskon = $request->diskon ?? 0;

        // Parse sumber pelanggan
        $raw = $validated['id_pelanggan'];
        [$type, $sourceId] = explode('_', $raw, 2);

        $id_pelanggan = null;
        $id_member    = null;
        $id_reseller  = null;

        if ($type === 'pelanggan') {
            $id_pelanggan = $sourceId;
            $pelanggan = Pelanggan::find($sourceId);
            if ($pelanggan) {
                $member = Member::where('nama', $pelanggan->nama)
                    ->orWhere('no_telp', $pelanggan->no_telpn)
                    ->first();
                $id_member = $member?->id_member;
            }
        } elseif ($type === 'member') {
            $member = Member::find($sourceId);
            if ($member) {
                $pelanggan = Pelanggan::where('nama', $member->nama)->first();
                $id_pelanggan = $pelanggan?->id_pelanggan;
                $id_member    = $member->id_member;
            }
        } elseif ($type === 'reseller') {
            $reseller = Reseller::find($sourceId);
            if ($reseller) {
                $pelanggan = Pelanggan::where('nama', $reseller->nama)->first();
                $id_pelanggan = $pelanggan?->id_pelanggan;
                $id_reseller  = $reseller->id_reseller;
            }
        }

        // Hitung total harga
        $totalHarga = 0;
        foreach ($request->items as $item) {
            $totalHarga += $item['harga_perpcs'] * $item['quantity'];
        }
        $totalHarga -= $diskon;
        if ($totalHarga < 0) $totalHarga = 0;

        $defaultPegawai = Pegawai::first()?->id_pegawai;

        $invoice->update([
            'id_pelanggan' => $id_pelanggan,
            'id_pegawai'   => $defaultPegawai,
            'id_pg_kasir'  => $defaultPegawai,
            'id_member'    => $id_member,
            'id_reseller'  => $id_reseller,
            'tanggal'      => $validated['tanggal'],
            'total_harga'  => $totalHarga,
            'diskon'       => $diskon,
        ]);

        // Delete old details dan create yang baru
        DetailInvoice::where('no_invoice', $id)->delete();
        foreach ($request->items as $item) {
            DetailInvoice::create([
                'no_invoice'   => $id,
                'id_item'      => $item['id_item'],
                'harga_perpcs' => $item['harga_perpcs'],
                'quantity'     => $item['quantity'],
            ]);
        }

        return redirect()->route('invoice.index')->with('success', 'Invoice berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     * Only admin can delete invoices.
     */
    public function destroy($id)
    {
        // Proteksi: hanya admin yang bisa hapus invoice
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak memiliki akses untuk menghapus invoice.');
        }

        $invoice = Invoice::findOrFail($id);
        DetailInvoice::where('no_invoice', $id)->delete();
        $invoice->delete();

        return redirect()->route('invoice.index')->with('success', 'Invoice berhasil dihapus!');
    }

    /**
     * Delete invoice (GET method for buttons)
     */
    public function delete($id)
    {
        return $this->destroy($id);
    }

    /**
     * Print invoice
     */
    public function print($id)
    {
        $invoice = Invoice::with(['pelanggan', 'member', 'pegawai', 'kasir', 'detail.item'])->findOrFail($id);
        return view('invoice.print', compact('invoice'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Invoice;
use App\Models\Reseller;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index()
    {
        $deliveries = Delivery::with([
                'invoice.member',
                'invoice.reseller',
                'invoice.detail.item',
                'reseller',
                'pegawai',
            ])
            ->orderBy('tanggal', 'desc')
            ->get();
        return view('delivery.index', compact('deliveries'));
    }

    public function create(Request $request)
    {
        $invoices = Invoice::whereNotNull('id_reseller')->with(['member', 'reseller', 'detail.item'])->get();
        $resellers = Reseller::all();
        $pegawais = Pegawai::all();

        $lastDO = Delivery::orderBy('no_do', 'desc')->first();
        if ($lastDO) {
            $lastNum = (int) substr($lastDO->no_do, 2);
            $nextNumber = $lastNum + 1;
        } else {
            $nextNumber = 1;
        }
        $nextDONumber = 'DO' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $selectedInvoice = $request->query('no_invoice');

        return view('delivery.create', compact('invoices', 'resellers', 'pegawais', 'nextDONumber', 'selectedInvoice'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_do' => 'required|unique:delivery,no_do',
            'no_invoice' => 'required|exists:invoice,no_invoice',
            'tanggal' => 'required|date',
            'status' => 'required|in:Menunggu,Diproses,Dikirim,Selesai,Dibatalkan',
        ]);

        $invoice = Invoice::where('no_invoice', $validated['no_invoice'])->first();
        $validated['id_reseller'] = $invoice->id_reseller;
        $validated['id_pegawai'] = Pegawai::first()->id_pegawai ?? null;

        Delivery::create($validated);

        return redirect()->route('delivery.index')->with('success', 'Delivery Order berhasil dibuat!');
    }

    public function show($id)
    {
        $delivery = Delivery::with(['invoice.member', 'invoice.reseller', 'invoice.detail.item', 'reseller', 'pegawai'])->findOrFail($id);
        return view('delivery.show', compact('delivery'));
    }

    public function edit($id)
    {
        $delivery = Delivery::findOrFail($id);
        $invoices = Invoice::whereNotNull('id_reseller')->with(['member', 'reseller', 'detail.item'])->get();
        $resellers = Reseller::all();
        $pegawais = Pegawai::all();

        $invoicesFormatted = $invoices->map(function ($inv) {
            return [
                'no_invoice' => $inv->no_invoice,
                'pelanggan' => $inv->nama_pelanggan,
                'tanggal' => $inv->tanggal,
                'total_harga' => $inv->total_harga,
                'items' => $inv->detail->map(function ($d) {
                    return [
                        'nama' => optional($d->item)->nama_item ?? 'N/A',
                        'qty' => $d->quantity,
                        'harga' => $d->harga_perpcs,
                    ];
                }),
            ];
        });

        return view('delivery.edit', compact('delivery', 'invoices', 'resellers', 'pegawais', 'invoicesFormatted'));
    }

    public function update(Request $request, $id)
    {
        $delivery = Delivery::findOrFail($id);

        $validated = $request->validate([
            'no_invoice' => 'required|exists:invoice,no_invoice',
            'tanggal' => 'required|date',
            'status' => 'required|in:Menunggu,Diproses,Dikirim,Selesai,Dibatalkan',
        ]);

        $invoice = Invoice::where('no_invoice', $validated['no_invoice'])->first();
        $validated['id_reseller'] = $invoice->id_reseller;
        $validated['id_pegawai'] = Pegawai::first()->id_pegawai ?? null;

        $delivery->update($validated);

        return redirect()->route('delivery.index')->with('success', 'Delivery Order berhasil diupdate!');
    }

    public function destroy($id)
    {
        $delivery = Delivery::findOrFail($id);
        $delivery->delete();

        return redirect()->route('delivery.index')->with('success', 'Delivery Order berhasil dihapus!');
    }

    public function delete($id)
    {
        return $this->destroy($id);
    }

    public function print($id)
    {
        $delivery = Delivery::with(['invoice.member', 'invoice.reseller', 'invoice.detail.item', 'reseller', 'pegawai'])->findOrFail($id);
        return view('delivery.print', compact('delivery'));
    }
}

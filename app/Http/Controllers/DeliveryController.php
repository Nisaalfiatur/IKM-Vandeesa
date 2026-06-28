<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Invoice;
use App\Models\Reseller;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deliveries = Delivery::with([
                'invoice.pelanggan',
                'invoice.detail.item',
                'reseller',
                'pegawai',
            ])
            ->orderBy('tanggal', 'desc')
            ->get();
        return view('delivery.index', compact('deliveries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $invoices = Invoice::whereNotNull('id_reseller')->with(['pelanggan', 'member', 'reseller', 'detail.item'])->get();
        $resellers = Reseller::all();
        $pegawais = Pegawai::all();

        // Generate next DO number
        $lastDO = Delivery::orderBy('no_do', 'desc')->first();
        if ($lastDO) {
            $lastNum = (int) substr($lastDO->no_do, 2);
            $nextNumber = $lastNum + 1;
        } else {
            $nextNumber = 1;
        }
        $nextDONumber = 'DO' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('delivery.create', compact('invoices', 'resellers', 'pegawais', 'nextDONumber'));
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $delivery = Delivery::with(['invoice.pelanggan', 'invoice.detail.item', 'reseller', 'pegawai'])->findOrFail($id);
        return view('delivery.show', compact('delivery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $delivery = Delivery::findOrFail($id);
        $invoices = Invoice::whereNotNull('id_reseller')->with(['pelanggan', 'member', 'reseller', 'detail.item'])->get();
        $resellers = Reseller::all();
        $pegawais = Pegawai::all();

        $invoicesFormatted = $invoices->map(function($inv) {
            return [
                'no_invoice' => $inv->no_invoice,
                'pelanggan' => optional($inv->pelanggan)->nama ?? optional($inv->member)->nama ?? optional($inv->reseller)->nama ?? 'N/A',
                'tanggal' => $inv->tanggal,
                'total_harga' => $inv->total_harga,
                'items' => $inv->detail->map(function($d) {
                    return [
                        'nama' => optional($d->item)->nama_item ?? 'N/A',
                        'qty' => $d->quantity,
                        'harga' => $d->harga_perpcs
                    ];
                })
            ];
        });

        return view('delivery.edit', compact('delivery', 'invoices', 'resellers', 'pegawais', 'invoicesFormatted'));
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $delivery = Delivery::findOrFail($id);
        $delivery->delete();

        return redirect()->route('delivery.index')->with('success', 'Delivery Order berhasil dihapus!');
    }

    /**
     * Delete delivery (GET method for buttons)
     */
    public function delete($id)
    {
        return $this->destroy($id);
    }

    /**
     * Print delivery order (Surat Jalan)
     */
    public function print($id)
    {
        $delivery = Delivery::with(['invoice.pelanggan', 'invoice.detail.item', 'reseller', 'pegawai'])->findOrFail($id);
        return view('delivery.print', compact('delivery'));
    }
}

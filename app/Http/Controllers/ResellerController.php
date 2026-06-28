<?php

namespace App\Http\Controllers;

use App\Models\Reseller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ResellerController extends Controller
{
    public function index()
    {
        $resellers = Reseller::orderBy('id_reseller')->get();

        return view('reseller.index', compact('resellers'));
    }

    public function create()
    {
        $last = Reseller::orderBy('id_reseller', 'desc')->first();
        if ($last) {
            $lastNum = (int) substr($last->id_reseller, 3);
            $nextNumber = $lastNum + 1;
        } else {
            $nextNumber = 1;
        }
        $nextId = 'RSL' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('reseller.create', compact('nextId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_reseller' => 'required|max:10|unique:reseller,id_reseller',
            'nama' => 'required|max:100',
            'no_telp' => 'required|max:20',
            'nama_brand' => 'required|max:50',
            'email' => 'required|email|max:100',
            'alamat' => 'required',
        ]);

        Reseller::create([
            'id_reseller' => $request->id_reseller,
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'nama_brand' => $request->nama_brand,
            'email' => $request->email,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('reseller.index')->with('success', 'Data reseller berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $reseller = Reseller::findOrFail($id);

        return view('reseller.edit', compact('reseller'));
    }

    public function update(Request $request, $id)
    {
        $reseller = Reseller::findOrFail($id);

        $request->validate([
            'nama' => 'required|max:100',
            'no_telp' => 'required|max:20',
            'nama_brand' => 'required|max:50',
            'email' => 'required|email|max:100',
            'alamat' => 'required',
        ]);

        $reseller->update([
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'nama_brand' => $request->nama_brand,
            'email' => $request->email,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('reseller.index')->with('success', 'Data reseller berhasil diperbarui.');
    }

    public function delete($id)
    {
        $reseller = Reseller::findOrFail($id);

        return view('reseller.delete', compact('reseller'));
    }

    public function destroy($id)
    {
        try {
            $reseller = Reseller::findOrFail($id);
            $reseller->delete();

            return redirect()->route('reseller.index')->with('success', 'Data reseller berhasil dihapus.');
        } catch (QueryException $e) {
            return redirect()->route('reseller.index')->with('error', 'Data reseller tidak bisa dihapus karena sudah digunakan pada data lain.');
        }
    }
}

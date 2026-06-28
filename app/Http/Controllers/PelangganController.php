<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::orderBy('id_pelanggan')->get();

        return view('pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        $last = Pelanggan::orderBy('id_pelanggan', 'desc')->first();
        if ($last) {
            $lastNum = (int) substr($last->id_pelanggan, 3);
            $nextNumber = $lastNum + 1;
        } else {
            $nextNumber = 1;
        }
        $nextId = 'PLG' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('pelanggan.create', compact('nextId'));
    }

    public function store(Request $request)
{
    $request->validate([
        'id_pelanggan' => 'required|max:10|unique:pelanggan,id_pelanggan',
        'nama' => 'required|max:100',
        'no_telpn' => 'required|max:20',
    ]);

    Pelanggan::create([
        'id_pelanggan' => $request->id_pelanggan,
        'nama' => $request->nama,
        'no_telpn' => $request->no_telpn,
    ]);

    return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil ditambahkan.');
}
    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $request->validate([
            'nama' => 'required|max:100',
            'no_telpn' => 'required|max:20',
        ]);

        $pelanggan->update([
            'nama' => $request->nama,
            'no_telpn' => $request->no_telpn,
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        return view('pelanggan.delete', compact('pelanggan'));
    }

    public function destroy($id)
    {
        try {
            $pelanggan = Pelanggan::findOrFail($id);
            $pelanggan->delete();

            return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil dihapus.');
        } catch (QueryException $e) {
            return redirect()->route('pelanggan.index')->with('error', 'Data pelanggan tidak bisa dihapus karena sudah digunakan pada data lain.');
        }
    }
}

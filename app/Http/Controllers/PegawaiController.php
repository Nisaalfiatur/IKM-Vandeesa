<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::orderBy('id_pegawai')->get();

        return view('pegawai.index', compact('pegawai'));
    }

    public function create()
    {
        $last = Pegawai::orderBy('id_pegawai', 'desc')->first();
        if ($last) {
            $lastNum = (int) substr($last->id_pegawai, 2);
            $nextNumber = $lastNum + 1;
        } else {
            $nextNumber = 1;
        }
        $nextId = 'PG' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('pegawai.create', compact('nextId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required|max:10|unique:pegawai,id_pegawai',
            'nama_pg' => 'required|max:100',
            'jabatan' => 'required|max:100',
        ]);

        Pegawai::create([
            'id_pegawai' => $request->id_pegawai,
            'nama_pg' => $request->nama_pg,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        return view('pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $request->validate([
            'nama_pg' => 'required|max:100',
            'jabatan' => 'required|max:100',
        ]);

        $pegawai->update([
            'nama_pg' => $request->nama_pg,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function delete($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        return view('pegawai.delete', compact('pegawai'));
    }

    public function destroy($id)
    {
        try {
            $pegawai = Pegawai::findOrFail($id);
            $pegawai->delete();

            return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
        } catch (QueryException $e) {
            return redirect()->route('pegawai.index')->with('error', 'Data pegawai tidak bisa dihapus karena sudah digunakan pada data lain.');
        }
    }
}

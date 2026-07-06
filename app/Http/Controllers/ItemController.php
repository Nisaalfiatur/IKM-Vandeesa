<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::orderBy('id_item')->get();

        return view('item.index', compact('items'));
    }

    public function create()
    {
        return view('item.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_item' => 'required|max:10|unique:item,id_item',
            'nama_item' => 'required|max:100',
            'stok_item' => 'required|numeric|min:0',
            'harga' => 'required|max:100',
            'harga_modal' => 'nullable|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'id_item' => $request->id_item,
            'nama_item' => $request->nama_item,
            'stok_item' => $request->stok_item,
            'harga' => $request->harga,
            'harga_modal' => $request->harga_modal ?? 0,
            'harga_reseller' => $request->harga,
        ];

        // Handle file upload
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $request->id_item . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/items'), $filename);
            $data['gambar'] = $filename;
        }

        Item::create($data);

        return redirect()->route('item.index')->with('success', 'Data item berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);

        return view('item.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'nama_item' => 'required|max:100',
            'stok_item' => 'required|numeric|min:0',
            'harga' => 'required|max:100',
            'harga_modal' => 'nullable|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'nama_item' => $request->nama_item,
            'stok_item' => $request->stok_item,
            'harga' => $request->harga,
            'harga_modal' => $request->harga_modal ?? 0,
        ];

        // Handle file upload
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($item->gambar && file_exists(public_path('images/items/' . $item->gambar))) {
                unlink(public_path('images/items/' . $item->gambar));
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/items'), $filename);
            $data['gambar'] = $filename;
        }

        $item->update($data);

        return redirect()->route('item.index')->with('success', 'Data item berhasil diperbarui.');
    }

    public function delete($id)
    {
        $item = Item::findOrFail($id);

        return view('item.delete', compact('item'));
    }

    public function destroy($id)
    {
        try {
            $item = Item::findOrFail($id);
            $item->delete();

            return redirect()->route('item.index')->with('success', 'Data item berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->route('item.index')->with('error', 'Data item tidak dapat dihapus karena masih digunakan pada data lain (misalnya invoice).');
            }
            return redirect()->route('item.index')->with('error', 'Terjadi kesalahan saat menghapus data item.');
        }
    }
}

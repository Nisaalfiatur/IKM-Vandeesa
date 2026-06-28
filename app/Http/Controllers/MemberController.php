<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::orderBy('id_member')->get();

        return view('member.index', compact('members'));
    }

    public function create()
    {
        $today = date('Ymd');
        $last = Member::where('id_member', 'like', $today . '%')->orderBy('id_member', 'desc')->first();
        if ($last) {
            $lastNum = (int) substr($last->id_member, 8);
            $nextNumber = $lastNum + 1;
        } else {
            $nextNumber = 1;
        }
        $nextId = $today . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return view('member.create', compact('nextId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_member' => 'required|max:20|unique:member,id_member',
            'nama' => 'required|max:100',
            'kategori' => 'required|in:online,offline',
            'no_telp' => 'required|max:20',
            'tgl_daftar' => 'required|date',
            'email' => 'required|email|max:50',
        ]);

        Member::create([
            'id_member' => $request->id_member,
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'no_telp' => $request->no_telp,
            'tgl_daftar' => $request->tgl_daftar,
            'email' => $request->email,
        ]);

        return redirect()->route('member.index')->with('success', 'Data member berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);

        return view('member.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $request->validate([
            'nama' => 'required|max:100',
            'kategori' => 'required|in:online,offline',
            'no_telp' => 'required|max:20',
            'tgl_daftar' => 'required|date',
            'email' => 'required|email|max:50',
        ]);

        $member->update([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'no_telp' => $request->no_telp,
            'tgl_daftar' => $request->tgl_daftar,
            'email' => $request->email,
        ]);

        return redirect()->route('member.index')->with('success', 'Data member berhasil diperbarui.');
    }

    public function delete($id)
    {
        $member = Member::findOrFail($id);

        return view('member.delete', compact('member'));
    }

    public function destroy($id)
    {
        try {
            $member = Member::findOrFail($id);
            $member->delete();

            return redirect()->route('member.index')->with('success', 'Data member berhasil dihapus.');
        } catch (QueryException $e) {
            return redirect()->route('member.index')->with('error', 'Data member tidak bisa dihapus karena sudah digunakan pada data lain.');
        }
    }
}

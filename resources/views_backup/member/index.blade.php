@extends('layouts.app')

@section('content')
<h1>Data Member</h1>

<a href="{{ route('member.create') }}" class="btn">Tambah Member</a>

<br><br>

<div class="card">
    <table>
        <tr>
            <th>ID Member</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>No Telepon</th>
            <th>Tanggal Daftar</th>
            <th>Email</th>
            <th>Diskon</th>
            <th>Aksi</th>
        </tr>

        @forelse($members as $member)
        <tr>
            <td>{{ $member->id_member }}</td>
            <td>{{ $member->nama }}</td>
            <td>{{ $member->kategori }}</td>
            <td>{{ $member->no_telp }}</td>
            <td>{{ $member->tgl_daftar }}</td>
            <td>{{ $member->email }}</td>
            <td>Rp {{ number_format($member->diskon, 0, ',', '.') }}</td>
            <td>
                <a href="{{ route('member.edit', $member->id_member) }}" class="btn">Edit</a>
                <a href="{{ route('member.delete', $member->id_member) }}" class="btn btn-danger">Hapus</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8">Data member belum ada.</td>
        </tr>
        @endforelse
    </table>
</div>
@endsection

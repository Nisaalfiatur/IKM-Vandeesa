@extends('layouts.app')

@section('content')
<h1>Data Pelanggan</h1>

<a href="{{ route('pelanggan.create') }}" class="btn">Tambah Pelanggan</a>

<br><br>

<div class="card">
    <table>
        <tr>
            <th>ID Pelanggan</th>
            <th>Nama</th>
            <th>No Telepon</th>
            <th>Aksi</th>
        </tr>

        @forelse($pelanggan as $p)
        <tr>
            <td>{{ $p->id_pelanggan }}</td>
            <td>{{ $p->nama }}</td>
            <td>{{ $p->no_telpn }}</td>
            <td>
                <a href="{{ route('pelanggan.edit', $p->id_pelanggan) }}" class="btn">Edit</a>
                <a href="{{ route('pelanggan.delete', $p->id_pelanggan) }}" class="btn btn-danger">Hapus</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4">Data pelanggan belum ada.</td>
        </tr>
        @endforelse
    </table>
</div>
@endsection

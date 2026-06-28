@extends('layouts.app')

@section('content')
<h1>Data Reseller</h1>

<a href="{{ route('reseller.create') }}" class="btn">Tambah Reseller</a>

<br><br>

<div class="card">
    <table>
        <tr>
            <th>ID Reseller</th>
            <th>Nama</th>
            <th>No Telepon</th>
            <th>Nama Brand</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>

        @forelse($resellers as $reseller)
        <tr>
            <td>{{ $reseller->id_reseller }}</td>
            <td>{{ $reseller->nama }}</td>
            <td>{{ $reseller->no_telp }}</td>
            <td>{{ $reseller->nama_brand }}</td>
            <td>{{ $reseller->email }}</td>
            <td>{{ $reseller->alamat }}</td>
            <td>
                <a href="{{ route('reseller.edit', $reseller->id_reseller) }}" class="btn">Edit</a>
                <a href="{{ route('reseller.delete', $reseller->id_reseller) }}" class="btn btn-danger">Hapus</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">Data reseller belum ada.</td>
        </tr>
        @endforelse
    </table>
</div>
@endsection

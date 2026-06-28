@extends('layouts.app')

@section('content')
<h1>Konfirmasi Hapus Reseller</h1>

<div class="card">
    <p>Yakin ingin menghapus reseller berikut?</p>

    <table>
        <tr>
            <th>ID Reseller</th>
            <td>{{ $reseller->id_reseller }}</td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $reseller->nama }}</td>
        </tr>
        <tr>
            <th>Nama Brand</th>
            <td>{{ $reseller->nama_brand }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $reseller->email }}</td>
        </tr>
    </table>

    <br>

    <form method="POST" action="{{ route('reseller.destroy', $reseller->id_reseller) }}">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
        <a href="{{ route('reseller.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

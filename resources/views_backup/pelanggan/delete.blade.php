@extends('layouts.app')

@section('content')
<h1>Konfirmasi Hapus Pelanggan</h1>

<div class="card">
    <p>Yakin ingin menghapus pelanggan berikut?</p>

    <table>
        <tr>
            <th>ID Pelanggan</th>
            <td>{{ $pelanggan->id_pelanggan }}</td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $pelanggan->nama }}</td>
        </tr>
        <tr>
            <th>No Telepon</th>
            <td>{{ $pelanggan->no_telpn }}</td>
        </tr>
    </table>

    <br>

    <form method="POST" action="{{ route('pelanggan.destroy', $pelanggan->id_pelanggan) }}">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

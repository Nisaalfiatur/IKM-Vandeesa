@extends('layouts.app')

@section('content')
<h1>Konfirmasi Hapus Item</h1>

<div class="card">
    <p>Apakah Anda yakin ingin menghapus data item berikut?</p>

    <table>
        <tr>
            <th>ID Item</th>
            <td>{{ $item->id_item }}</td>
        </tr>
        <tr>
            <th>Nama Item</th>
            <td>{{ $item->nama_item }}</td>
        </tr>
        <tr>
            <th>Stok Item</th>
            <td>{{ $item->stok_item }}</td>
        </tr>
        <tr>
            <th>Harga</th>
            <td>{{ $item->harga }}</td>
        </tr>
    </table>

    <br>

    <form action="{{ route('item.destroy', $item->id_item) }}" method="POST">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger">
            Ya, Hapus
        </button>

        <a href="{{ route('item.index') }}" class="btn btn-secondary">
            Batal
        </a>
    </form>
</div>
@endsection

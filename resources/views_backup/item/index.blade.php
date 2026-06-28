@extends('layouts.app')

@section('content')
<h1>Data Item</h1>

<a href="{{ route('item.create') }}" class="btn">Tambah Item</a>

<br><br>

<table>
    <tr>
        <th>ID Item</th>
        <th>Gambar</th>
        <th>Nama Item</th>
        <th>Stok Item</th>
        <th>Harga</th>
        <th>Aksi</th>
    </tr>

    @foreach($items as $item)
    <tr>
        <td>{{ $item->id_item }}</td>
        <td style="text-align: center;">
            @if($item->gambar)
                <img src="{{ asset('images/items/' . $item->gambar) }}" alt="{{ $item->nama_item }}" style="max-width: 80px; max-height: 80px; border-radius: 6px; object-fit: cover;">
            @else
                <span style="color: #9CA3AF; font-size: 12px;">Tidak ada gambar</span>
            @endif
        </td>
        <td>{{ $item->nama_item }}</td>
        <td>{{ $item->stok_item }}</td>
        <td>{{ $item->harga }}</td>
        <td>
            <a href="{{ route('item.edit', $item->id_item) }}" class="btn">
                Edit
            </a>

            <a href="{{ route('item.delete', $item->id_item) }}" class="btn btn-danger">
                Hapus
            </a>
        </td>
    </tr>
    @endforeach
</table>
@endsection

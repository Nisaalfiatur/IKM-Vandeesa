@extends('layouts.app')

@section('content')
<h1>Edit Item</h1>

<form method="POST" action="{{ route('item.update', $item->id_item) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>ID Item</label>
    <input type="text" value="{{ $item->id_item }}" readonly>

    <label>Nama Item</label>
    <input type="text" name="nama_item" value="{{ old('nama_item', $item->nama_item) }}">

    <label>Stok Item</label>
    <input type="number" name="stok_item" value="{{ old('stok_item', $item->stok_item) }}">

    <label>Harga</label>
    <input type="text" name="harga" value="{{ old('harga', $item->harga) }}">

    <label>Gambar Item</label>
    @if($item->gambar)
    <div style="margin-bottom: 15px;">
        <img src="{{ asset('images/items/' . $item->gambar) }}" alt="{{ $item->nama_item }}" style="max-width: 200px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 8px rgba(123, 92, 219, 0.1);">
        <p style="color: #9CA3AF; font-size: 12px; margin-top: 8px;">Gambar saat ini</p>
    </div>
    @endif
    <input type="file" name="gambar" accept="image/*">
    <small style="color: #9CA3AF;">Format: JPG, PNG, GIF (Max 2MB) - Kosongkan jika tidak ingin mengubah</small>

    <button type="submit">Update</button>

    <a href="{{ route('item.index') }}" class="btn btn-secondary">
        Kembali
    </a>
</form>
@endsection

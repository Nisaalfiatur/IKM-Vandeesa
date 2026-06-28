@extends('layouts.app')

@section('content')
<h1>Tambah Item</h1>

<form method="POST" action="{{ route('item.store') }}" enctype="multipart/form-data">
    @csrf

    <label>ID Item</label>
    <input type="text" name="id_item" value="{{ old('id_item') }}" placeholder="Contoh: ITM001">

    <label>Nama Item</label>
    <input type="text" name="nama_item" value="{{ old('nama_item') }}" placeholder="Contoh: Gamis Anak">

    <label>Stok Item</label>
    <input type="number" name="stok_item" value="{{ old('stok_item') }}" placeholder="Contoh: 10">

    <label>Harga</label>
    <input type="text" name="harga" value="{{ old('harga') }}" placeholder="Contoh: 150000">

    <label>Gambar Item</label>
    <input type="file" name="gambar" accept="image/*" placeholder="Pilih gambar">
    <small style="color: #9CA3AF;">Format: JPG, PNG, GIF (Max 2MB)</small>

    <button type="submit">Simpan</button>

    <a href="{{ route('item.index') }}" class="btn btn-secondary">
        Kembali
    </a>
</form>
@endsection

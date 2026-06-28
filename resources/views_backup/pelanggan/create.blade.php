@extends('layouts.app')

@section('content')
<h1>Tambah Pelanggan</h1>

<div class="card">
    <form method="POST" action="{{ route('pelanggan.store') }}">
        @csrf

        <label>ID Pelanggan</label>
        <input type="text" name="id_pelanggan" value="{{ old('id_pelanggan') }}" placeholder="PLG001">

        <label>Nama Pelanggan</label>
        <input type="text" name="nama" value="{{ old('nama') }}">

        <label>No Telepon</label>
        <input type="text" name="no_telpn" value="{{ old('no_telpn') }}" placeholder="081234567890">
        
        <button type="submit">Simpan</button>
        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('content')
<h1>Edit Pelanggan</h1>

<div class="card">
    <form method="POST" action="{{ route('pelanggan.update', $pelanggan->id_pelanggan) }}">
        @csrf
        @method('PUT')

        <label>ID Pelanggan</label>
        <input type="text" value="{{ $pelanggan->id_pelanggan }}" readonly>

        <label>Nama Pelanggan</label>
        <input type="text" name="nama" value="{{ old('nama', $pelanggan->nama) }}">

        <label>No Telepon</label>
        <input type="text" name="no_telpn" value="{{ old('no_telpn', $pelanggan->no_telpn) }}">
        
        <button type="submit">Update</button>
        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

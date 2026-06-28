@extends('layouts.app')

@section('content')
<h1>Tambah Reseller</h1>

<div class="card">
    <form method="POST" action="{{ route('reseller.store') }}">
        @csrf

        <label>ID Reseller</label>
        <input type="text" name="id_reseller" value="{{ old('id_reseller') }}" placeholder="RSL001">

        <label>Nama</label>
        <input type="text" name="nama" value="{{ old('nama') }}">

        <label>No Telepon</label>
        <input type="text" name="no_telp" value="{{ old('no_telp') }}">

        <label>Nama Brand</label>
        <input type="text" name="nama_brand" value="{{ old('nama_brand') }}">

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}">

        <label>Alamat</label>
        <textarea name="alamat">{{ old('alamat') }}</textarea>

        <button type="submit">Simpan</button>
        <a href="{{ route('reseller.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

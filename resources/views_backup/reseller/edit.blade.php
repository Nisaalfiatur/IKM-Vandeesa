@extends('layouts.app')

@section('content')
<h1>Edit Reseller</h1>

<div class="card">
    <form method="POST" action="{{ route('reseller.update', $reseller->id_reseller) }}">
        @csrf
        @method('PUT')

        <label>ID Reseller</label>
        <input type="text" value="{{ $reseller->id_reseller }}" readonly>

        <label>Nama</label>
        <input type="text" name="nama" value="{{ old('nama', $reseller->nama) }}">

        <label>No Telepon</label>
        <input type="text" name="no_telp" value="{{ old('no_telp', $reseller->no_telp) }}">

        <label>Nama Brand</label>
        <input type="text" name="nama_brand" value="{{ old('nama_brand', $reseller->nama_brand) }}">

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $reseller->email) }}">

        <label>Alamat</label>
        <textarea name="alamat">{{ old('alamat', $reseller->alamat) }}</textarea>

        <button type="submit">Update</button>
        <a href="{{ route('reseller.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

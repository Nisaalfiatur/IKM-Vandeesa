@extends('layouts.app')

@section('content')
<h1>Tambah Pegawai</h1>

<div class="card">
    <form method="POST" action="{{ route('pegawai.store') }}">
        @csrf

        <label>ID Pegawai</label>
        <input type="text" name="id_pegawai" value="{{ old('id_pegawai') }}" placeholder="PG001">

        <label>Nama Pegawai</label>
        <input type="text" name="nama_pg" value="{{ old('nama_pg') }}">

        <label>Jabatan</label>
        <input type="text" name="jabatan" value="{{ old('jabatan') }}">

        <button type="submit">Simpan</button>
        <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

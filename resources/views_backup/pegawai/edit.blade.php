@extends('layouts.app')

@section('content')
<h1>Edit Pegawai</h1>

<div class="card">
    <form method="POST" action="{{ route('pegawai.update', $pegawai->id_pegawai) }}">
        @csrf
        @method('PUT')

        <label>ID Pegawai</label>
        <input type="text" value="{{ $pegawai->id_pegawai }}" readonly>

        <label>Nama Pegawai</label>
        <input type="text" name="nama_pg" value="{{ old('nama_pg', $pegawai->nama_pg) }}">

        <label>Jabatan</label>
        <input type="text" name="jabatan" value="{{ old('jabatan', $pegawai->jabatan) }}">

        <button type="submit">Update</button>
        <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

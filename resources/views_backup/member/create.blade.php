@extends('layouts.app')

@section('content')
<h1>Tambah Member</h1>

<div class="card">
    <form method="POST" action="{{ route('member.store') }}">
        @csrf

        <label>ID Member</label>
        <input type="text" name="id_member" value="{{ old('id_member') }}" placeholder="MBR001">

        <label>Nama</label>
        <input type="text" name="nama" value="{{ old('nama') }}">

        <label>Kategori</label>
        <select name="kategori">
            <option value="">Pilih Kategori</option>
            <option value="online" {{ old('kategori') == 'online' ? 'selected' : '' }}>Online</option>
            <option value="offline" {{ old('kategori') == 'offline' ? 'selected' : '' }}>Offline</option>
        </select>

        <label>No Telepon</label>
        <input type="text" name="no_telp" value="{{ old('no_telp') }}">

        <label>Tanggal Daftar</label>
        <input type="date" name="tgl_daftar" value="{{ old('tgl_daftar') }}">

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}">

        <label>Diskon</label>
        <input type="number" name="diskon" value="{{ old('diskon') }}">

        <button type="submit">Simpan</button>
        <a href="{{ route('member.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

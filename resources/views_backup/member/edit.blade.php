@extends('layouts.app')

@section('content')
<h1>Edit Member</h1>

<div class="card">
    <form method="POST" action="{{ route('member.update', $member->id_member) }}">
        @csrf
        @method('PUT')

        <label>ID Member</label>
        <input type="text" value="{{ $member->id_member }}" readonly>

        <label>Nama</label>
        <input type="text" name="nama" value="{{ old('nama', $member->nama) }}">

        <label>Kategori</label>
        <select name="kategori">
            <option value="online" {{ old('kategori', $member->kategori) == 'online' ? 'selected' : '' }}>Online</option>
            <option value="offline" {{ old('kategori', $member->kategori) == 'offline' ? 'selected' : '' }}>Offline</option>
        </select>

        <label>No Telepon</label>
        <input type="text" name="no_telp" value="{{ old('no_telp', $member->no_telp) }}">

        <label>Tanggal Daftar</label>
        <input type="date" name="tgl_daftar" value="{{ old('tgl_daftar', $member->tgl_daftar) }}">

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $member->email) }}">

        <label>Diskon</label>
        <input type="number" name="diskon" value="{{ old('diskon', $member->diskon) }}">

        <button type="submit">Update</button>
        <a href="{{ route('member.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

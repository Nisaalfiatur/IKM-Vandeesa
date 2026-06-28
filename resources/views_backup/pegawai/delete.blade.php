@extends('layouts.app')

@section('content')
<h1>Konfirmasi Hapus Pegawai</h1>

<div class="card">
    <p>Yakin ingin menghapus pegawai berikut?</p>

    <table>
        <tr>
            <th>ID Pegawai</th>
            <td>{{ $pegawai->id_pegawai }}</td>
        </tr>
        <tr>
            <th>Nama Pegawai</th>
            <td>{{ $pegawai->nama_pg }}</td>
        </tr>
        <tr>
            <th>Jabatan</th>
            <td>{{ $pegawai->jabatan }}</td>
        </tr>
    </table>

    <br>

    <form method="POST" action="{{ route('pegawai.destroy', $pegawai->id_pegawai) }}">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
        <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

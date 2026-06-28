@extends('layouts.app')

@section('content')
<h1>Data Pegawai</h1>

<a href="{{ route('pegawai.create') }}" class="btn">Tambah Pegawai</a>

<br><br>

<div class="card">
    <table>
        <tr>
            <th>ID Pegawai</th>
            <th>Nama Pegawai</th>
            <th>Jabatan</th>
            <th>Aksi</th>
        </tr>

        @forelse($pegawai as $pg)
        <tr>
            <td>{{ $pg->id_pegawai }}</td>
            <td>{{ $pg->nama_pg }}</td>
            <td>{{ $pg->jabatan }}</td>
            <td>
                <a href="{{ route('pegawai.edit', $pg->id_pegawai) }}" class="btn">Edit</a>
                <a href="{{ route('pegawai.delete', $pg->id_pegawai) }}" class="btn btn-danger">Hapus</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4">Data pegawai belum ada.</td>
        </tr>
        @endforelse
    </table>
</div>
@endsection

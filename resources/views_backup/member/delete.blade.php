@extends('layouts.app')

@section('content')
<h1>Konfirmasi Hapus Member</h1>

<div class="card">
    <p>Yakin ingin menghapus member berikut?</p>

    <table>
        <tr>
            <th>ID Member</th>
            <td>{{ $member->id_member }}</td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $member->nama }}</td>
        </tr>
        <tr>
            <th>Kategori</th>
            <td>{{ $member->kategori }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $member->email }}</td>
        </tr>
    </table>

    <br>

    <form method="POST" action="{{ route('member.destroy', $member->id_member) }}">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
        <a href="{{ route('member.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

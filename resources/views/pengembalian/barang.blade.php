@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Pengembalian Barang</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Kembali</th>
                <th>ID Peminjaman</th>
                <th>Nama Siswa</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Aksi</th> {{-- Tambahkan kolom Aksi --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($pengembalian_data as $item)
            <tr>
                <td>{{ $item->kembali_id }}</td>
                <td>{{ $item->pb_id }}</td>
                <td>{{ $item->siswa_nama ?? 'Tidak Ada Nama' }}</td>
                <td>{{ $item->kembali_tgl }}</td>
                <td><span class="badge badge-success">Sudah Dikembalikan</span></td>
                <td>
                    <a href="{{ route('pengembalian.detail', $item->pb_id) }}" class="btn btn-info btn-sm">
                        Detail
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

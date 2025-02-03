@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Detail Barang Peminjaman</h2>

    <p><strong>ID Peminjaman:</strong> {{ $peminjaman->pb_id }}</p>
    <p><strong>Nama Siswa:</strong> {{ $peminjaman->pb_nama_siswa }}</p>
    <p><strong>Tanggal Pinjam:</strong> {{ $peminjaman->pb_tgl }}</p>
    <p><strong>Tanggal Harus Kembali:</strong> {{ $peminjaman->pb_harus_kembali_tgl }}</p>

    <h4>Barang yang Dipinjam:</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peminjaman_barang as $barang)
            <tr>
                <td>{{ $barang->br_kode }}</td>
                <td>{{ $barang->barang->br_nama ?? 'Tidak ditemukan' }}</td>
                <td>{{ $barang->pdb_sts }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection

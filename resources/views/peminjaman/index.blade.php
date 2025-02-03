@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Daftar Peminjaman</h2>

    <!-- Menampilkan pesan jika ada success atau error -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tabel Daftar Peminjaman -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Peminjaman</th>
                <th>Nama Siswa</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Harus Kembali</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peminjaman as $item)
            <tr>
                <td>{{ $item->pb_id }}</td>
                <td>{{ $item->pb_nama_siswa }}</td>
                <td>{{ $item->pb_tgl }}</td>
                <td>{{ $item->pb_harus_kembali_tgl }}</td>
                <td>{{ ($item->pb_stat == '0' ? 'Sudah Dikembalikan' : 'Belum Dikembalikan') }}</td>
                <td>
                    <!-- Tombol untuk melihat detail barang -->
                    <a href="{{ route('peminjaman.show', $item->pb_id) }}" class="btn btn-info btn-sm">
                        Detail Barang
                    </a>
                
                    <!-- Tombol untuk edit (nonaktif jika pb_stat = 0) -->
                    @if ($item->pb_stat == '1')
                        <a href="{{ route('peminjaman.edit', $item->pb_id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>
                    @else
                        <button class="btn btn-warning btn-sm" disabled>Edit</button>
                    @endif
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

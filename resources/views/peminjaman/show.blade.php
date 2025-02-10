@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detail Barang Peminjaman</h4>
        </div>
        <div class="card-body">
            <p><strong>ID Peminjaman:</strong> {{ $peminjaman->pb_id }}</p>
            <p><strong>Nama Siswa:</strong> {{ $peminjaman->pb_nama_siswa }}</p>
            <p><strong>Tanggal Pinjam:</strong> {{ $peminjaman->pb_tgl }}</p>
            <p><strong>Tanggal Harus Kembali:</strong> {{ $peminjaman->pb_harus_kembali_tgl }}</p>

            <h4 class="mt-5">Barang yang Dipinjam</h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="bg-dark text-white">
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
                            <td>
                                @if ($barang->pdb_sts == 1)
                                    <span class="badge bg-success">Tersedia</span>
                                @elseif ($barang->pdb_sts == 2)
                                    <span class="badge bg-warning text-dark">Rusak (Bisa Diperbaiki)</span>
                                @elseif ($barang->pdb_sts == 3)
                                    <span class="badge bg-danger">Rusak (Tidak Dapat Diperbaiki)</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection

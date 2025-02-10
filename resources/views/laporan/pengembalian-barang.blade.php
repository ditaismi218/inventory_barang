@extends('layouts.layout')

@section('content')

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Laporan Pengembalian Barang</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Pengembalian</th>
                        <th>Nama Siswa</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Status Pengembalian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengembalian_data as $index => $pengembalian)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pengembalian->kembali_id }}</td>
                            <td>{{ $pengembalian->siswa_nama ?? 'Tidak Ada Nama' }}</td>
                            <td>{{ $pengembalian->kembali_tgl }}</td>
                            <td>
                                @if($pengembalian->kembali_sts == 1)
                                    Sudah Dikembalikan
                                @else
                                    Belum Dikembalikan
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data pengembalian barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

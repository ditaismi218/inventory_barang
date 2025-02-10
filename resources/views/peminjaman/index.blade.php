@extends('layouts.layout')

@section('content')
<div class="container mt-4">
    <!-- Notifikasi -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-description mb-0">Daftar Peminjaman Barang</h4>
                    <button class="btn btn-primary btn-sm" onclick="printTable()">
                        <i class="fa fa-print"></i> Cetak
                    </button>
                </div>                
                <form method="GET" action="{{ route('peminjaman.index') }}" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama siswa..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-secondary"><i class="fa fa-search"></i> Search</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped" id="table-print">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Peminjaman</th>
                                <th>Nama Siswa</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Harus Kembali</th>
                                <th>Status</th>
                                <th class="no-print">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjamans as $index => $item)
                            <tr>
                                <td>{{ $index + 1 + ($peminjamans->currentPage() - 1) * $peminjamans->perPage() }}</td>
                                <td>{{ $item->pb_id }}</td>
                                <td>{{ $item->siswa->siswa_nama ?? 'Nama Tidak Tersedia' }}</td>
                                <td>{{ $item->pb_tgl }}</td>
                                <td>{{ $item->pb_harus_kembali_tgl }}</td>
                                <td>
                                    @if ($item->pb_stat == '0')
                                        <span class="badge bg-success">Sudah Dikembalikan</span>
                                    @else
                                        <span class="badge bg-danger">Belum Dikembalikan</span>
                                    @endif
                                </td>
                                <td class="no-print">
                                    <a href="{{ route('peminjaman.show', $item->pb_id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Showing {{ $peminjamans->firstItem() }} - {{ $peminjamans->lastItem() }} to {{ $peminjamans->total() }} result
                    </div>
                    <div>
                        {{ $peminjamans->links('pagination::bootstrap-4') }}
                    </div>
                </div>
                               
            </div>
        </div>
    </div>
</div>

<!-- Style agar kolom Aksi tidak ikut tercetak -->
<style>
    @media print {
        .no-print { display: none !important; }
    }
    /* .pagination .page-item:first-child span {
        display: none;
    } */
</style>

<!-- Script untuk Cetak -->
<script>
    function printTable() {
        var printContents = document.getElementById('table-print').outerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = `
            <html>
                <head>
                    <title>Cetak Daftar Peminjaman</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        h2 { text-align: center; margin-bottom: 20px; }
                        table { width: 100%; border-collapse: collapse; border: 1px solid #000; }
                        th, td { border: 1px solid #000; padding: 8px; text-align: left; font-size: 14px; }
                        th { background-color: #f2f2f2; text-align: center; }
                        td { text-align: center; }
                        .no-print { display: none; } /* Kolom "Aksi" disembunyikan saat cetak */
                    </style>
                </head>
                <body>
                    <h2>Daftar Peminjaman Barang</h2>
                    ${printContents}
                </body>
            </html>
        `;

        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>

@endsection

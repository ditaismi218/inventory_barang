@extends('layouts.layout')

@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center print-area">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Daftar Barang Tersedia</h6>

            <!-- Dropdown Export -->
            <div class="btn-group no-print">
                <button type="button" class="btn btn-primary">Export</button>
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                        id="dropdownMenuSplitButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                    <a class="dropdown-item" href="#" onclick="printLaporan()">Print</a>
                    <a class="dropdown-item" href="{{ route('export.pdf') }}">Export PDF</a>
                    <a class="dropdown-item" href="{{ route('export.excel') }}">Export Excel</a>
                    <a class="dropdown-item" href="{{ route('export.csv') }}">Export CSV</a>
                </div>
            </div>
        </div>

        <div class="card-body print-area">

            <!-- 🔹 Filter dan Search -->
            <form method="GET" action="{{ route('laporan.daftar-barang') }}" class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control"
                               placeholder="Cari Nama Barang..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="start_date" class="form-control"
                               value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="end_date" class="form-control"
                               value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
            <!-- 🔹 End Filter dan Search -->

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jenis Barang</th>
                            <th>Tanggal Terima</th>
                            <th>Tanggal Masuk</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barangInventaris as $index => $barang)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $barang->br_kode }}</td>
                                <td>{{ $barang->br_nama }}</td>
                                <td>{{ $barang->jns_brg_nama }}</td>
                                <td>{{ $barang->br_tgl_terima ?? 'Tidak ada' }}</td>
                                <td>{{ $barang->br_tgl_entry }}</td>
                                <td>Tersedia</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            {{ $barangInventaris->links() }}
        </div>
    </div>

    <script>
        function printLaporan() {
            window.print();
        }
    </script>

@endsection

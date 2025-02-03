@extends('layouts.layout')

@section('content')

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Laporan Status Barang</h6>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <form action="{{ route('laporan.status-barang') }}" method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <select name="status" class="form-control" onchange="this.form.submit()">
                        <option value="">Pilih Status Barang</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Baik</option>
                        <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Rusak, dapat diperbaiki</option>
                        <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Rusak, tidak dapat digunakan</option>
                    </select>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered">
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
                    @forelse($barangInventaris as $index => $barang)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $barang->br_kode }}</td>
                            <td>{{ $barang->br_nama }}</td>
                            <td>{{ $barang->jns_brg_nama }}</td>
                            <td>{{ $barang->br_tgl_terima ?? 'Tidak ada' }}</td>
                            <td>{{ $barang->br_tgl_entry }}</td>
                            <td>
                                @if($barang->br_status == 1)
                                    Baik
                                @elseif($barang->br_status == 2)
                                    Rusak, dapat diperbaiki
                                @elseif($barang->br_status == 3)
                                    Rusak, tidak dapat digunakan
                                @else
                                    Tidak diketahui
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada barang dengan status yang dipilih.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

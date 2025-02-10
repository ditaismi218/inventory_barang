@extends('layouts.layout')

@section('content')
    {{-- <h1>Daftar Barang Inventaris</h1> --}}

    <a href="{{ route('daftar-barang.create') }}" class="btn btn-primary mb-3">Tambah Barang Inventaris</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-description">Daftar Barang Inventaris</h4>
            {{-- <p class="card-description"> Add class <code>.table-striped</code></p> --}}
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jenis Barang</th>
                    <th>Tanggal Terima</th>
                    <th>Tanggal Masuk</th>
                    <th>Kondisi</th>
                    <th>Status</th>
                    <th>Aksi</th>
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
                      <td>{{ $barang->br_status ?? 'Tidak ada' }}</td>
                      <td>{{ $barang->pdb_sts == '0' ? 'Tersedia' : 'Dipinjam'}}</td>
                      {{-- <td>{{ $barang->pdb_sts == '0' ? 'Tersedia' : 'Dipinjam'}}-{{ $barang->pdb_sts}}</td> --}}
                      <td class="text-center">
                        <a href="{{ route('daftar-barang.edit', $barang->br_kode) }}" class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{ route('daftar-barang.destroy', $barang->br_kode) }}" method="POST" style="display: inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                            <i class="fa fa-trash"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

@endsection

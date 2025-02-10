@extends('layouts.layout')

@section('content')
    {{-- <h1>Tambah Barang Inventaris</h1> --}}

    {{-- <form action="{{ route('daftar-barang.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="br_nama">Nama Barang</label>
            <input type="text" id="br_nama" name="br_nama" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="jns_brg_kode">Jenis Barang</label>
            <select name="jns_brg_kode" id="jns_brg_kode" class="form-control">
                @foreach ($jenisBarangs as $jenis)
                    <option value="{{ $jenis->jns_brg_kode }}">{{ $jenis->jns_brg_nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="br_tgl_terima">Tanggal Terima</label>
            <input type="date" id="br_tgl_terima" name="br_tgl_terima" class="form-control">
        </div>

        <div class="form-group">
            <label for="br_status">Status</label>
            <select name="br_status" id="br_status">
                <option value="1">Barang kondisi baik</option>
                <option value="2">Barang kondisi rusak, dapat diperbaiki</option>
                <option value="3">Barang rusak, tidak bisa digunakan</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form> --}}

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-description">Tambah Barang Inventaris</h4>
            <form action="{{ route('daftar-barang.store') }}" method="POST">
            @csrf
              <div class="form-group">
                <label for="exampleInputName1">Nama Barang</label>
                <input type="text" id="br_nama" name="br_nama" class="form-control" required placeholder="Nama Barang">
              </div>
              <div class="form-group">
                <label for="jns_brg_kode">Jenis Barang</label>
                <select class="form-select" id="jns_brg_kode" name="jns_brg_kode">
                    @foreach ($jenisBarangs as $jenis)
                        <option value="{{ $jenis->jns_brg_kode }}">{{ $jenis->jns_brg_nama }}</option>
                    @endforeach
                </select>
              </div>

              <div class="form-group">
                <label for="br_tgl_terima">Tanggal Terima</label>
                <input type="date" id="br_tgl_terima" name="br_tgl_terima" class="form-control">
              </div>

              <div class="form-group">
                <label for="br_status">Status</label>
                <select class="form-select" id="br_status" name="br_status">
                    <option value="1">Barang kondisi baik</option>
                    <option value="2">Barang kondisi rusak, dapat diperbaiki</option>
                    <option value="3">Barang rusak, tidak bisa digunakan</option>
                </select>
              </div>

              <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
              {{-- <button class="btn btn-light">Cancel</button> --}}
            </form>
          </div>
        </div>
      </div>
@endsection

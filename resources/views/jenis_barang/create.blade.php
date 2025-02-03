@extends('layouts.layout')

@section('content')
    <h1>Tambah Jenis Barang</h1>

    <form action="{{ route('jenis_barang.store') }}" method="POST">
        @csrf
        {{-- <div class="form-group">
            <label for="jns_brg_kode">Kode Jenis Barang</label>
            <input type="text" name="jns_brg_kode" id="jns_brg_kode" class="form-control" required>
        </div> --}}

        <div class="form-group">
            <label for="jns_brg_nama">Nama Jenis Barang</label>
            <input type="text" name="jns_brg_nama" id="jns_brg_nama" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection

@extends('layouts.layout')

@section('content')
    <h1>Edit Jenis Barang</h1>

    <form action="{{ route('jenis_barang.update', $jenisBarang->jns_brg_kode) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="jns_brg_nama">Nama Jenis Barang</label>
            <input type="text" name="jns_brg_nama" id="jns_brg_nama" class="form-control" value="{{ $jenisBarang->jns_brg_nama }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection

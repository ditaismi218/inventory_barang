@extends('layouts.layout')

@section('content')
    <h1>Edit Barang Inventaris</h1>

    <form action="{{ route('daftar-barang.update', $barang->br_kode) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="br_nama">Nama Barang</label>
            <input type="text" id="br_nama" name="br_nama" class="form-control" value="{{ $barang->br_nama }}" required>
        </div>

        <div class="form-group">
            <label for="jns_brg_kode">Jenis Barang</label>
            <select name="jns_brg_kode" id="jns_brg_kode" class="form-control">
                @foreach ($jenisBarangs as $jenis)
                    <option value="{{ $jenis->jns_brg_kode }}" {{ $barang->jns_brg_kode == $jenis->jns_brg_kode ? 'selected' : '' }}>
                        {{ $jenis->jns_brg_nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="br_tgl_terima">Tanggal Terima</label>
            <input type="date" id="br_tgl_terima" name="br_tgl_terima" class="form-control" value="{{ $barang->br_tgl_terima }}">
        </div>

        <div class="form-group">
            <label for="br_status">Status</label>
            <select name="br_status" id="br_status">
                <option value="0" {{ $barang->br_status == 1 ? 'selected' : '' }}>Soft Delete</option>
                <option value="1" {{ $barang->br_status == 1 ? 'selected' : '' }}>Barang kondisi baik</option>
                <option value="2" {{ $barang->br_status == 2 ? 'selected' : '' }}>Barang kondisi rusak, dapat diperbaiki</option>
                <option value="3" {{ $barang->br_status == 3 ? 'selected' : '' }}>Barang rusak, tidak bisa digunakan</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection

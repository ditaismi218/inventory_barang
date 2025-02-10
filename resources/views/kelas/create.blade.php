@extends('layouts.layout')

@section('title', 'Tambah Kelas')

@section('content')
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tambah Kelas</h4>
            <p class="card-description">Form untuk menambahkan kelas baru</p>
            <form action="{{ route('kelas.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="kelas_nama">Nama Kelas</label>
                    <input type="text" class="form-control" id="kelas_nama" name="kelas_nama" placeholder="Masukkan nama kelas" required>
                </div>
                <div class="form-group">
                    <label for="tingkatan">Tingkatan</label>
                    <select name="tingkatan" class="form-control">
                        <option value="X">X</option>
                        <option value="XI">XI</option>
                        <option value="XII">XII</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="jurusan_id">Jurusan</label>
                    <select class="form-control" id="jurusan_id" name="jurusan_id" required>
                        <option value="">Pilih Jurusan</option>
                        @foreach($jurusan as $j)
                            <option value="{{ $j->jurusan_id }}">{{ $j->jurusan_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-gradient-primary me-2">Simpan</button>
                <a href="{{ route('kelas.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

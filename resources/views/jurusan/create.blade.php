@extends('layouts.layout')
@section('title', 'Tambah Jurusan')

@section('content')
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tambah Jurusan</h4>
            <p class="card-description">Masukkan data jurusan baru</p>
            
            <form action="{{ route('jurusan.store') }}" method="POST" class="forms-sample">
                @csrf
                
                <div class="form-group">
                    <label for="jurusan_nama">Nama Jurusan</label>
                    <input type="text" class="form-control" id="jurusan_nama" name="jurusan_nama" required>
                </div>
                
                <button type="submit" class="btn btn-gradient-primary me-2">Simpan</button>
                <a href="{{ route('jurusan.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

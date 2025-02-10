@extends('layouts.layout')

@section('title', 'Tambah Siswa')

@section('content')
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tambah Siswa</h4>
            <form action="{{ route('siswa.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nis">NIS Siswa</label>
                    <input type="text" class="form-control" name="nis" required>
                </div>
                <div class="form-group">
                    <label for="siswa_nama">Nama Siswa</label>
                    <input type="text" class="form-control" name="siswa_nama" required>
                </div>
                <div class="form-group">
                    <label for="kelas_id">Kelas</label>
                    <select class="form-control" name="kelas_id">
                        @foreach($kelas as $k)
                            <option value="{{ $k->kelas_id }}">{{ $k->kelas_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="jurusan_id">Jurusan</label>
                    <select class="form-control" name="jurusan_id">
                        @foreach($jurusan as $j)
                            <option value="{{ $j->jurusan_id }}">{{ $j->jurusan_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

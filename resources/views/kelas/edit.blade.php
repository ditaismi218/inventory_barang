@extends('layouts.layout')

@section('title', 'Edit Kelas')

@section('content')
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Kelas</h4>
            <p class="card-description">Form untuk mengedit data kelas</p>
            <form action="{{ route('kelas.update', $kelas->kelas_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="kelas_nama">Nama Kelas</label>
                    <input type="text" class="form-control" id="kelas_nama" name="kelas_nama" value="{{ $kelas->kelas_nama }}" required>
                </div>
                <div class="form-group">
                    <label for="tingkatan">Tingkatan</label>
                    <select name="tingkatan" class="form-control">
                        <option value="X" {{ $kelas->tingkatan == 'X' ? 'selected' : '' }}>X</option>
                        <option value="XI" {{ $kelas->tingkatan == 'XI' ? 'selected' : '' }}>XI</option>
                        <option value="XII" {{ $kelas->tingkatan == 'XII' ? 'selected' : '' }}>XII</option>
                    </select>
                </div>                
                <div class="form-group">
                    <label for="jurusan_id">Jurusan</label>
                    <select class="form-control" id="jurusan_id" name="jurusan_id" required>
                        @foreach($jurusan as $j)
                            <option value="{{ $j->jurusan_id }}" {{ $kelas->jurusan_id == $j->jurusan_id ? 'selected' : '' }}>
                                {{ $j->jurusan_nama }}
                            </option>
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

@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Tambah User</h2>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="user_nama" class="form-label">Nama</label>
            <input type="text" name="user_nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="user_pass" class="form-label">Password</label>
            <input type="password" name="user_pass" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="user_hak" class="form-label">Hak Akses</label>
            <select name="user_hak" class="form-control" required>
                <option value="SU">Super User</option>
                <option value="OP">Operator</option>
                <option value="AD">Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection

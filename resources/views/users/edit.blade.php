@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Edit User</h2>

    <form action="{{ route('users.update', $user->user_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="user_nama" class="form-control" value="{{ $user->user_nama }}" required>
        </div>
        <div class="mb-3">
            <label>Password (Kosongkan jika tidak ingin mengubah)</label>
            <input type="password" name="user_pass" class="form-control">
        </div>
        <div class="mb-3">
            <label>Hak Akses</label>
            <select name="user_hak" class="form-control">
                <option value="SU" {{ $user->user_hak == 'SU' ? 'selected' : '' }}>Super User</option>
                <option value="OP" {{ $user->user_hak == 'OP' ? 'selected' : '' }}>Operator</option>
                <option value="AD" {{ $user->user_hak == 'AD' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="user_sts" class="form-label">Status</label>
            <select name="user_sts" class="form-control" required>
                <option value="1" {{ $user->user_sts == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ $user->user_sts == '0' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>        
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection

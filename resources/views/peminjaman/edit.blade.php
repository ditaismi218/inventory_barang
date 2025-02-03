@extends('layouts.layout')

@section('title', 'Edit Peminjaman')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Edit Peminjaman</h1>
    <form action="{{ route('peminjaman.update', $peminjaman->pb_id) }}" method="POST" class="space-y-4">
        @csrf
        @method('put')
        
        {{-- Nomor Siswa --}}
        <div class="mb-4">
            <label for="pb_no_siswa" class="block mb-2 font-medium text-gray-700">Nomor Siswa</label>
            <input 
                type="text" 
                name="pb_no_siswa" 
                id="pb_no_siswa" 
                value="{{ old('pb_no_siswa', $peminjaman->pb_no_siswa) }}" 
                class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500"
            >
            @error('pb_no_siswa')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- Nama Siswa --}}
        <div class="mb-4">
            <label for="pb_nama_siswa" class="block mb-2 font-medium text-gray-700">Nama Siswa</label>
            <input 
                type="text" 
                name="pb_nama_siswa" 
                id="pb_nama_siswa" 
                value="{{ old('pb_nama_siswa', $peminjaman->pb_nama_siswa) }}" 
                class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500"
            >
            @error('pb_nama_siswa')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="pb_harus_kembali_tgl" class="block mb-2 font-medium text-gray-700">Tanggal Pengembalian</label>
            <input 
                type="date" 
                name="pb_harus_kembali_tgl" 
                id="pb_harus_kembali_tgl" 
                value="{{ date('Y-m-d', strtotime($peminjaman->pb_harus_kembali_tgl)) }}" 
                class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500"
            >
            @error('pb_harus_kembali_tgl')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        

        {{-- Tombol Update --}}
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            Update
        </button>
    </form>
@endsection          

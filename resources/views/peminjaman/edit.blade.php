@extends('layouts.layout')

@section('title', 'Edit Peminjaman')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Edit Peminjaman</h1>
    <form action="{{ route('peminjaman.update', $peminjaman->pb_id) }}" method="POST" class="space-y-4">
        @csrf
        @method('put')

       {{-- Nama Siswa --}}
       <div class="mb-4">
        <label for="siswa_id" class="block mb-2 font-medium text-gray-700">Nama Siswa</label>
        <select 
            name="siswa_id" 
            id="siswa_id" 
            class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500"
            required
        >
            <option value="">Pilih Nama Siswa</option>
            @foreach ($siswas as $siswa)
                <option value="{{ $siswa->siswa_id }}" 
                    {{ old('siswa_id', $peminjaman->siswa_id ?? '') == $siswa->siswa_id ? 'selected' : '' }}>
                    {{ $siswa->siswa_nama }}
                </option>
            @endforeach
        </select>
    
        @error('siswa_id')
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

@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Detail Barang yang Dikembalikan</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman_barang as $item)
            <tr>
                <td>{{ $item->barangInventaris->br_kode }}</td>
                <td>{{ $item->barangInventaris->br_nama }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection

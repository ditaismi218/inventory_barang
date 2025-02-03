@extends('layouts.layout')

@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center print-area">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Daftar Barang Tersedia</h6>
            <button class="btn btn-primary no-print" onclick="printLaporan()">Print</button>
        </div>
        <div class="card-body print-area">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jenis Barang</th>
                            <th>Tanggal Terima</th>
                            <th>Tanggal Masuk</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barangInventaris as $index => $barang)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $barang->br_kode }}</td>
                                <td>{{ $barang->br_nama }}</td>
                                <td>{{ $barang->jns_brg_nama }}</td>
                                <td>{{ $barang->br_tgl_terima ?? 'Tidak ada' }}</td>
                                <td>{{ $barang->br_tgl_entry }}</td> 
                                <td>Tersedia</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        @media print {
            /* Sembunyikan semua elemen selain yang ingin dicetak */
            body * {
                visibility: hidden;
            }
            .print-area, .print-area * {
                visibility: visible;
            }
            .no-print {
                display: none; /* Sembunyikan tombol Print */
            }

            /* Tampilan umum untuk cetakan */
            .card {
                border: 1px solid #ccc; /* Menambahkan border pada card */
                box-shadow: none; /* Hapus shadow */
                margin: 0 auto;
                width: 100%; /* Lebar penuh */
                padding: 10px;
            }

            /* Pengaturan tabel */
            table {
                width: 100%;
                border-collapse: collapse;
                page-break-inside: avoid; /* Mencegah pemisahan tabel saat print */
            }

            table th, table td {
                padding: 10px;
                text-align: left;
                border: 1px solid #ddd;
                font-size: 12px; /* Ukuran font lebih kecil untuk cetakan */
            }

            /* Memperjelas header tabel */
            table th {
                background-color: #f4f4f4;
                font-weight: bold;
            }

            /* Set margin dan padding agar tampilan lebih rapih */
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                font-size: 12px;
            }

            h6 {
                font-size: 18px;
                text-align: center;
            }

            .card-header {
                border-bottom: 2px solid #000;
                padding-bottom: 10px;
                margin-bottom: 15px;
            }

            /* Set footer untuk cetakan */
            .no-print {
                display: none;
            }
        }
    </style>

    <script>
        function printLaporan() {
            window.print();
        }
    </script>

@endsection

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanPengembalianBarangController extends Controller
{
    public function index()
    {
        // Ambil data transaksi pengembalian barang yang sudah dikembalikan
        $data['pengembalian_data'] = DB::table('tm_pengembalian')
            ->join('tm_peminjaman', 'tm_peminjaman.pb_id', '=', 'tm_pengembalian.pb_id')
            ->select('tm_pengembalian.*', 'tm_peminjaman.pb_nama_siswa')
            ->where('tm_pengembalian.kembali_sts', '1') // Status sudah dikembalikan
            ->get();

        // return view('laporan-pengembalian.index', $data);
        return view('laporan.pengembalian-barang')->with($data);
        
    }
}

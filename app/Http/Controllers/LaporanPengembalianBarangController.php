<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanPengembalianBarangController extends Controller
{
    public function index()
    {
        $data['pengembalian_data'] = DB::table('tm_pengembalian')
            ->join('tm_peminjaman', 'tm_peminjaman.pb_id', '=', 'tm_pengembalian.pb_id')
            ->join('tm_siswa', 'tm_siswa.siswa_id', '=', 'tm_peminjaman.siswa_id') // Join ke siswa
            ->select('tm_pengembalian.*', 'tm_siswa.siswa_nama') // Ambil siswa_nama
            ->where('tm_pengembalian.kembali_sts', '1') // Status sudah dikembalikan
            ->get();

        // return view('laporan-pengembalian.index', $data);
        return view('laporan.pengembalian-barang')->with($data);
        
    }
}

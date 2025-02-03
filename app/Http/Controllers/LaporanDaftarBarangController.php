<?php

namespace App\Http\Controllers;

use App\Models\BarangInventaris;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LaporanDaftarBarangController extends Controller
{
    public function index()
    {
        $data['barangInventaris'] = DB::table('tm_barang_inventaris')
            ->select('tm_barang_inventaris.*', 'tr_jenis_barang.jns_brg_nama', 'latest_peminjaman.pdb_sts')
            ->leftJoin('tr_jenis_barang', 'tm_barang_inventaris.jns_brg_kode', '=', 'tr_jenis_barang.jns_brg_kode')
            ->leftJoinSub(
                DB::table('td_peminjaman_barang')
                    ->select('br_kode', 'pdb_sts', 'created_at')
                    ->whereIn('br_kode', function ($query) {
                        $query->select('br_kode')
                            ->from('td_peminjaman_barang')
                            ->groupBy('br_kode')
                            ->havingRaw('MAX(created_at) = created_at');
                    }),
                'latest_peminjaman',
                function ($join) {
                    $join->on('tm_barang_inventaris.br_kode', '=', 'latest_peminjaman.br_kode');
                }
            )
            ->where(function ($query) {
                $query->whereNull('latest_peminjaman.pdb_sts')  // Barang belum pernah dipinjam
                      ->orWhere('latest_peminjaman.pdb_sts', '!=', 1); // Barang sudah dikembalikan
            })
            ->orderBy('tm_barang_inventaris.br_tgl_terima', 'desc')
            ->get();
    
        $data['users'] = Auth::user()->user_nama;
    
        return view('laporan.daftar-barang')->with($data);
    }
    
}

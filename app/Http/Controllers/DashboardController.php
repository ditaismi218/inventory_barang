<?php

namespace App\Http\Controllers;

use App\Models\BarangInventaris;
use App\Models\Peminjaman;
use App\Models\PeminjamanBarang;
use Illuminate\Support\Facades\Auth;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        
        $username = Auth::user()->user_nama;
        $totalBarang = BarangInventaris::count();
        $tersedia = DB::table('tm_barang_inventaris')
        ->select('tm_barang_inventaris.*', 'tr_jenis_barang.jns_brg_nama', DB::raw('ifnull(latest_peminjaman.pdb_sts, 0) as pdb_sts') )
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
                // ->where('pdb_sts', '=', 0),
            'latest_peminjaman',
            function ($join) {
                $join->on('tm_barang_inventaris.br_kode', '=', 'latest_peminjaman.br_kode');
            }
        )
        ->where('pdb_sts','!=',1)
        ->count();

        $tidak_tersedia = DB::table('tm_barang_inventaris')
        ->select('tm_barang_inventaris.*', 'tr_jenis_barang.jns_brg_nama', DB::raw('ifnull(latest_peminjaman.pdb_sts, 0) as pdb_sts') )
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
                // ->where('pdb_sts', '=', 0),
            'latest_peminjaman',
            function ($join) {
                $join->on('tm_barang_inventaris.br_kode', '=', 'latest_peminjaman.br_kode');
            }
        )
        ->where('pdb_sts','=',1)
        ->count();
        // tersedia
        // barang rusak
        // barang blm kmbali
        // $tersedia = BarangInventaris::whereHas('peminjaman_barang', function ($q) {
        //     $q->where('pbd_sts', '0');    
        // })->get();
        $totalPeminjaman = Peminjaman::count();

        $date_from = date('Y-m-d');
        $date_to = date('Y-m-d', strtotime('+3 days'));

        $durasi_peminjaman = Peminjaman::whereBetween('pb_tgl', [$date_from, $date_to])->where('pb_stat', '1')->get();
        return view('dashboard', compact('username', 'totalBarang', 'totalPeminjaman', 'durasi_peminjaman', 'tersedia', 'tidak_tersedia'));
    }
}

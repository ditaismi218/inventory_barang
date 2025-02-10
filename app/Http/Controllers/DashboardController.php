<?php

namespace App\Http\Controllers;

use App\Models\BarangInventaris;
use App\Models\Peminjaman;
use App\Models\PeminjamanBarang;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        // dd('ha');
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
     
        $totalPeminjaman = Peminjaman::count();
        $barangRusak = BarangInventaris::whereIn('br_status', ['2', '3'])->count();

        // $date_from = date('Y-m-d');
        // $date_to = date('Y-m-d', strtotime('+3 days'));

        // $durasi_peminjaman = Peminjaman::whereBetween('pb_tgl', [$date_from, $date_to])->where('pb_stat', '1')->get();

        $date_from = date('Y-m-d');
        $date_to = date('Y-m-d', strtotime('+3 days'));
    
        $durasi_peminjaman = Peminjaman::with('siswa') // Tambahkan eager loading siswa
        ->whereBetween('pb_harus_kembali_tgl', [$date_from, $date_to])
        ->where('pb_stat', '1')
        ->get();    
        
        $chart = Peminjaman::get();

        $dailyData = Peminjaman::select(DB::raw('DATE(pb_tgl) as tanggal'), DB::raw('COUNT(*) as total'))
        ->whereDate('pb_tgl', '>=', Carbon::now()->subDays(7)) // Hanya ambil 7 hari terakhir
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'asc')
        ->get();

    // Format tanggal agar lebih singkat
    $dailyLabels = $dailyData->pluck('tanggal')->map(function ($date) {
        return Carbon::parse($date)->format('d M'); // Contoh: 10 Feb
    });

    $dailyValues = $dailyData->pluck('total');
    
        return view('dashboard', compact('username', 'totalBarang', 'totalPeminjaman', 'durasi_peminjaman', 'tersedia', 'tidak_tersedia', 'date_from', 'date_to', 'barangRusak', 'chart', 'dailyLabels', 'dailyValues'));
    }
}

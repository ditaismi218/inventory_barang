<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\PeminjamanBarang;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\Auth;
// use DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        // Ambil data barang dari database
       
        $data['peminjaman'] = Peminjaman::where('pb_stat', '1')->get();
        // $data['peminjaman'] = Pengembalian::all();

        // print_r($peminjaman);

        return view('pengembalian.index', $data);
    }

    public function indexKembali()
    {
        // Ambil data barang yang sudah dikembalikan
        // $data['pengembalian_data'] = Pengembalian::where('kembali_sts', '1')->get();
        $data['pengembalian_data'] = DB::table('tm_pengembalian')
        ->join('tm_peminjaman', 'tm_peminjaman.pb_id', '=', 'tm_pengembalian.pb_id')
        ->select('tm_pengembalian.*', 'tm_peminjaman.pb_nama_siswa')
        ->where('tm_pengembalian.kembali_sts', '1')
        ->get();

        return view('pengembalian.barang', $data);
    }

    public function detailPeminjaman($pb_id)
    {
        // Ambil barang yang dipinjam dan join dengan tabel barang inventaris
        $peminjaman_barang = PeminjamanBarang::with('barangInventaris')
            ->where('pb_id', $pb_id)
            ->get();

        return view('pengembalian.detail', compact('peminjaman_barang'));
    }

    


    public function store(Request $request)
    {
        $validated = $request->validate([
            'pb_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $kembali_id = 'KB' . date('Y-m') . str_pad(Pengembalian ::count() + 1, 4, '0', STR_PAD_LEFT);
            $kembali_tgl = date(now());

            $pengembalian_data = [
                'kembali_id' => $kembali_id,
                'pb_id' => $validated['pb_id'],
                'user_id' => Auth::user()->user_id,
                'kembali_tgl' => $kembali_tgl,                
                'kembali_sts' => '1',
            ];
            print_r($pengembalian_data);


            // Create Peminjaman
            $pengembalian = Pengembalian::create($pengembalian_data);
            print_r($pengembalian);


            $peminjaman_barang = PeminjamanBarang::where('pb_id', $validated['pb_id'])->get();
            print_r($peminjaman_barang);
            // Loop untuk memasukkan data peminjaman barang
            foreach ($peminjaman_barang as $index => $item) {
                print_r($item);

                $peminjaman = PeminjamanBarang::where('pb_id', $validated['pb_id']);
                $peminjaman->update([
                    'pdb_sts' => '0'
                ]);
            }
            
            $peminjaman = Peminjaman::where('pb_id', $validated['pb_id']);
            $peminjaman->update([
                'pb_stat' => '0'
            ]);


            // Commit transaksi jika berhasil
            DB::commit();

        } catch (\Throwable $th) {
            // Rollback jika ada error
            print_r($th->getMessage());
            DB::rollBack();
            \Log::error($th->getMessage());
        }
    }

}

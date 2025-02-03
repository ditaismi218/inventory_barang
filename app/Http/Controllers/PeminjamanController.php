<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\PeminjamanBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PeminjamanController extends Controller
{
    // public function index(){z
    //     // Ambil data barang dari database
    // $peminjaman = DB::table('barang')->select('br_kode', 'br_nama')->get();

    // return view('peminjaman.create', compact('peminjaman'));
    // }
    // public function create()
    // {
    //     return view('peminjaman.create');
    // }

    public function index()
    {
        // Ambil data barang dari database
       
        $peminjaman = Peminjaman::all();

        // print_r($peminjaman);

        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $peminjaman = DB::table('tm_barang_inventaris')
        ->select('tm_barang_inventaris.*', 'latest_peminjaman.pdb_sts')
        ->leftJoinSub(
            DB::table('td_peminjaman_barang')
                ->select('br_kode', 'pdb_sts', 'created_at')
                ->whereIn('br_kode', function ($query) {
                    $query->select('br_kode')
                        ->from('td_peminjaman_barang')
                        ->groupBy('br_kode')
                        ->havingRaw('MAX(created_at) = created_at');
                })
                ->where('pdb_sts', '=', 0), 
            'latest_peminjaman',
            function ($join) {
                $join->on('tm_barang_inventaris.br_kode', '=', 'latest_peminjaman.br_kode');
            }
        )
        ->whereNotIn('tm_barang_inventaris.br_kode', function ($query) {
            $query->select('br_kode')
                ->from('td_peminjaman_barang')
                ->where('pdb_sts', '=', 1);
        })
        ->orderBy('latest_peminjaman.created_at', 'desc')
        ->get();

        // print_r($peminjaman);
        return view('peminjaman.create', compact('peminjaman'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'pb_no_siswa' => 'required',
            'pb_nama_siswa' => 'required',
            'pb_harus_kembali_tgl' => 'required|date',
            'data_peminjaman' => 'required|array',
            'data_peminjaman.*.br_kode' => 'required',
            // 'data_peminjaman.*.pbd_sts' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $pb_id = 'PJ' . date('Y-m') . str_pad(Peminjaman::count() + 1, 4, '0', STR_PAD_LEFT);
            $pb_tgl = date(now());

            // Create Peminjaman
            $peminjaman = Peminjaman::create([
                'pb_id' => $pb_id,
                'user_id' => Auth::user()->user_id,
                'pb_tgl' => $pb_tgl,
                'pb_no_siswa' => $validated['pb_no_siswa'],
                'pb_nama_siswa' => $validated['pb_nama_siswa'],
                'pb_harus_kembali_tgl' => $validated['pb_harus_kembali_tgl'],
                'pb_stat' => '1',
            ]);

            // Loop untuk memasukkan data peminjaman barang
            foreach ($validated['data_peminjaman'] as $index => $item) {
                // Buat ID unik untuk peminjaman barang
                $pbd_id = $pb_id . str_pad($index + 1, 4, '0', STR_PAD_LEFT);

                // Simpan PeminjamanBarang
                $peminjaman_barang = PeminjamanBarang::create([
                    'pbd_id' => $pbd_id,
                    'pb_id' => $peminjaman->pb_id,
                    'br_kode' => $item['br_kode'],
                    'pdb_tanggal' => date(now()),
                    'pdb_sts' => '1',
                ]);

                // dd($peminjaman_barang['pdb_tanggal']);
            }

            // Commit transaksi jika berhasil
            DB::commit();
            return redirect()->route('peminjaman.index')->with('success', 'Data Berhasil ditambahkan');

        } catch (\Throwable $th) {
            // Rollback jika ada error
            DB::rollBack();
            \Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Data gagal ditambahkan');
        }
    }

    public function edit($id)
    {
        // Ambil data peminjaman berdasarkan ID
        $peminjaman = Peminjaman::with('peminjaman_barang')->where('pb_id', $id)->first();

        // Ambil data barang dari database untuk dropdown
        $barang = DB::table('tm_barang_inventaris')->select('br_kode', 'br_nama')->get();

        if (!$peminjaman) {
            return redirect()->route('peminjaman.index')->with('error', 'Data tidak ditemukan');
        }

        return view('peminjaman.edit', compact('peminjaman', 'barang'));
    }

    public function update(Request $request, $pb_id)
    {
        // Validasi data
        $validated = $request->validate([
            'pb_no_siswa' => 'required|max:10',
            'pb_nama_siswa' => 'required|max:50',
            'pb_harus_kembali_tgl' => 'required|date',
        ], [
            'pb_no_siswa.required' => 'Nomor siswa wajib diisi.',
            'pb_no_siswa.max' => 'Nomor siswa maksimal 10 karakter.',
            'pb_nama_siswa.required' => 'Nama siswa wajib diisi.',
            'pb_nama_siswa.max' => 'Nama siswa maksimal 50 karakter.',
            'pb_harus_kembali_tgl.required' => 'Tanggal pengembalian wajib diisi.',
            'pb_harus_kembali_tgl.date' => 'Tanggal pengembalian harus berupa format tanggal yang valid.',
        ]);
    
        // Update data peminjaman
        $peminjaman = Peminjaman::findOrFail($pb_id);
        $peminjaman->update($validated);
    
        // Redirect dengan pesan sukses
        return redirect()->route('peminjaman.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Hapus data peminjaman barang terkait
            PeminjamanBarang::where('pb_id', $id)->delete();

            // Hapus data peminjaman
            $peminjaman = Peminjaman::findOrFail($id);
            $peminjaman->delete();

            DB::commit();
            return redirect()->route('peminjaman.index')->with('success', 'Data Berhasil dihapus');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return redirect()->route('peminjaman.index')->with('error', 'Data gagal dihapus');
        }
    }

    public function show($id)
    {
        // Ambil data peminjaman dan barang terkait
        $data['peminjaman'] = Peminjaman::where('pb_id', $id)->first();
        $data['peminjaman_barang'] = PeminjamanBarang::where('pb_id', $id)->get();

        // if (!$peminjaman) {
        //     return redirect()->route('peminjaman.index')->with('error', 'Data tidak ditemukan');
        // }

        // return view('peminjaman.show', compact('peminjaman', 'peminjaman_barang'));

        return view('peminjaman.show', $data);

        // print_r($peminjaman);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\BarangInventaris;
use App\Models\JenisBarang;
use Auth;
use DB;
use Illuminate\Http\Request;

class BarangInventarisController extends Controller
{
    public function index()
    {

        $data['barangInventaris'] = DB::table('tm_barang_inventaris')
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
        ->orderBy('tm_barang_inventaris.created_at', 'desc')
        ->get();

        $data['users'] = Auth::user()->user_nama;

        foreach ($data['barangInventaris'] as $barang) {
            switch ($barang->br_status) {
                case 1:
                    $barang->br_status = 'Baik';
                    break;
                case 2:
                    $barang->br_status = 'Rusak, dapat diperbaiki';
                    break;
                case 3:
                    $barang->br_status = 'Rusak, tidak dapat digunakan';
                    break;
                default:
                    $barang->br_status = 'Tidak diketahui';
                    break;
            }
        }
        // print_r($data['barangInventaris']);
        return view('daftar-barang.index')->with($data);
    }

    public function create()
    {
        $data['jenisBarangs'] = JenisBarang::all();

        return view('daftar-barang.create')->with($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jns_brg_kode' => 'required',
            'br_nama' => 'required',
            'br_tgl_terima' => 'required',
            'br_status' => 'required',
        ]);

        $current_year = date('Y');
        $last_br = BarangInventaris::where('br_kode', 'like', 'INV' . $current_year . '%')->orderBy('created_at', 'desc')->first()->br_kode;

        // print_r(substr($last_br, 7)+1);
        $current_number = substr($last_br, 7)+1;
        $br_kode = 'INV'  . $current_year . str_pad($current_number, 5, '0', STR_PAD_LEFT);
        // print_r($br_kode);
        $br_tgl_entry = date('Y-m-d');

        BarangInventaris::create([
            'br_kode' => $br_kode,
            'jns_brg_kode' => $validated['jns_brg_kode'],
            'br_nama' => $validated['br_nama'],
            'user_id' => Auth::user()->user_id,
            'br_tgl_terima' => $validated['br_tgl_terima'],
            'br_tgl_entry' => $br_tgl_entry,
            'br_status' => $validated['br_status'],
        ]);

        return redirect()->route('daftar-barang.index')->with('success', 'Data Berhasil ditambahkan');
    }

    public function edit($id)
    {
        $barang = BarangInventaris::findOrFail($id);
        $jenisBarangs = JenisBarang::all();

        return view('daftar-barang.edit', compact('barang', 'jenisBarangs'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'jns_brg_kode' => 'required',
            'br_nama' => 'required',
            'br_tgl_terima' => 'required',
            'br_status' => 'required',
        ]);

        $barang = BarangInventaris::findOrFail($id);
        $barang->update($validated);

        return redirect()->route('daftar-barang.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $barang = BarangInventaris::findOrFail($id);
        $barang->delete();

        return redirect()->route('daftar-barang.index')->with('success', 'Data berhasil dihapus');
    }

}

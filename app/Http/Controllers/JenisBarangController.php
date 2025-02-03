<?php

namespace App\Http\Controllers;

use App\Models\JenisBarang;
use Illuminate\Http\Request;

class JenisBarangController extends Controller
{
    public function index()
    {
        $jenisBarangs = JenisBarang::all();
        return view('jenis_barang.index', compact('jenisBarangs'));
    }

    public function create()
    {
        return view('jenis_barang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'jns_brg_nama' => 'required|string|max:255',
        ]);

        // Ambil kode barang terakhir dari database, urutkan secara descending
        $lastBarang = JenisBarang::orderBy('jns_brg_kode', 'desc')->first();

        if ($lastBarang) {
            // Ekstrak angka dari kode barang terakhir, abaikan 'KB'
            $lastKodeNumber = intval(substr($lastBarang->jns_brg_kode, 2));
            // Tingkatkan angka
            $newKodeNumber = $lastKodeNumber + 1;
            // Format angka dengan leading zero hingga 3 digit
            $newKodeFormatted = str_pad($newKodeNumber, 3, '0', STR_PAD_LEFT);
        } else {
            // Jika tidak ada kode barang sebelumnya, mulai dari 001
            $newKodeFormatted = '001';
        }

        // Gabungkan dengan prefix 'KB'
        $kodeBarang = 'KB' . $newKodeFormatted;

        // Buat entri baru di database
        JenisBarang::create([
            'jns_brg_kode' => $kodeBarang,
            'jns_brg_nama' => $validated['jns_brg_nama'],
        ]);

        return redirect()->route('jenis_barang.index')->with('success', 'Jenis Barang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jenisBarang = JenisBarang::findOrFail($id);
        return view('jenis_barang.edit', compact('jenisBarang'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'jns_brg_nama' => 'required|string|max:255',
        ]);

        $jenisBarang = JenisBarang::findOrFail($id);
        $jenisBarang->update($validated);

        return redirect()->route('jenis_barang.index')->with('success', 'Jenis Barang berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jenisBarang = JenisBarang::findOrFail($id);
        $jenisBarang->delete();

        return redirect()->route('jenis_barang.index')->with('success', 'Jenis Barang berhasil dihapus');
    }
}

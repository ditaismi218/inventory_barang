<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        $jurusan = Jurusan::all();
        return view('kelas.create', compact('jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_nama' => 'required',
            'tingkatan' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:tm_jurusan,jurusan_id'
        ]);

        Kelas::create($request->only(['kelas_nama', 'tingkatan', 'jurusan_id']));

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function edit(Kelas $kelas)
    {
        $jurusan = Jurusan::all();
        return view('kelas.edit', compact('kelas', 'jurusan'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'kelas_nama' => 'required',
            'tingkatan' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:tm_jurusan,jurusan_id'
        ]);
    
        // Update data kelas
        $kelas->update([
            'kelas_nama' => $request->kelas_nama,
            'tingkatan' => $request->tingkatan,
            'jurusan_id' => $request->jurusan_id,
        ]);
    
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui!');
    }    

    public function destroy(Kelas $kelas)
    {
        $kelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus!');
    }
}

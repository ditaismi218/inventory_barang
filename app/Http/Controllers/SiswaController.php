<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jurusan;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with(['kelas', 'jurusan'])->get();
        return view('siswa.index', compact('siswa'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $jurusan = Jurusan::all();
        return view('siswa.create', compact('kelas', 'jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:tm_siswa,nis|max:20',
            'siswa_nama' => 'required|max:100',
            'kelas_id' => 'required|exists:tm_kelas,kelas_id',
            'jurusan_id' => 'required|exists:tm_jurusan,jurusan_id'
        ]);
        
        Siswa::create($request->only(['nis', 'siswa_nama', 'kelas_id', 'jurusan_id']));

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::all();
        $jurusan = Jurusan::all();
        return view('siswa.edit', compact('siswa', 'kelas', 'jurusan'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis' => 'required|max:20|unique:tm_siswa,nis,' . $siswa->siswa_id . ',siswa_id',
            'siswa_nama' => 'required|max:100',
            'kelas_id' => 'required|exists:tm_kelas,kelas_id',
            'jurusan_id' => 'required|exists:tm_jurusan,jurusan_id'
        ]);

        $siswa->update($request->only(['nis', 'siswa_nama', 'kelas_id', 'jurusan_id']));

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil diperbarui!');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus!');
    }
}

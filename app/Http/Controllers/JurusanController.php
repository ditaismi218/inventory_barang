<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::all();
        return view('jurusan.index', compact('jurusan'));
    }

    public function create()
    {
        return view('jurusan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jurusan_nama' => 'required|string|max:100|unique:tm_jurusan,jurusan_nama',
        ]);

        Jurusan::create(['jurusan_nama' => $request->jurusan_nama]);

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil ditambahkan!');
    }

    public function edit(Jurusan $jurusan)
    {
        return view('jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'jurusan_nama' => 'required|string|max:100|unique:tm_jurusan,jurusan_nama,' . $jurusan->jurusan_id . ',jurusan_id',
        ]);

        $jurusan->update(['jurusan_nama' => $request->jurusan_nama]);

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil diperbarui!');
    }

    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();
        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil dihapus!');
    }
}

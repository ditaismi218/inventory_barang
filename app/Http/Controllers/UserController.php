<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Tampilkan daftar user
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Form tambah user
    public function create()
    {
        return view('users.create');
    }

    // Simpan user baru
    public function store(Request $request)
{
    $request->validate([
        'user_nama' => 'required|string|max:50',
        'user_pass' => 'required|string|min:6',
        'user_hak' => 'required|in:SU,OP,AD',
    ]);

    // Ambil user terakhir untuk generate user_id baru
    $lastUser = DB::table('tm_user')->orderBy('user_id', 'desc')->first();
    
    if ($lastUser) {
        // Ambil angka dari ID terakhir, lalu tambah 1
        $lastNumber = (int) substr($lastUser->user_id, 2); // Ambil angka setelah "US"
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT); // Format 4 digit
    } else {
        $newNumber = '0001'; // Jika belum ada user, mulai dari 0001
    }

    $newUserId = 'US' . $newNumber; // Format "US0001"

    // Simpan user baru
    User::create([
        'user_id' => $newUserId,
        'user_nama' => $request->user_nama,
        'user_pass' => $request->user_pass, // Tidak perlu hash di sini, karena sudah otomatis di Model
        'user_hak' => $request->user_hak,
        'user_sts' => '1', // Default aktif
    ]);

    return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
}

    // Form edit user
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'user_nama' => 'required|string|max:50',
            'user_hak' => 'required|in:SU,OP,AD',
            'user_sts' => 'required|in:0,1', // Pastikan status hanya 0 atau 1
        ]);

        $user->update([
            'user_nama' => $request->user_nama,
            'user_hak' => $request->user_hak,
            'user_sts' => $request->user_sts, // Perbarui status juga
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
    }

    // Hapus user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }

    // Aktif/Nonaktifkan user
    public function toggleStatus(User $user)
    {
        $user->update([
            'user_sts' => $user->user_sts === '1' ? '0' : '1',
        ]);

        return redirect()->route('users.index')->with('success', 'Status user berhasil diperbarui!');
    }
}

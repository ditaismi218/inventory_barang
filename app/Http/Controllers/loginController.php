<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input user
        $request->validate([
            'user_nama' => 'required|string',
            'user_pass' => 'required|string',
        ]);

        // Cari user berdasarkan user_nama
        $user = User::where('user_nama', $request->user_nama)->first();

        // Verifikasi apakah user ada dan cocokkan password
        if (!$user || !Hash::check($request->user_pass, $user->user_pass)) {
            return back()->withErrors([
                'user_nama' => 'Username atau password salah.',
            ]);
        }

        // Login user jika validasi berhasil
        Auth::login($user);

        // Redirect ke halaman dashboard setelah login berhasil
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
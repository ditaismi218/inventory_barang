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
    // Validasi input
    $request->validate([
        'user_nama' => 'required|string',
        'user_pass' => 'required|string',
    ]);

    // Cari user berdasarkan username
    $user = User::where('user_nama', $request->user_nama)->first();


    // Jika user tidak ditemukan atau password salah
    if (!$user || !Hash::check($request->user_pass, $user->user_pass)) {
        return back()->withErrors(['user_nama' => 'Username atau password salah.']);
    }

    // Cek apakah user aktif (user_sts = 1)
    if ($user->user_sts == '0') {
        return back()->withErrors(['user_nama' => 'Akun Anda nonaktif. Hubungi admin.']);
    }

    // Login user jika validasi berhasil
    Auth::login($user);

    // Redirect ke dashboard setelah login berhasil
    return redirect()->route('dashboard')->with('success', 'Login berhasil!');
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $request->only('user_nama', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Jika user nonaktif, logout dan beri pesan error
            if (!$user->isActive()) {
                Auth::logout();
                return redirect()->back()->withErrors(['user_nama' => 'Akun Anda tidak aktif. Silakan hubungi administrator.']);
            }

            return true;
        }

        return false;
    }

}
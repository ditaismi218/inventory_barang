<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        // Ambil semua data pengguna dari tabel tm_user
        $users = DB::table('tm_user')->get();

        // Kirim data ke view
        return view('users.index', compact('users'));
    }
}

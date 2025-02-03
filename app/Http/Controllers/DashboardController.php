<?php

namespace App\Http\Controllers;

use App\Models\BarangInventaris;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $username = Auth::user()->user_nama;
        $totalBarang = BarangInventaris::count();
        // $tersedia = BarangInventaris::whereHas('peminjaman_barang', function ($q) {
        //     $q->where('pbd_sts', '0');    
        // })->get();
        $totalPeminjaman = Peminjaman::count();
        return view('dashboard', compact('username', 'totalBarang', 'totalPeminjaman'));
    }
}

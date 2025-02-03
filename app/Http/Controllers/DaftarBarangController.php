<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DaftarBarangController extends Controller
{
    public function index()
    {
        return view('daftar-barang.index');
    }

    public function create()
    {
        return view('daftar-barang.create');
    }
}

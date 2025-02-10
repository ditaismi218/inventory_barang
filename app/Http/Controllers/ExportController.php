<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangInventaris;
use Barryvdh\DomPDF\Facade\Pdf; // Pastikan ini untuk PDF
use Maatwebsite\Excel\Facades\Excel; // Pastikan ini untuk Excel
use App\Exports\BarangExport; // Pastikan ada file ini

class ExportController extends Controller
{
    public function exportPDF()
    {
        $barangInventaris = BarangInventaris::with('jenisBarang')->get();
    
        $pdf = Pdf::loadView('exports.laporan', compact('barangInventaris')); // Harus sesuai dengan nama file di views
        return $pdf->download('laporan-barang.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new BarangExport, 'laporan-barang.xlsx');
    }
    
    public function exportCSV()
    {
        return Excel::download(new BarangExport, 'laporan-barang.csv');
    }
}

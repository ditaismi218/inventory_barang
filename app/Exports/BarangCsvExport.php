<?php

namespace App\Exports;

use App\Models\BarangInventaris;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class BarangCsvExport implements FromCollection, WithHeadings, WithMapping, WithCustomCsvSettings
{
    public function collection()
    {
        return BarangInventaris::with('jenisBarang')
            ->select('br_kode', 'br_nama', 'jns_brg_kode', 'br_tgl_terima', 'br_tgl_entry', 'br_status')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Jenis Barang',
            'Tanggal Terima',
            'Tanggal Masuk',
            'Status'
        ];
    }

    public function map($barang): array
    {
        return [
            $barang->br_kode,
            $barang->br_nama,
            $barang->jenisBarang ? $barang->jenisBarang->jns_brg_nama : 'Tidak Ada',
            $barang->br_tgl_terima ? date('d-m-Y', strtotime($barang->br_tgl_terima)) : 'Tidak Ada',
            date('d-m-Y', strtotime($barang->br_tgl_entry)),
            $barang->br_status == 1 ? 'Tersedia' : 'Tidak Tersedia',
        ];
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ",", // Gunakan koma sebagai pemisah
            'enclosure' => '"', // Gunakan tanda kutip untuk teks
            'line_ending' => "\r\n",
            'output_encoding' => 'UTF-8', // Pastikan encoding UTF-8 agar tidak ada karakter aneh
            'use_bom' => true, // Menggunakan BOM agar Excel tidak rusak
        ];
    }
}

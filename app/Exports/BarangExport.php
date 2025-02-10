<?php

namespace App\Exports;

use App\Models\BarangInventaris;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class BarangExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithEvents
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

    public function columnWidths(): array
    {
        return [
            'A' => 15, // Kode Barang
            'B' => 30, // Nama Barang
            'C' => 25, // Jenis Barang
            'D' => 18, // Tanggal Terima
            'E' => 18, // Tanggal Masuk
            'F' => 15, // Status
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                // 🔹 Tambahkan border ke seluruh data
                $sheet->getStyle("A1:F{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                // 🔹 Styling header
                $sheet->getStyle('A1:F1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                        'size' => 12,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '0073e6'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // 🔹 Tinggikan row header agar lebih rapi
                $sheet->getRowDimension(1)->setRowHeight(20);

                // 🔹 Format tanggal agar lebih rapi
                $sheet->getStyle("D2:D{$highestRow}")->getNumberFormat()->setFormatCode('DD-MM-YYYY');
                $sheet->getStyle("E2:E{$highestRow}")->getNumberFormat()->setFormatCode('DD-MM-YYYY');

                // 🔹 Rata tengah kolom status
                $sheet->getStyle("F2:F{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}

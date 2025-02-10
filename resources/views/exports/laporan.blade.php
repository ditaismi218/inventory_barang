<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h2>Laporan Barang Inventaris</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jenis Barang</th>
                <th>Tanggal Terima</th>
                <th>Tanggal Masuk</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangInventaris as $index => $barang)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $barang->br_kode }}</td>
                    <td>{{ $barang->br_nama }}</td>
                    <td>{{ $barang->jenisBarang->jns_brg_nama ?? 'Tidak Ada' }}</td>
                    <td>{{ $barang->br_tgl_terima ?? 'Tidak ada' }}</td>
                    <td>{{ $barang->br_tgl_entry }}</td> 
                    <td>Tersedia</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

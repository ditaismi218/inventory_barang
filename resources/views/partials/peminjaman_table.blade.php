<table class="table table-striped">
    <thead>
        <tr>
            <th>ID Peminjaman</th>
            <th>Nama Siswa</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Harus Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($peminjamans as $item)
        <tr>
            <td>{{ $item->pb_id }}</td>
            <td>{{ $item->siswa->siswa_nama ?? 'Nama Tidak Tersedia' }}</td>
            <td>{{ $item->pb_tgl }}</td>
            <td>{{ $item->pb_harus_kembali_tgl }}</td>
            <td>
                @if ($item->pb_stat == '0')
                    <span class="badge bg-success">Sudah Dikembalikan</span>
                @else
                    <span class="badge bg-danger">Belum Dikembalikan</span>
                @endif
            </td>
            <td>
                <a href="{{ route('peminjaman.show', $item->pb_id) }}" class="btn btn-primary btn-sm">Detail Barang</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Tambahkan pagination -->
<div class="d-flex justify-content-center">
    {{ $peminjamans->links() }}
</div>

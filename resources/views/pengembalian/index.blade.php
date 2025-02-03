@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Barang Belum Kembali</h2>

    <!-- Menampilkan pesan jika ada success atau error -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tabel Daftar Peminjaman -->
    <table class="table table-bordered">
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
            @foreach ($peminjaman as $item)
            <tr>
                <td>{{ $item->pb_id }}</td>
                <td>{{ $item->pb_nama_siswa }}</td>
                <td>{{ $item->pb_tgl }}</td>
                <td>{{ $item->pb_harus_kembali_tgl }}</td>
                {{-- <td>{{ $item->pb_stat }}</td> --}}
                <td>{{ ($item->pb_stat == '0' ? 'Sudah Dikembalikan' : 'Belum Dikembalikan') }}</td>
                <td>
                    <!-- Tombol untuk melihat detail barang -->
                    <button data-id="{{ $item->pb_id }}" class="btn btn-info btn-sm btn-kembali">
                        Kembalikan Barang
                    </button>
                   
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('.btn-kembali').click(function() {
            Swal.fire({
                title: 'Konfirmasi',
                text: "Apakah Anda yakin data ini akan dikembalikan?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, kembalikan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                   const url = "{{ url( 'pengembalian/create') }}/" ;
                   const pb_id = $(this).data('id');
                   const data = {
                       _token: '{{ csrf_token() }}',
                       pb_id: pb_id
                   
                   }
                   console.log(url, pb_id);
                //    $.post(url, {
                //        _token: '{{ csrf_token() }}',
                //        pb_id: pb_id
                //    }, function(response) {
                //        location.reload();
                //    }}

                $.post(url,data,function(response){
                    location.reload();
                })
                
                }
            })
        });
    });
</script>
@endsection


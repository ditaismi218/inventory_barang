@extends('layouts.layout')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-description">Tambah Peminjaman</h4>
                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="pb_no_siswa">No Siswa</label>
                        <input type="text" name="pb_no_siswa" id="pb_no_siswa" class="form-control" required placeholder="Nomor Siswa">
                    </div>
    
                    <div class="form-group">
                        <label for="pb_nama_siswa">Nama Siswa</label>
                        <input type="text" name="pb_nama_siswa" id="pb_nama_siswa" class="form-control" required placeholder="Nama Siswa">
                    </div>
    
                    <div class="form-group">
                        <label for="pb_harus_kembali_tgl">Harus Kembali Tanggal</label>
                        <input type="date" name="pb_harus_kembali_tgl" id="pb_harus_kembali_tgl" class="form-control" required>
                    </div>
    
                    <div id="dynamic-fields">
                        <label>Data Peminjaman:</label>
                        <div class="form-group field-group">
                            <select name="data_peminjaman[0][br_kode]" id="br_kode" class="form-control">
                                @foreach ($peminjaman as $item)
                                    <option value="{{ $item->br_kode }}">{{ $item->br_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
    
                    <button type="button" class="btn btn-secondary" onclick="addField()">Tambah Barang</button>
                    <button type="submit" class="btn btn-gradient-primary me-2">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        let fieldCount = 1;
        function addField() {
            let fields = `
                <div class="form-group field-group">
 <select name="data_peminjaman[${fieldCount}][br_kode]" class="form-control">
                        @foreach ($peminjaman as $item)
                            <option value="{{ $item->br_kode }}">{{ $item->br_nama }}</option>
                        @endforeach
                    </select>
                </div>
            `;
            document.getElementById('dynamic-fields').insertAdjacentHTML('beforeend', fields);
            fieldCount++;
        }
    </script>
@endsection

@extends('layouts.layout')

@section('content')

@if(session('success'))
<script>
    localStorage.removeItem('selectedItems');
    localStorage.removeItem('formPeminjaman');
    setTimeout(() => {
        location.reload(); // Refresh halaman untuk membersihkan cache LocalStorage
    }, 500);
</script>
@endif



@if ($errors->any())
    <div class="alert alert-danger mb-4">
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
            <h4 class="card-description text-xl font-semibold mb-4">Tambah Peminjaman</h4>
            <form id="form-peminjaman" action="{{ route('peminjaman.store') }}" method="POST">
                @csrf

                <!-- Penanggung Jawab -->
                <div class="form-group mb-4">
                    <label class="block mb-2.5 font-medium text-black dark:text-white">Penanggung Jawab</label>
                    <input type="text" class="form-control w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary text-black dark:text-white" value="{{ Auth::user()->user_nama }}" disabled>
                    <input type="hidden" name="user_id" value="{{ Auth::user()->user_nama }}">
                </div>

                <!-- Row untuk No Siswa dan Nama Siswa -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="siswa_id" class="mb-2.5 block font-medium text-black dark:text-white">Nama Siswa</label>
                        <select name="siswa_id" id="siswa_id" class="form-control w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary text-black dark:text-white" required>
                            <option value="">Pilih Nama Siswa</option>
                            @foreach ($siswas as $siswa)
                                <option value="{{ $siswa->siswa_id }}">
                                    {{ $siswa->siswa_nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <!-- Tanggal Pengembalian -->
                <div class="form-group mb-4">
                    <label for="pb_harus_kembali_tgl" class="mb-2.5 block font-medium text-black dark:text-white">Harus Kembali Tanggal</label>
                    <input type="date" name="pb_harus_kembali_tgl" id="pb_harus_kembali_tgl" class="form-control w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary text-black dark:text-white" required>
                </div>

                <!-- Tabel Barang -->
                <div id="barang-daftar-container" class="table-responsive mt-4">
                    <label>Daftar Barang:</label>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Input untuk mencari barang -->
                            <div class="mb-3 mt-3">
                                <input type="text" id="search-barang" class="form-control" placeholder="Cari barang...">
                            </div>
                            @foreach ($peminjaman as $index => $item)
                            <tr id="row-{{ $item->br_kode }}">
                                <td>{{ $index + 1 + ($peminjaman->currentPage() - 1) * $peminjaman->perPage() }}</td>
                                <td>{{ $item->br_kode }}</td>
                                <td>{{ $item->br_nama }}</td>
                                <td>
                                    @if ($item->br_status == 1)
                                        <span class="badge badge-success">Baik</span>
                                    @elseif ($item->br_status == 2)
                                        <span class="badge badge-warning">Rusak, dapat diperbaiki</span>
                                    @elseif ($item->br_status == 3)
                                        <span class="badge badge-danger">Rusak, tidak dapat diperbaiki</span>
                                    @else
                                        <span class="badge badge-secondary">Tidak Diketahui</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" 
                                            onclick="tambahBarang('{{ $item->br_kode }}', '{{ $item->br_nama ?? '-' }}')"
                                            {{ in_array($item->br_status, [2, 3]) ? 'disabled' : '' }}>
                                        Tambah
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>                        
                    </table>
                
                    <div class="justify-content-end mt-3">
                        {{ $peminjaman->links('pagination::bootstrap-5') }}
                    </div>                    
                </div>                

                <!-- Tabel Barang yang Dipilih -->
                <div class="table-responsive mt-4">
                    <h5 class="text-lg font-semibold">Barang yang Dipilih:</h5>
                    <table class="table table-bordered" id="table-barang-terpilih">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn btn-gradient-primary mt-4 w-full py-3 text-white text-lg font-semibold">Simpan</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('siswa_id').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];
        document.getElementById('siswa_nama').value = selectedOption.dataset.nama || '';
    });
</script>

<script>
    // Variabel counter hanya untuk penomoran tampilan (tidak digunakan untuk nama input final)
    let displayCounter = 1;

    // Fungsi untuk menambahkan barang ke tabel "Barang yang Dipilih"
    // Parameter tambahan: fromStorage (default false) untuk menandai data berasal dari localStorage
    function tambahBarang(kode, nama, fromStorage = false) {
        // Cek apakah barang sudah ditambahkan
        if (document.getElementById("barang-" + kode)) {
            if (!fromStorage) {
                alert("Barang sudah ditambahkan!");
            }
            return;
        }

        let table = document.querySelector("#table-barang-terpilih tbody");
        let row = `    
            <tr id="barang-${kode}">
                <td>${displayCounter}</td>
                <td>${kode}</td>
                <td>${nama}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusBarang('${kode}')">Hapus</button>
                    <!-- Nama input akan diupdate oleh fungsi updateInputNames() -->
                    <input type="hidden" class="input-br-kode" value="${kode}">
                </td>
            </tr>
        `;
        table.insertAdjacentHTML("beforeend", row);
        displayCounter++;

        // Nonaktifkan tombol "Tambah" di daftar barang
        let btn = document.querySelector(`#row-${kode} button`);
        if (btn) {
            btn.disabled = true;
        }

        // Jika barang ditambahkan secara langsung (bukan dari localStorage), simpan ke localStorage
        if (!fromStorage) {
            simpanKeLocalStorage(kode, nama);
        }

        // Update nama-nama input agar sesuai dengan format yang divalidasi di backend
        updateInputNames();
    }

    // Fungsi untuk menghapus barang dari tabel "Barang yang Dipilih"
    function hapusBarang(kode) {
        // Hapus dari tabel
        let row = document.getElementById("barang-" + kode);
        if (row) row.remove();

        // Aktifkan kembali tombol "Tambah" di daftar barang
        let btn = document.querySelector(`#row-${kode} button`);
        if (btn) {
            btn.disabled = false;
        }

        // Perbarui nomor urut tampilan
        resetDisplayCounter();

        // Hapus dari localStorage
        hapusDariLocalStorage(kode);

        // Update nama-nama input
        updateInputNames();
    }

    // Fungsi untuk mereset nomor urut tampilan
    function resetDisplayCounter() {
        let rows = document.querySelectorAll("#table-barang-terpilih tbody tr");
        displayCounter = 1;
        rows.forEach(row => {
            row.querySelector('td').innerText = displayCounter;
            displayCounter++;
        });
    }

    // Fungsi untuk memperbarui nama attribute input hidden sesuai dengan format:
    // data_peminjaman[INDEX][br_kode]
    function updateInputNames() {
        let rows = document.querySelectorAll("#table-barang-terpilih tbody tr");
        rows.forEach((row, index) => {
            let hiddenInput = row.querySelector('input.input-br-kode');
            if (hiddenInput) {
                hiddenInput.name = `data_peminjaman[${index}][br_kode]`;
            }
        });
    }

    // Simpan barang yang dipilih ke localStorage
    function simpanKeLocalStorage(kode, nama) {
        let selectedItems = JSON.parse(localStorage.getItem('selectedItems') || '[]');
        if (!selectedItems.find(item => item.kode === kode)) {
            selectedItems.push({ kode: kode, nama: nama });
            localStorage.setItem('selectedItems', JSON.stringify(selectedItems));
        }
    }

    // Hapus barang dari localStorage
    function hapusDariLocalStorage(kode) {
        let selectedItems = JSON.parse(localStorage.getItem('selectedItems') || '[]');
        selectedItems = selectedItems.filter(item => item.kode !== kode);
        localStorage.setItem('selectedItems', JSON.stringify(selectedItems));
    }

    // Muat ulang barang yang telah dipilih dari localStorage ketika halaman di-load
    document.addEventListener("DOMContentLoaded", function(){
        let selectedItems = JSON.parse(localStorage.getItem('selectedItems') || '[]');
        selectedItems.forEach(item => {
            tambahBarang(item.kode, item.nama, true);
        });
    });

    // Sebelum form disubmit, pastikan setidaknya ada 1 barang yang dipilih
    document.querySelector("#form-peminjaman").addEventListener("submit", function(e) {
        let selectedItems = JSON.parse(localStorage.getItem('selectedItems') || '[]');
        if(selectedItems.length === 0) {
            e.preventDefault();
            alert("Pilih minimal 1 barang sebelum disimpan.");
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Ambil data yang tersimpan di localStorage
        if (localStorage.getItem("formPeminjaman")) {
            let formData = JSON.parse(localStorage.getItem("formPeminjaman"));

            document.getElementById("pb_no_siswa").value = formData.pb_no_siswa || "";
            document.getElementById("pb_nama_siswa").value = formData.pb_nama_siswa || "";
            document.getElementById("pb_harus_kembali_tgl").value = formData.pb_harus_kembali_tgl || "";
        }

        Simpan data sebelum pindah halaman
        document.querySelectorAll("a.page-link").forEach(function (link) {
            link.addEventListener("click", function () {
                let formData = {
                    pb_no_siswa: document.getElementById("pb_no_siswa").value,
                    pb_nama_siswa: document.getElementById("pb_nama_siswa").value,
                    pb_harus_kembali_tgl: document.getElementById("pb_harus_kembali_tgl").value
                };

                localStorage.setItem("formPeminjaman", JSON.stringify(formData));
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
    // Ambil data yang tersimpan di localStorage
    if (localStorage.getItem("formPeminjaman")) {
        let formData = JSON.parse(localStorage.getItem("formPeminjaman"));

        document.getElementById("siswa_id").value = formData.siswa_id || "";
        document.getElementById("pb_harus_kembali_tgl").value = formData.pb_harus_kembali_tgl || "";
    }

    // Simpan data ke localStorage setiap kali ada perubahan
    document.getElementById("siswa_id").addEventListener("change", function () {
        simpanDataForm();
    });

    document.getElementById("pb_harus_kembali_tgl").addEventListener("change", function () {
        simpanDataForm();
    });

    // Simpan data sebelum pindah halaman (pagination)
    document.querySelectorAll("a.page-link").forEach(function (link) {
        link.addEventListener("click", function () {
            simpanDataForm();
        });
    });

    // Hapus data dari localStorage setelah submit berhasil
    document.querySelector("#form-peminjaman").addEventListener("submit", function () {
        localStorage.removeItem('selectedItems');
        localStorage.removeItem("formPeminjaman");
    });
});

// Fungsi untuk menyimpan data form ke localStorage
function simpanDataForm() {
    let formData = {
        siswa_id: document.getElementById("siswa_id").value,
        pb_harus_kembali_tgl: document.getElementById("pb_harus_kembali_tgl").value
    };

    localStorage.setItem("formPeminjaman", JSON.stringify(formData));
}


        // Bersihkan localStorage setelah submit berhasil
        document.querySelector("#form-peminjaman").addEventListener("submit", function() {
            localStorage.removeItem('selectedItems'); // Hapus daftar barang yang dipilih
            localStorage.removeItem("formPeminjaman"); // Hapus data form yang tersimpan
        });
    });

    document.getElementById("search-barang").addEventListener("keyup", function() {
    let searchValue = this.value;

    // Kirim permintaan AJAX ke server
    fetch("{{ route('peminjaman.search') }}?q=" + searchValue, {
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        }
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById("table-body-barang").innerHTML = data;
    });
});

// Fungsi untuk mencari barang dalam tabel
document.getElementById("search-barang").addEventListener("keyup", function() {
    let searchValue = this.value.toLowerCase();
    let rows = document.querySelectorAll("#barang-daftar-container tbody tr");

    rows.forEach(row => {
        let namaBarang = row.children[2].textContent.toLowerCase(); // Ambil teks nama barang
        if (namaBarang.includes(searchValue)) {
            row.style.display = ""; // Tampilkan baris
        } else {
            row.style.display = "none"; // Sembunyikan baris
        }
    });
});


</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    // Ambil data yang tersimpan di localStorage
    if (localStorage.getItem("formPeminjaman")) {
        let formData = JSON.parse(localStorage.getItem("formPeminjaman"));

        document.getElementById("siswa_id").value = formData.siswa_id || "";
        document.getElementById("pb_harus_kembali_tgl").value = formData.pb_harus_kembali_tgl || "";
    }

    // Simpan data ke localStorage setiap kali ada perubahan
    document.getElementById("siswa_id").addEventListener("change", function () {
        simpanDataForm();
    });

    document.getElementById("pb_harus_kembali_tgl").addEventListener("change", function () {
        simpanDataForm();
    });

    // Simpan data sebelum pindah halaman (pagination)
    document.querySelectorAll("a.page-link").forEach(function (link) {
        link.addEventListener("click", function () {
            simpanDataForm();
        });
    });

    // Hapus data dari localStorage setelah submit berhasil
    document.querySelector("#form-peminjaman").addEventListener("submit", function () {
        localStorage.removeItem('selectedItems');
        localStorage.removeItem("formPeminjaman");
    });

    // Muat ulang barang yang telah dipilih dari localStorage ketika halaman di-load
    let selectedItems = JSON.parse(localStorage.getItem('selectedItems') || '[]');
    selectedItems.forEach(item => {
        tambahBarang(item.kode, item.nama, true);
    });
});

// Fungsi untuk menyimpan data form ke localStorage
function simpanDataForm() {
    let formData = {
        siswa_id: document.getElementById("siswa_id").value,
        pb_harus_kembali_tgl: document.getElementById("pb_harus_kembali_tgl").value
    };

    localStorage.setItem("formPeminjaman", JSON.stringify(formData));
}

// Fungsi pencarian barang
document.getElementById("search-barang").addEventListener("keyup", function() {
    let searchValue = this.value.toLowerCase();
    let rows = document.querySelectorAll("#barang-daftar-container tbody tr");

    rows.forEach(row => {
        let namaBarang = row.children[2].textContent.toLowerCase(); // Ambil teks nama barang
        if (namaBarang.includes(searchValue)) {
            row.style.display = ""; // Tampilkan baris
        } else {
            row.style.display = "none"; // Sembunyikan baris
        }
    });
});
</script>


@endsection

@extends('layouts.layout')

@section('content')
<!-- Dashboard Content -->
<div class="row">

  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-home"></i>
      </span> Dashboard
    </h3>
    <nav aria-label="breadcrumb">
      <ul class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
          <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
        </li>
      </ul>
    </nav>
  </div>
    <!-- Jumlah Barang yang Sudah Dientry -->
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
          <div class="card-body">
            <img src="{{ asset('asset') }}/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
            <h4 class="font-weight-normal mb-3">Total Barang <i class="mdi mdi-chart-line mdi-24px float-end"></i>
            </h4>
            <h2 class="mb-2">{{ $totalBarang }}</h2>
            {{-- <h6 class="card-text">Barang</h6> --}}
          </div>
        </div>
      </div>

      <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
          <div class="card-body">
            <img src="{{ asset('asset') }}/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
            <h4 class="font-weight-normal mb-3">Total Barang <br> Tersedia <i class="mdi mdi-chart-line mdi-24px float-end"></i>
            </h4>
            <h2 class="mb-2">{{ $tersedia }}</h2>
            {{-- <h6 class="card-text">Barang</h6> --}}
          </div>
        </div>
      </div>
      <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
          <div class="card-body">
            <img src="{{ asset('asset') }}/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
            <h4 class="font-weight-normal mb-3">Total Barang Tidak Tersedia <i class="mdi mdi-chart-line mdi-24px float-end"></i>
            </h4>
            <h2 class="mb-2">{{ $tidak_tersedia }}</h2>
            {{-- <h6 class="card-text">Barang</h6> --}}
          </div>
        </div>
      </div>

    <!-- Jumlah Barang Rusak -->
    <div class="col-md-6 stretch-card grid-margin">
      <div class="card bg-gradient-primary card-img-holder text-white">
        <div class="card-body">
          <img src="{{ asset('asset') }}/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
          <h4 class="font-weight-normal mb-3">Total Barang Rusak <i class="mdi mdi-bookmark-outline mdi-24px float-end"></i>
          </h4>
          <h2 class="mb-2">{{ $barangRusak }}</h2>
          {{-- <h6 class="card-text">Decreased by 10%</h6> --}}
        </div>
      </div>
    </div>

    <!-- Jumlah Transaksi Peminjaman -->
    <div class="col-md-6 stretch-card grid-margin">
      <div class="card bg-gradient-dark card-img-holder text-white">
        <div class="card-body">
          <img src="{{ asset('asset') }}/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
          <h4 class="font-weight-normal mb-3">Jumlah Transaksi Peminjaman <i class="mdi mdi-bookmark-outline mdi-24px float-end"></i>
          </h4>
          <h2 class="mb-2">{{ $totalPeminjaman }}</h2>
          {{-- <h6 class="card-text">Decreased by 10%</h6> --}}
        </div>
      </div>
    </div>

    {{-- <h1>{{$durasi_peminjaman}}</h1> --}}

    <div class="mb-4">
      @if(!$durasi_peminjaman->isEmpty())
        <div class="alert alert-warning d-flex align-items-center shadow-sm fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <div>
                <strong>Pemberitahuan!</strong> Ada peminjaman dalam rentang tanggal <span class="fw-bold">{{ $date_from }}</span> hingga <span class="fw-bold">{{ $date_to }}</span>.
                <ul class="mt-2 mb-0 ps-3">
                    @foreach ($durasi_peminjaman as $data)
                        <li class="text-dark fw-medium">
                          📌 {{ $data->siswa->siswa_nama ?? 'Tidak Ada Nama' }} - 
                          <span class="text-primary">{{ $data->pb_harus_kembali_tgl }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
      @else
        <div class="alert alert-success d-flex align-items-center shadow-sm fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div>
                ✅ <strong>Tidak ada peminjaman</strong> dalam rentang tanggal <span class="fw-bold">{{ $date_from }}</span> hingga <span class="fw-bold">{{ $date_to }}</span>.
            </div>
        </div>
      @endif
    </div>

    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="clearfix">
            <h4 class="card-title float-start">Grafik Peminjaman Perhari</h4>
            <div id="visit-sale-chart-legend" class="rounded-legend legend-horizontal legend-top-right float-end"></div>
          </div>
          <canvas id="visit-sale-chart" class="mt-4"></canvas>
        </div>
      </div>
    </div>
    @endsection


<script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
<script src="{{ asset('asset') }}/assets/js/jquery.cookie.js"></script>
@push('script')  
<script>
  if ($("#visit-sale-chart").length) {
    const ctx = document.getElementById('visit-sale-chart').getContext("2d");

    var dailyLabels = {!! json_encode($dailyLabels) !!};
    var dailyValues = {!! json_encode($dailyValues) !!};

    var graphGradient = ctx.createLinearGradient(0, 0, 0, 300);
    graphGradient.addColorStop(0, 'rgba(255, 191, 150, 1)');
    graphGradient.addColorStop(1, 'rgba(254, 112, 150, 1)');

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: dailyLabels,
        datasets: [
          {
            label: "Jumlah Peminjaman",
            borderColor: "rgba(254, 112, 150, 1)", // Warna garis
            backgroundColor: graphGradient, // Warna batang dengan efek gradient
            borderWidth: 1,
            data: dailyValues,
            barPercentage: 0.5,
            categoryPercentage: 0.5,
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: "Jumlah Peminjaman"
            },
            grid: {
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
            }
          },
          x: {
            title: {
              display: true,
              text: "Tanggal"
            },
            grid: {
              display: false,
            }
          }
        },
        plugins: {
          legend: {
            display: false,
          }
        }
      }
    });
  }
</script>

@endpush




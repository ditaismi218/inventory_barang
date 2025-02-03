@extends('layouts.layout')

@section('content')
<!-- Dashboard Content -->
<div class="row">
    <!-- Jumlah Barang yang Sudah Dientry -->
    <div class="col-md-6 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
          <div class="card-body">
            <img src="{{ asset('asset') }}/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
            <h4 class="font-weight-normal mb-3">Jumlah Barang yang Dientry <i class="mdi mdi-chart-line mdi-24px float-end"></i>
            </h4>
            <h2 class="mb-5">{{ $totalBarang }}</h2>
            {{-- <h6 class="card-text">Barang</h6> --}}
          </div>
        </div>
      </div>

    <!-- Jumlah Transaksi Peminjaman -->
    <div class="col-md-6 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
          <div class="card-body">
            <img src="{{ asset('asset') }}/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
            <h4 class="font-weight-normal mb-3">Jumlah Transaksi Peminjaman <i class="mdi mdi-bookmark-outline mdi-24px float-end"></i>
            </h4>
            <h2 class="mb-5">{{ $totalPeminjaman }}</h2>
            {{-- <h6 class="card-text">Decreased by 10%</h6> --}}
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="clearfix">
              <h4 class="card-title float-start">Visit And Sales Statistics</h4>
              <div id="visit-sale-chart-legend" class="rounded-legend legend-horizontal legend-top-right float-end"></div>
            </div>
            <canvas id="visit-sale-chart" class="mt-4"></canvas>
          </div>
        </div>
      </div>


@endsection



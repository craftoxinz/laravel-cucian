@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<!-- Menggunakan ApexCharts bawaan Tabler untuk grafik yang modern -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0/dist/apexcharts.min.js"></script>
@endpush

@section('content')

<!-- ===== ROW 1: KARTU STATISTIK UTAMA ===== -->
<div class="row row-cards mb-3">

  <!-- Card Order Masuk Hari Ini -->
  <div class="col-sm-6 col-xl-3">
    <div class="card card-sm">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-auto">
            <span class="bg-primary text-white avatar" style="border-radius: 8px;">
              <i class="ti ti-receipt fs-2"></i>
            </span>
          </div>
          <div class="col text-truncate">
            <div class="font-weight-medium text-heading fs-3">{{ $stats['order_hari_ini'] }} Order</div>
            <div class="text-secondary small">Masuk hari ini</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Card Pendapatan Hari Ini -->
  <div class="col-sm-6 col-xl-3">
    <div class="card card-sm">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-auto">
            <span class="bg-green text-white avatar" style="border-radius: 8px;">
              <i class="ti ti-cash fs-2"></i>
            </span>
          </div>
          <div class="col text-truncate">
            <div class="font-weight-medium text-heading fs-3">Rp {{ number_format($stats['pendapatan_hari_ini'], 0, ',', '.') }}</div>
            <div class="text-secondary small">Pendapatan hari ini</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Card Pendapatan Bulan Ini -->
  <div class="col-sm-6 col-xl-3">
    <div class="card card-sm">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-auto">
            <span class="bg-blue text-white avatar" style="border-radius: 8px;">
              <i class="ti ti-chart-bar fs-2"></i>
            </span>
          </div>
          <div class="col text-truncate">
            <div class="font-weight-medium text-heading fs-3">Rp {{ number_format($stats['pendapatan_bulan'], 0, ',', '.') }}</div>
            <div class="text-secondary small">Pendapatan bulan ini</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Card Pelanggan Terdaftar -->
  <div class="col-sm-6 col-xl-3">
    <div class="card card-sm">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-auto">
            <span class="bg-cyan text-white avatar" style="border-radius: 8px;">
              <i class="ti ti-users fs-2"></i>
            </span>
          </div>
          <div class="col text-truncate">
            <div class="font-weight-medium text-heading fs-3">{{ $stats['total_pelanggan'] }} Pelanggan</div>
            <div class="text-secondary small">Terdaftar aktif</div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- ===== ROW 2: DETAIL INDIKATOR STATUS ANTREAN ===== -->
<div class="row row-cards mb-3">

  <!-- Status Antre -->
  <div class="col-md-4">
    <div class="card card-stacked">
      <!-- Border accent tipis di sebelah kiri card untuk petunjuk warna status -->
      <div class="card-status-start bg-warning"></div>
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="subheader tracking-wider">Antrean Masuk</div>
          <div class="ms-auto">
            <span class="bg-warning-lt text-warning avatar avatar-sm" style="border-radius: 6px;">
              <i class="ti ti-clock fs-3"></i>
            </span>
          </div>
        </div>
        <div class="d-flex align-items-baseline my-2">
          <div class="h1 mb-0 me-2 text-heading" style="font-size: 2.2rem;">{{ $stats['order_antri'] }}</div>
          <span class="text-secondary small">Nota</span>
        </div>
        <div class="progress progress-xs mt-2">
          <div class="progress-bar bg-warning" style="width: 100%"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Status Diproses -->
  <div class="col-md-4">
    <div class="card card-stacked">
      <div class="card-status-start bg-blue"></div>
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="subheader tracking-wider">Sedang Diproses</div>
          <div class="ms-auto">
            <span class="bg-blue-lt text-blue avatar avatar-sm" style="border-radius: 6px;">
              <i class="ti ti-refresh fs-3"></i>
            </span>
          </div>
        </div>
        <div class="d-flex align-items-baseline my-2">
          <div class="h1 mb-0 me-2 text-heading" style="font-size: 2.2rem;">{{ $stats['order_proses'] }}</div>
          <span class="text-secondary small">Nota</span>
        </div>
        <div class="progress progress-xs mt-2">
          <div class="progress-bar bg-blue" style="width: 100%"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Status Siap Diambil -->
  <div class="col-md-4">
    <div class="card card-stacked">
      <div class="card-status-start bg-green"></div>
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="subheader tracking-wider">Selesai (Siap Ambil)</div>
          <div class="ms-auto">
            <span class="bg-green-lt text-green avatar avatar-sm" style="border-radius: 6px;">
              <i class="ti ti-check fs-3"></i>
            </span>
          </div>
        </div>
        <div class="d-flex align-items-baseline my-2">
          <div class="h1 mb-0 me-2 text-heading" style="font-size: 2.2rem;">{{ $stats['order_selesai'] }}</div>
          <span class="text-secondary small">Nota</span>
        </div>
        <div class="progress progress-xs mt-2">
          <div class="progress-bar bg-green" style="width: 100%"></div>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- ===== ROW 3: GRAFIK PENDAPATAN & ANTRIAN TERBARU ===== -->
<div class="row row-cards">

  <!-- Column Grafik Pendapatan -->
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header border-0 pb-0">
        <div>
          <h3 class="card-title text-heading">Pendapatan 7 Hari Terakhir</h3>
          <p class="text-secondary small mb-0">Statistik fluktuasi total setoran harian</p>
        </div>
      </div>
      <div class="card-body">
        <div id="chart-revenue" style="min-height: 250px;"></div>
      </div>
    </div>
  </div>

  <!-- Column Order Terbaru -->
  <div class="col-lg-4">
    <div class="card d-flex flex-column" style="max-height: 350px;">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div>
          <h3 class="card-title text-heading">Order Terbaru</h3>
          <p class="text-secondary small mb-0">Transaksi yang masuk belakangan ini</p>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary" style="border-radius: 6px;">
          Lihat Semua
        </a>
      </div>
      
      <div class="list-group list-group-flush overflow-auto flex-fill">
        @forelse($recentOrders as $order)
        <a href="{{ route('orders.show', $order) }}" class="list-group-item list-group-item-action px-3 py-2.5">
          <div class="row align-items-center">
            <div class="col-auto">
              <span class="avatar avatar-sm bg-primary-lt text-primary fw-bold" style="border-radius: 6px;">
                <i class="ti ti-receipt fs-3"></i>
              </span>
            </div>
            <div class="col text-truncate">
              <div class="font-weight-medium text-heading text-truncate">{{ $order->kode_order }}</div>
              <div class="text-secondary small text-truncate">{{ $order->pelanggan->nama }}</div>
            </div>
            <div class="col-auto">
              <span class="badge badge-outline text-{{ $order->status_badge }} rounded-pill px-2.5 py-1">
                {{ $order->status_label }}
              </span>
            </div>
          </div>
        </a>
        @empty
        <div class="text-center text-secondary py-5 flex-fill d-flex flex-column justify-content-center align-items-center">
          <div class="avatar avatar-md bg-muted-lt mb-2" style="border-radius: 8px;">
            <i class="ti ti-inbox fs-2 text-secondary"></i>
          </div>
          <div class="fw-semibold">Tidak Ada Data</div>
          <p class="small text-muted mb-0">Belum ada order laundry yang tercatat.</p>
        </div>
        @endforelse
      </div>
    </div>
  </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
  // Setup Chart Revenue dengan rendering modern & responsive (menggunakan ApexCharts)
  window.ApexCharts && (new ApexCharts(document.getElementById('chart-revenue'), {
    chart: {
      type: "area",
      fontFamily: 'inherit',
      height: 250,
      parentHeightOffset: 0,
      toolbar: { show: false },
      animations: { enabled: true, easing: 'easeinout', speed: 800 },
    },
    dataLabels: { enabled: false },
    fill: { 
      type: 'gradient',
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.35,
        opacityTo: 0.05,
        stops: [0, 90, 100]
      }
    },
    stroke: {
      curve: 'smooth',
      width: 2.5
    },
    series: [{
      name: "Pendapatan",
      data: @json($revenues)
    }],
    tooltip: {
      theme: 'dark',
      y: {
        formatter: val => 'Rp ' + new Intl.NumberFormat('id-ID').format(val)
      }
    },
    grid: {
      padding: { top: -10, right: 0, left: -4, bottom: -4 },
      strokeDashArray: 4,
    },
    xaxis: {
      labels: { padding: 4, style: { colors: 'var(--tblr-secondary)' } },
      tooltip: { enabled: false },
      axisBorder: { show: false },
      categories: @json($labels),
    },
    yaxis: {
      labels: {
        padding: 4,
        style: { colors: 'var(--tblr-secondary)' },
        formatter: val => 'Rp ' + new Intl.NumberFormat('id-ID', { notation: "compact" }).format(val)
      }
    },
    colors: ['#0054a6'],
    legend: { show: false },
  })).render();
});
</script>
@endpush
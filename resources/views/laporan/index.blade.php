@extends('layouts.app')

@section('title', 'Laporan')
@section('page-title', 'Laporan Transaksi')

@section('page-actions')
<a href="{{ route('laporan.pdf', ['bulan'=>$bulan,'tahun'=>$tahun]) }}" class="btn btn-outline-danger d-flex align-items-center gap-1" style="border-radius: 6px;">
  <i class="ti ti-file-type-pdf fs-2"></i> Export PDF
</a>
@endsection

@section('content')
<!-- ===== SECTION FILTER BULAN & TAHUN ===== -->
<div class="card mb-3">
  <div class="card-status-top bg-primary"></div>
  <div class="card-body">
    <form method="GET" class="row g-3 align-items-end">
      <!-- Pilihan Bulan -->
      <div class="col-12 col-sm-5 col-md-4">
        <label class="form-label font-weight-medium mb-1">Bulan Laporan</label>
        <div class="input-icon">
          <span class="input-icon-addon">
            <i class="ti ti-calendar text-secondary fs-2"></i>
          </span>
          <select name="bulan" class="form-select" style="padding-left: 2.5rem;">
            @foreach(range(1,12) as $m)
            <option value="{{ $m }}" {{ $bulan==$m ? 'selected' : '' }}>
              {{ \Carbon\Carbon::create(null,$m)->translatedFormat('F') }}
            </option>
            @endforeach
          </select>
        </div>
      </div>
      
      <!-- Pilihan Tahun -->
      <div class="col-12 col-sm-5 col-md-4">
        <label class="form-label font-weight-medium mb-1">Tahun Laporan</label>
        <div class="input-icon">
          <span class="input-icon-addon">
            <i class="ti ti-calendar-event text-secondary fs-2"></i>
          </span>
          <select name="tahun" class="form-select" style="padding-left: 2.5rem;">
            @foreach($tahunList as $y)
            <option value="{{ $y }}" {{ $tahun==$y ? 'selected' : '' }}>{{ $y }}</option>
            @endforeach
          </select>
        </div>
      </div>
      
      <!-- Tombol Tampilkan -->
      <div class="col-12 col-sm-2 col-md-auto ms-auto">
        <button type="submit" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-1" style="border-radius: 6px;">
          <i class="ti ti-search fs-2"></i> Tampilkan
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ===== SECTION KARTU RINGKASAN DATA ===== -->
<div class="row row-cards mb-3">
  
  <!-- Total Order -->
  <div class="col-sm-6 col-xl-3">
    <div class="card card-sm">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-auto">
            <span class="bg-blue-lt text-blue avatar" style="border-radius: 8px;">
              <i class="ti ti-receipt fs-2"></i>
            </span>
          </div>
          <div class="col text-truncate">
            <div class="font-weight-medium text-heading fs-3">{{ $summary['total_order'] }}</div>
            <div class="text-secondary small">Total Transaksi</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Total Pendapatan -->
  <div class="col-sm-6 col-xl-3">
    <div class="card card-sm">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-auto">
            <span class="bg-green-lt text-green avatar" style="border-radius: 8px;">
              <i class="ti ti-cash fs-2"></i>
            </span>
          </div>
          <div class="col text-truncate">
            <div class="font-weight-medium text-heading fs-3">Rp {{ number_format($summary['total_pendapatan'],0,',','.') }}</div>
            <div class="text-secondary small">Total Pendapatan</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Belum Bayar -->
  <div class="col-sm-6 col-xl-3">
    <div class="card card-sm">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-auto">
            <span class="bg-danger-lt text-danger avatar" style="border-radius: 8px;">
              <i class="ti ti-alert-circle fs-2"></i>
            </span>
          </div>
          <div class="col text-truncate">
            <div class="font-weight-medium text-heading fs-3">{{ $summary['belum_bayar'] }}</div>
            <div class="text-secondary small">Belum Lunas</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Sudah Diambil -->
  <div class="col-sm-6 col-xl-3">
    <div class="card card-sm">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-auto">
            <span class="bg-purple-lt text-purple avatar" style="border-radius: 8px;">
              <i class="ti ti-package-export fs-2"></i>
            </span>
          </div>
          <div class="col text-truncate">
            <div class="font-weight-medium text-heading fs-3">{{ $summary['sudah_diambil'] }}</div>
            <div class="text-secondary small">Sudah Diambil</div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- ===== SECTION TABEL RINCIAN LAPORAN ===== -->
<div class="card">
  <div class="table-responsive">
    <table class="table table-vcenter card-table text-nowrap table-hover">
      <thead>
        <tr>
          <th>Kode Order</th>
          <th>Pelanggan</th>
          <th>Kasir Penanggungjawab</th>
          <th>Tanggal Masuk</th>
          <th>Total Tagihan</th>
          <th>Status Kerja</th>
          <th>Pembayaran</th>
        </tr>
      </thead>
      <tbody>
        @forelse($orders as $order)
        <tr>
          <!-- Kode Order Link -->
          <td>
            <a href="{{ route('orders.show', $order) }}" class="font-weight-medium text-primary text-decoration-none">
              {{ $order->kode_order }}
            </a>
          </td>
          
          <!-- Pelanggan -->
          <td class="text-heading font-weight-medium">
            {{ $order->pelanggan->nama }}
          </td>
          
          <!-- Petugas Kasir -->
          <td class="text-secondary small">
            <span class="badge bg-muted-lt text-secondary">{{ $order->user->name }}</span>
          </td>
          
          <!-- Tanggal Masuk -->
          <td class="text-secondary small">
            <div class="d-flex align-items-center gap-1">
              <i class="ti ti-calendar text-muted"></i>
              {{ $order->tgl_masuk->format('d M Y') }}
            </div>
          </td>
          
          <!-- Total formatted -->
          <td class="font-weight-medium text-heading">
            {{ $order->total_formatted }}
          </td>
          
          <!-- Badge Status Pengerjaan -->
          <td>
            <span class="badge bg-{{ $order->status_badge }}-lt text-{{ $order->status_badge }} rounded-pill px-2.5 py-1 text-capitalize">
              {{ $order->status_label }}
            </span>
          </td>
          
          <!-- Badge Status Pembayaran -->
          <td>
            @if($order->status_bayar === 'lunas')
            <span class="badge bg-success-lt text-success rounded-pill px-2.5 py-1 font-weight-medium">
              <i class="ti ti-circle-check me-0.5"></i> Lunas
            </span>
            @else
            <span class="badge bg-danger-lt text-danger rounded-pill px-2.5 py-1 font-weight-medium">
              <i class="ti ti-alert-circle me-0.5"></i> Belum Lunas
            </span>
            @endif
          </td>
        </tr>
        @empty
        <!-- Tampilan Interaktif ketika data laporan kosong -->
        <tr>
          <td colspan="7" class="text-center py-5">
            <div class="empty">
              <div class="empty-icon">
                <div class="avatar avatar-md bg-muted-lt" style="border-radius: 10px;">
                  <i class="ti ti-chart-bar-off fs-1 text-secondary"></i>
                </div>
              </div>
              <p class="empty-title text-heading mt-2">Tidak ada transaksi terdaftar</p>
              <p class="empty-subtitle text-secondary mb-0">Belum ada aktivitas setoran pakaian masuk pada bulan dan tahun terpilih.</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
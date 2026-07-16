@extends('layouts.app')

@section('title', 'Order / Transaksi')
@section('page-title', 'Order & Transaksi')

@section('page-actions')
    <a href="{{ route('orders.create') }}" class="btn btn-primary d-flex align-items-center gap-1"
       style="border-radius: 6px;">
        <i class="ti ti-plus fs-2"></i> Order Baru
    </a>
@endsection

@section('content')
    @php $isKasir = auth()->user()->isKasir(); @endphp

    <div class="card">
        <div class="card-header border-0 pb-2">
            <form method="GET" class="w-100">
                <div class="row g-2 align-items-center">
                    <div class="col-12 col-md-4 col-lg-5">
                        <div class="input-icon">
            <span class="input-icon-addon">
              <i class="ti ti-search text-secondary fs-2"></i>
            </span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Cari kode order atau nama pelanggan..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-6 col-sm-4 col-md-2.5 col-lg-2">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="antri" {{ request('status')=='antri'   ? 'selected' : '' }}>Antri</option>
                            <option value="proses" {{ request('status')=='proses'  ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ request('status')=='selesai' ? 'selected' : '' }}>Selesai
                            </option>
                            <option value="diambil" {{ request('status')=='diambil' ? 'selected' : '' }}>Diambil
                            </option>
                        </select>
                    </div>

                    <div class="col-6 col-sm-4 col-md-2.5 col-lg-2">
                        <select name="status_bayar" class="form-select">
                            <option value="">Semua Bayar</option>
                            <option value="belum" {{ request('status_bayar')=='belum' ? 'selected' : '' }}>Belum Bayar
                            </option>
                            <option value="lunas" {{ request('status_bayar')=='lunas' ? 'selected' : '' }}>Lunas
                            </option>
                        </select>
                    </div>

                    <div class="col-12 col-sm-4 col-md-auto ms-auto d-flex gap-2">
                        <button type="submit" class="btn btn-icon btn-outline-primary flex-fill" title="Terapkan Filter"
                                style="min-width: 40px;">
                            <i class="ti ti-filter fs-2"></i>
                        </button>
                        @if(request()->hasAny(['search','status','status_bayar']))
                            <a href="{{ route('orders.index') }}" class="btn btn-ghost-secondary px-2">
                                Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($isKasir)
        <div class="row row-cards">
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="card-title">Order Antri</h3>
                            <p class="text-secondary small mb-0">Order pelanggan yang belum disetujui kasir.</p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter table-hover card-table text-nowrap">
                            <thead>
                            <tr>
                                <th>Kode Order</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Tanggal Masuk</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($pendingOrders as $order)
                                <tr>
                                    <td class="fw-semibold">{{ $order->kode_order }}</td>
                                    <td>{{ $order->pelanggan->nama }}</td>
                                    <td>{{ $order->total_formatted }}</td>
                                    <td>{{ $order->tgl_masuk->format('d M Y') }}</td>
                                    <td class="text-end">
                                        <form action="{{ route('orders.approve', $order) }}" method="POST" class="d-inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success d-flex align-items-center gap-1" style="border-radius: 6px;">
                                                <i class="ti ti-check fs-2"></i> Setujui
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-secondary">
                                        <div class="empty">
                                            <div class="empty-icon">
                                                <div class="avatar avatar-lg bg-muted-lt" style="border-radius: 12px;">
                                                    <i class="ti ti-clock-hour-4 fs-2"></i>
                                                </div>
                                            </div>
                                            <p class="empty-title text-heading mt-3">Tidak ada order antri</p>
                                            <p class="empty-subtitle text-secondary mb-0">Semua order antri sudah disetujui.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="card-title">Order Disetujui</h3>
                            <p class="text-secondary small mb-0">Order yang sudah disetujui dan sedang diproses.</p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter table-hover card-table text-nowrap">
                            <thead>
                            <tr>
                                <th>Informasi Order</th>
                                <th>Pelanggan</th>
                                <th>Tipe Order</th>
                                <th>Tanggal Masuk</th>
                                <th>Est. Selesai</th>
                                <th>Total Tagihan</th>
                                <th>Status Kerja</th>
                                <th>Pembayaran</th>
                                <th class="w-1 text-center">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($approvedOrders as $order)
                                <tr>
                                    <td>
                                        <div class="font-weight-medium text-heading mb-0">{{ $order->kode_order }}</div>
                                        <div class="small text-secondary d-flex align-items-center gap-1">
                                            <i class="ti ti-user fs-4 text-muted"></i> Kasir: {{ optional($order->user)->name ?? 'Belum ditugaskan' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-weight-medium text-heading">{{ $order->pelanggan->nama }}</div>
                                    </td>
                                    <td>
                                        @if($order->tipe_order === 'delivery')
                                            <span class="badge bg-blue-lt text-blue rounded-pill px-2.5 py-1 fw-medium">
                                              <i class="ti ti-truck-delivery me-1 fs-3"></i> Delivery
                                            </span>
                                            <div class="mt-1">
                                                <span class="badge bg-{{ $order->status_jemput_badge }}-lt text-{{ $order->status_jemput_badge }} rounded-pill px-2 py-1"
                                                      style="font-size: 11px;">
                                                    {{ $order->status_jemput_label }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="badge bg-secondary-lt text-secondary rounded-pill px-2.5 py-1 fw-medium">
                                              <i class="ti ti-building-store me-1 fs-3"></i> Datang Langsung
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-secondary small">
                                        <div class="d-flex align-items-center gap-1">
                                            <i class="ti ti-calendar fs-3 text-muted"></i>
                                            {{ $order->tgl_masuk->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="text-secondary small">
                                        <div class="d-flex align-items-center gap-1">
                                            <i class="ti ti-clock fs-3 text-muted"></i>
                                            <span class="{{ $order->estimasi_selesai->isPast() && $order->status !== 'diambil' ? 'text-danger fw-semibold' : '' }}">
                                                {{ $order->estimasi_selesai->format('d M Y') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="font-weight-medium text-heading">
                                        {{ $order->total_formatted }}
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $order->status_badge }}-lt text-{{ $order->status_badge }} rounded-pill px-2.5 py-1 fw-medium text-capitalize">
                                            {{ $order->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($order->status_bayar === 'lunas')
                                            <span class="badge bg-success-lt text-success rounded-pill px-2.5 py-1 fw-medium">
                                              <i class="ti ti-check me-1 fs-3"></i> Lunas
                                            </span>
                                        @else
                                            <span class="badge bg-danger-lt text-danger rounded-pill px-2.5 py-1 fw-medium">
                                              <i class="ti ti-alert-circle me-1 fs-3"></i> Belum Bayar
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <a href="{{ route('orders.show', $order) }}"
                                               class="btn btn-sm btn-icon btn-outline-primary" title="Detail Order"
                                               style="border-radius: 6px;">
                                                <i class="ti ti-eye fs-2"></i>
                                            </a>
                                            <a href="{{ route('orders.nota', $order) }}"
                                               class="btn btn-sm btn-icon btn-outline-secondary" title="Cetak Nota" target="_blank"
                                               style="border-radius: 6px;">
                                                <i class="ti ti-printer fs-2"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5 text-secondary">
                                        <div class="empty">
                                            <div class="empty-icon">
                                                <div class="avatar avatar-lg bg-muted-lt" style="border-radius: 12px;">
                                                    <i class="ti ti-check fs-2"></i>
                                                </div>
                                            </div>
                                            <p class="empty-title text-heading mt-3">Tidak ada order yang disetujui</p>
                                            <p class="empty-subtitle text-secondary mb-0">Order akan muncul setelah disetujui kasir.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter table-hover card-table text-nowrap">
                    <thead>
                    <tr>
                        <th>Informasi Order</th>
                        <th>Pelanggan</th>
                        <th>Tipe Order</th>
                        <th>Tanggal Masuk</th>
                        <th>Est. Selesai</th>
                        <th>Total Tagihan</th>
                        <th>Status Kerja</th>
                        <th>Pembayaran</th>
                        <th class="w-1 text-center">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>
                                <div class="font-weight-medium text-heading mb-0">{{ $order->kode_order }}</div>
                                <div class="small text-secondary d-flex align-items-center gap-1">
                                    <i class="ti ti-user fs-4 text-muted"></i> Kasir: {{ $order->user->name }}
                                </div>
                            </td>
                            <td>
                                <div class="font-weight-medium text-heading">{{ $order->pelanggan->nama }}</div>
                            </td>
                            <td>
                                @if($order->tipe_order === 'delivery')
                                    <span class="badge bg-blue-lt text-blue rounded-pill px-2.5 py-1 fw-medium">
                                      <i class="ti ti-truck-delivery me-1 fs-3"></i> Delivery
                                    </span>
                                    <div class="mt-1">
                                        <span
                                            class="badge bg-{{ $order->status_jemput_badge }}-lt text-{{ $order->status_jemput_badge }} rounded-pill px-2 py-1"
                                            style="font-size: 11px;">
                                            {{ $order->status_jemput_label }}
                                        </span>
                                    </div>
                                    @if($order->kurir)
                                        <div class="small text-secondary mt-1 d-flex align-items-center gap-1">
                                            <i class="ti ti-user-check fs-4 text-muted"></i> {{ $order->kurir->name }}
                                        </div>
                                    @endif
                                @else
                                    <span class="badge bg-secondary-lt text-secondary rounded-pill px-2.5 py-1 fw-medium">
                                      <i class="ti ti-building-store me-1 fs-3"></i> Datang Langsung
                                    </span>
                                @endif
                            </td>
                            <td class="text-secondary small">
                                <div class="d-flex align-items-center gap-1">
                                    <i class="ti ti-calendar fs-3 text-muted"></i>
                                    {{ $order->tgl_masuk->format('d M Y') }}
                                </div>
                            </td>
                            <td class="text-secondary small">
                                <div class="d-flex align-items-center gap-1">
                                    <i class="ti ti-clock fs-3 text-muted"></i>
                                    <span
                                        class="{{ $order->estimasi_selesai->isPast() && $order->status !== 'diambil' ? 'text-danger fw-semibold' : '' }}">
                                        {{ $order->estimasi_selesai->format('d M Y') }}
                                    </span>
                                </div>
                            </td>
                            <td class="font-weight-medium text-heading">
                                {{ $order->total_formatted }}
                            </td>
                            <td>
                            <span
                                class="badge bg-{{ $order->status_badge }}-lt text-{{ $order->status_badge }} rounded-pill px-2.5 py-1 fw-medium text-capitalize">
                              {{ $order->status_label }}
                            </span>
                            </td>
                            <td>
                                @if($order->status_bayar === 'lunas')
                                    <span class="badge bg-success-lt text-success rounded-pill px-2.5 py-1 fw-medium">
                                      <i class="ti ti-check me-1 fs-3"></i> Lunas
                                    </span>
                                @else
                                    <span class="badge bg-danger-lt text-danger rounded-pill px-2.5 py-1 fw-medium">
                                      <i class="ti ti-alert-circle me-1 fs-3"></i> Belum Bayar
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{ route('orders.show', $order) }}"
                                       class="btn btn-sm btn-icon btn-outline-primary" title="Detail Order"
                                       style="border-radius: 6px;">
                                        <i class="ti ti-eye fs-2"></i>
                                    </a>
                                    <a href="{{ route('orders.nota', $order) }}"
                                       class="btn btn-sm btn-icon btn-outline-secondary" title="Cetak Nota" target="_blank"
                                       style="border-radius: 6px;">
                                        <i class="ti ti-printer fs-2"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty">
                                    <div class="empty-icon">
                                        <div class="avatar avatar-md bg-muted-lt" style="border-radius: 10px;">
                                            <i class="ti ti-mailbox fs-1 text-secondary"></i>
                                        </div>
                                    </div>
                                    <p class="empty-title text-heading mt-2">Tidak ada data transaksi</p>
                                    <p class="empty-subtitle text-secondary mb-0">Coba ubah kata kunci atau ganti filter
                                        pencarian Anda.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="card-footer d-flex align-items-center justify-content-between border-top">
                    <p class="m-0 text-secondary small">Menampilkan data halaman ini</p>
                    <div>
                        {{ $orders->links() }}
                    </div>
                </div>
            @endif
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: @json(session('success')),
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#2fb344',
                timer: 2500,
                timerProgressBar: true,
            });
            @endif
        });
    </script>
@endpush

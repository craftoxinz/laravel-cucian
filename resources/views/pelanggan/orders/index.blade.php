@extends('layouts.pelanggan')

@section('title', 'Pesanan Saya')
@section('page-title', 'Pesanan Saya')

@section('page-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" style="border-radius: 6px;">
            <i class="ti ti-arrow-left fs-2"></i> Dashboard
        </a>
        <a href="{{ route('pelanggan.orders.create') }}" class="btn btn-sm btn-primary d-flex align-items-center gap-1" style="border-radius: 6px;">
            <i class="ti ti-plus fs-2"></i> Order Baru
        </a>
    </div>
@endsection

@section('content')
    <div class="row row-cards">
        {{-- Pesanan Menunggu Persetujuan --}}
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="card-title">Pesanan Menunggu Persetujuan</h3>
                        <p class="text-secondary small mb-0">Order yang Anda buat dan belum disetujui kasir.</p>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter table-hover card-table text-nowrap">
                        <thead>
                        <tr>
                            <th>Kode Order</th>
                            <th>Tipe Order</th>
                            <th>Total</th>
                            <th>Tanggal Masuk</th>
                            <th class="text-end">Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($pendingOrders as $order)
                            <tr>
                                <td class="fw-semibold">{{ $order->kode_order }}</td>
                                <td>
                                    @if($order->tipe_order === 'delivery')
                                        <span class="badge bg-blue-lt text-blue rounded-pill px-2 py-1">
                                            <i class="ti ti-truck-delivery me-1"></i> Delivery
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-lt text-secondary rounded-pill px-2 py-1">
                                            <i class="ti ti-building-store me-1"></i> Datang Langsung
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $order->getTotalFormattedAttribute() }}</td>
                                <td>{{ $order->tgl_masuk?->format('d M Y') }}</td>
                                <td class="text-end">
                                    <span class="badge bg-warning-lt text-warning rounded-pill px-3 py-1">Antri</span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('pelanggan.orders.show', $order->id) }}" class="btn btn-sm btn-icon btn-outline-primary" style="border-radius: 6px;" title="Detail Pesanan">
                                        <i class="ti ti-eye fs-2"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-secondary">
                                    <div class="empty">
                                        <div class="empty-icon">
                                            <div class="avatar avatar-lg bg-muted-lt" style="border-radius: 12px;">
                                                <i class="ti ti-clock-hour-4 fs-2"></i>
                                            </div>
                                        </div>
                                        <p class="empty-title text-heading mt-3">Tidak ada order menunggu</p>
                                        <p class="empty-subtitle text-secondary mb-0">Semua order yang dibuat sudah disetujui atau diproses.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Pesanan Disetujui / Diproses --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="card-title">Pesanan Disetujui / Diproses</h3>
                        <p class="text-secondary small mb-0">Order yang sedang diproses laundry dan perjalanan kurir.</p>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter table-hover card-table text-nowrap">
                        <thead>
                        <tr>
                            <th>Kode Order</th>
                            <th>Status Laundry</th>
                            <th>Status Delivery (Kurir)</th>
                            <th>Total</th>
                            <th>Tanggal Masuk</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($approvedOrders as $order)
                            <tr>
                                <td class="fw-semibold">{{ $order->kode_order }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status_badge ?? 'secondary' }}-lt text-{{ $order->status_badge ?? 'secondary' }} rounded-pill px-2 py-1 text-capitalize">
                                        {{ $order->getStatusLabelAttribute() }}
                                    </span>
                                </td>
                                <td>
                                    @if($order->tipe_order === 'delivery')
                                        <span class="badge bg-{{ $order->status_jemput_badge }}-lt text-{{ $order->status_jemput_badge }} rounded-pill px-2.5 py-1">
                                            <i class="ti ti-truck-delivery me-1"></i> {{ $order->status_jemput_label }}
                                        </span>
                                    @else
                                        <span class="text-secondary small">-</span>
                                    @endif
                                </td>
                                <td>{{ $order->getTotalFormattedAttribute() }}</td>
                                <td>{{ $order->tgl_masuk?->format('d M Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('pelanggan.orders.show', $order->id) }}" class="btn btn-sm btn-icon btn-outline-primary" style="border-radius: 6px;" title="Detail Pesanan">
                                        <i class="ti ti-eye fs-2"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-secondary">
                                    <div class="empty">
                                        <div class="empty-icon">
                                            <div class="avatar avatar-lg bg-muted-lt" style="border-radius: 12px;">
                                                <i class="ti ti-check fs-2"></i>
                                            </div>
                                        </div>
                                        <p class="empty-title text-heading mt-3">Tidak ada order yang disetujui</p>
                                        <p class="empty-subtitle text-secondary mb-0">Order akan muncul di sini setelah kasir menyetujuinya.</p>
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
@endsection

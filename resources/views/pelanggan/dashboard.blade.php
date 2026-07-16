@extends('layouts.pelanggan')

@section('title', 'Dashboard Pelanggan')
@section('page-title', 'Dashboard Pelanggan')

@section('content')
    <div class="row row-cards mb-3">
        <div class="col-sm-6 col-lg-4">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-primary text-white avatar" style="border-radius: 8px;">
                                <i class="ti ti-receipt fs-2"></i>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium text-heading fs-3">{{ $stats['total_orders'] }} Pesanan</div>
                            <div class="text-secondary small">Total pesanan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-4">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-warning text-white avatar" style="border-radius: 8px;">
                                <i class="ti ti-clock-hour-4 fs-2"></i>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium text-heading fs-3">{{ $stats['pending'] }} Pesanan</div>
                            <div class="text-secondary small">Sedang diproses</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-4">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-success text-white avatar" style="border-radius: 8px;">
                                <i class="ti ti-user-check fs-2"></i>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium text-heading fs-3">{{ auth('pelanggan')->user()->is_member ? 'Member' : 'Pelanggan' }}</div>
                            <div class="text-secondary small">Status akun</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="card-title">Pesanan Terbaru</h3>
                        <div class="text-secondary small">Lihat status dan detail pesanan terkini.</div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('pelanggan.orders.index') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1" style="border-radius: 6px;">
                            <i class="ti ti-eye fs-2"></i> Lihat Semua
                        </a>
                        <a href="{{ route('pelanggan.orders.create') }}" class="btn btn-sm btn-primary d-flex align-items-center gap-1" style="border-radius: 6px;">
                            <i class="ti ti-plus fs-2"></i> Order Baru
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table text-nowrap">
                        <thead>
                            <tr>
                                <th>Kode Order</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $o)
                            <tr>
                                <td class="fw-semibold">{{ $o->kode_order }}</td>
                                <td>
                                    <span class="badge bg-{{ $o->status_badge ?? 'secondary' }}-lt text-{{ $o->status_badge ?? 'secondary' }} rounded-pill px-2 py-1">
                                        {{ $o->getStatusLabelAttribute() }}
                                    </span>
                                </td>
                                <td>{{ $o->getTotalFormattedAttribute() }}</td>
                                <td class="text-end">
                                    <a href="{{ route('pelanggan.orders.show', $o->id) }}" class="btn btn-sm btn-icon btn-outline-primary" style="border-radius: 6px;" title="Detail Pesanan">
                                        <i class="ti ti-eye fs-2"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-secondary">
                                    <div class="empty">
                                        <div class="empty-icon">
                                            <div class="avatar avatar-lg bg-muted-lt" style="border-radius: 12px;">
                                                <i class="ti ti-receipt fs-2"></i>
                                            </div>
                                        </div>
                                        <p class="empty-title text-heading mt-3">Belum ada pesanan</p>
                                        <p class="empty-subtitle text-secondary mb-0">Pesanan pelanggan akan muncul di sini setelah dibuat.</p>
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

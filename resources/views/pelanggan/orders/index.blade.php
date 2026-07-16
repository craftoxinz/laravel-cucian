@extends('layouts.pelanggan')

@section('title', 'Pesanan Saya')
@section('page-title', 'Pesanan Saya')

@section('page-actions')
    <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" style="border-radius: 6px;">
        <i class="ti ti-arrow-left fs-2"></i> Dashboard
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div>
                <h3 class="card-title">Daftar Pesanan</h3>
                <p class="text-secondary small mb-0">Lihat status pesanan dan detail tagihan Anda.</p>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter table-hover card-table text-nowrap">
                <thead>
                    <tr>
                        <th>Kode Order</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Tanggal Masuk</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="fw-semibold">{{ $order->kode_order }}</td>
                            <td>
                                <span class="badge bg-{{ $order->status_badge ?? 'secondary' }}-lt text-{{ $order->status_badge ?? 'secondary' }} rounded-pill px-2 py-1 text-capitalize">
                                    {{ $order->getStatusLabelAttribute() }}
                                </span>
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
                            <td colspan="5" class="text-center py-5 text-secondary">
                                <div class="empty">
                                    <div class="empty-icon">
                                        <div class="avatar avatar-lg bg-muted-lt" style="border-radius: 12px;">
                                            <i class="ti ti-mailbox fs-2"></i>
                                        </div>
                                    </div>
                                    <p class="empty-title text-heading mt-3">Belum ada pesanan</p>
                                    <p class="empty-subtitle text-secondary mb-0">Pesanan Anda akan muncul setelah dibuat.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
            <div class="card-footer d-flex align-items-center justify-content-between border-top">
                <p class="m-0 text-secondary small">Menampilkan {{ $orders->count() }} dari {{ $orders->total() }} pesanan</p>
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection

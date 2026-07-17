@extends('layouts.kurir')

@section('title', 'Order / Transaksi')
@section('page-title', 'Order Delivery')

@section('content')
    <div class="card">
        <div class="card-header border-0 pb-0">
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ $tab === 'menunggu' ? 'active' : '' }}" href="{{ route('kurir.orders.index', ['tab' => 'menunggu']) }}">
                        <i class="ti ti-clock-hour-4 me-1"></i> Menunggu Dijemput
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab === 'saya' ? 'active' : '' }}" href="{{ route('kurir.orders.index', ['tab' => 'saya']) }}">
                        <i class="ti ti-truck-delivery me-1"></i> Order Saya / Riwayat
                    </a>
                </li>
            </ul>
        </div>

        <div class="card-header border-0 pb-2">
            <form method="GET" class="w-100">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="input-icon">
                <span class="input-icon-addon">
                    <i class="ti ti-search text-secondary fs-2"></i>
                </span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Cari kode order atau nama pelanggan..." value="{{ request('search') }}">
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-vcenter table-hover card-table text-nowrap">
                <thead>
                <tr>
                    <th>Kode Order</th>
                    <th>Pelanggan</th>
                    <th>Alamat Penjemputan</th>
                    <th>Status Process Laundry</th>
                    @if($tab === 'saya')
                        <th>Status Delivery</th>
                    @endif
                    <th class="w-1 text-center">Aksi Status</th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <div class="font-weight-medium text-heading mb-0">{{ $order->kode_order }}</div>
                            <div class="small text-secondary d-flex align-items-center gap-1">
                                <i class="ti ti-user fs-4 text-muted"></i> Kasir: {{ $order->user?->name ?? 'Belum ditugaskan' }}
                            </div>
                        </td>
                        <td>
                            <div class="font-weight-medium text-heading">{{ $order->pelanggan?->nama ?? '-' }}</div>
                            <div class="small text-secondary">{{ $order->pelanggan?->telepon ?? '-' }}</div>
                        </td>
                        <td class="text-secondary small" style="white-space: normal; max-width: 220px;">
                            <i class="ti ti-map-pin fs-4 text-muted me-1"></i>{{ $order->alamat_jemput ?? '-' }}
                        </td>
                        <td>
                            <span class="badge bg-blue-lt text-blue rounded-pill px-2 py-1 fw-medium text-capitalize">
                                {{ $order->status }}
                            </span>
                        </td>

                        @if($tab === 'saya')
                            <td>
                                <span class="badge bg-{{ $order->status_jemput_badge }}-lt text-{{ $order->status_jemput_badge }} rounded-pill px-2.5 py-1 fw-medium">
                                    {{ $order->status_jemput_label }}
                                </span>
                            </td>
                        @endif

                        <td class="text-center">
                            @if($tab === 'menunggu')
                                <form action="{{ route('kurir.orders.approve', $order) }}" method="POST" class="d-inline form-approve">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success d-flex align-items-center gap-1" style="border-radius: 6px;">
                                        <i class="ti ti-check fs-2"></i> Approve
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('kurir.orders.updateStatusJemput', $order) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <select name="status_jemput" class="form-select form-select-sm select-status-jemput"
                                            data-previous-value="{{ $order->status_jemput }}"
                                        {{ $order->status_jemput === 'selesai' ? 'disabled' : '' }}>

                                        <optgroup label="1. Penjemputan Awal">
                                            <option value="menuju_lokasi" {{ $order->status_jemput === 'menuju_lokasi' ? 'selected' : '' }}>
                                                Menuju Lokasi Pelanggan
                                            </option>
                                            <option value="menuju_laundry" {{ $order->status_jemput === 'menuju_laundry' ? 'selected' : '' }}>
                                                Menuju Laundry
                                            </option>
                                            <option value="selesai_diantar" {{ $order->status_jemput === 'selesai_diantar' ? 'selected' : '' }}>
                                                Sudah Tiba di Laundry
                                            </option>
                                        </optgroup>

                                        <optgroup label="2. Pengantaran Kembali">
                                            <option value="mengantar_ke_pelanggan" {{ $order->status_jemput === 'mengantar_ke_pelanggan' ? 'selected' : '' }}>
                                                Mengantar Kembali ke Pelanggan
                                            </option>
                                            <option value="selesai" {{ $order->status_jemput === 'selesai' ? 'selected' : '' }}>
                                                Selesai / Diterima Pelanggan
                                            </option>
                                        </optgroup>
                                    </select>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $tab === 'saya' ? 6 : 5 }}" class="text-center py-5">
                            <div class="empty">
                                <div class="empty-icon">
                                    <div class="avatar avatar-md bg-muted-lt" style="border-radius: 10px;">
                                        <i class="ti ti-mailbox fs-1 text-secondary"></i>
                                    </div>
                                </div>
                                <p class="empty-title text-heading mt-2">
                                    {{ $tab === 'saya' ? 'Belum ada order yang kamu ambil' : 'Tidak ada order yang menunggu dijemput' }}
                                </p>
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
                <div>{{ $orders->links() }}</div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
            Swal.fire({
                title: 'Berhasil!', text: @json(session('success')), icon: 'success',
                confirmButtonText: 'OK', confirmButtonColor: '#2fb344', timer: 2500, timerProgressBar: true,
            });
            @endif

            document.querySelectorAll('.form-approve').forEach(form => {
                form.addEventListener('submit', function (e) {
                    if (form.dataset.confirmed === 'true') return;
                    e.preventDefault();
                    Swal.fire({
                        title: 'Ambil Order Ini?',
                        text: 'Kamu akan bertanggung jawab menjemput cucian ke alamat pelanggan.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Ambil Order',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#2fb344',
                        cancelButtonColor: '#626976',
                        reverseButtons: true,
                    }).then(result => {
                        if (result.isConfirmed) {
                            form.dataset.confirmed = 'true';
                            form.submit();
                        }
                    });
                });
            });

            document.querySelectorAll('.select-status-jemput').forEach(select => {
                select.addEventListener('change', function () {
                    const form = this.closest('form');
                    const newValue = this.value;
                    const previousValue = this.dataset.previousValue;

                    if (newValue === 'selesai') {
                        Swal.fire({
                            title: 'Selesaikan Pengantaran?',
                            text: 'Apakah kamu yakin order ini sudah diterima oleh pelanggan? Setelah diselesaikan, status tidak dapat diubah lagi!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Selesaikan!',
                            cancelButtonText: 'Batal',
                            confirmButtonColor: '#2fb344',
                            cancelButtonColor: '#d33',
                            reverseButtons: true,
                        }).then(result => {
                            if (result.isConfirmed) {
                                form.submit();
                            } else {
                                this.value = previousValue;
                            }
                        });
                    } else {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush

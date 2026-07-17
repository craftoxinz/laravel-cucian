@extends('layouts.pelanggan')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@section('page-actions')
    <a href="{{ route('pelanggan.orders.index') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" style="border-radius: 6px;">
        <i class="ti ti-arrow-left fs-2"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div>
                <h3 class="card-title">Nota {{ $order->kode_order }}</h3>
                <p class="text-secondary small mb-0">Detail lengkap pesanan Anda.</p>
            </div>
            <span class="badge bg-{{ $order->status_badge ?? 'secondary' }}-lt text-{{ $order->status_badge ?? 'secondary' }} rounded-pill px-3 py-2 text-capitalize">
                {{ $order->getStatusLabelAttribute() }}
            </span>
        </div>
        <div class="card-body">
            <div class="row gy-3 mb-4">
                <div class="col-md-3">
                    <div class="text-secondary small mb-1">Tanggal Masuk</div>
                    <div class="fw-semibold">{{ $order->tgl_masuk?->format('d M Y') }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-secondary small mb-1">Status Laundry</div>
                    <div class="fw-semibold">{{ $order->getStatusLabelAttribute() }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-secondary small mb-1">Tipe & Status Delivery</div>
                    <div>
                        @if($order->tipe_order === 'delivery')
                            <span class="badge bg-{{ $order->status_jemput_badge }}-lt text-{{ $order->status_jemput_badge }} rounded-pill px-2.5 py-1">
                                {{ $order->status_jemput_label }}
                            </span>
                        @else
                            <span class="fw-semibold text-secondary">Datang Langsung</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-secondary small mb-1">Total Pembayaran</div>
                    <div class="fw-semibold">{{ $order->getTotalFormattedAttribute() }}</div>
                </div>
            </div>

            @if($order->tipe_order === 'delivery')
                <div class="alert alert-important alert-info mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-truck-delivery fs-1 me-3"></i>
                        <div>
                            <div class="fw-bold">Informasi Antar-Jemput</div>
                            <div class="small">
                                Kurir: <strong>{{ $order->kurir?->name ?? 'Belum ada kurir' }}</strong> |
                                Alamat: {{ $order->alamat_jemput ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-vcenter table-hover card-table text-nowrap">
                    <thead>
                    <tr>
                        <th>Layanan</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->layanan->nama }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->layanan->satuan }}</td>
                            <td class="text-end">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <a href="{{ route('pelanggan.orders.index') }}" class="btn btn-outline-secondary" style="border-radius: 6px;">
                <i class="ti ti-arrow-left me-2"></i> Kembali ke Pesanan
            </a>

            @if($order->status === 'antri')
                <form action="{{ route('pelanggan.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Batalkan pesanan ini?');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger d-flex align-items-center gap-1" style="border-radius: 6px;">
                        <i class="ti ti-x fs-2"></i> Batalkan Pesanan
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection

from pathlib import Path
base = Path(__file__).resolve().parents[1]
index = base / 'resources' / 'views' / 'pelanggan' / 'orders' / 'index.blade.php'
show = base / 'resources' / 'views' / 'pelanggan' / 'orders' / 'show.blade.php'
index.write_text("""@extends('layouts.pelanggan')

@section('title', 'Pesanan Saya')
@section('page-title', 'Pesanan Saya')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Pesanan</h3>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap">
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
                            <td>{{ $order->kode_order }}</td>
                            <td>{{ $order->getStatusLabelAttribute() }}</td>
                            <td>{{ $order->getTotalFormattedAttribute() }}</td>
                            <td>{{ $order->tgl_masuk?->format('d M Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('pelanggan.orders.show', $order->id) }}" class="btn btn-sm btn-primary">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <p class="m-0 text-muted">Menampilkan {{ $orders->count() }} dari {{ $orders->total() }} pesanan</p>
            {{ $orders->links() }}
        </div>
    </div>
@endsection
""", encoding='utf-8')
show.write_text("""@extends('layouts.pelanggan')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nota {{ $order->kode_order }}</h3>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="text-muted">Tanggal Masuk</div>
                    <div>{{ $order->tgl_masuk?->format('d M Y') }}</div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted">Status</div>
                    <div>{{ $order->getStatusLabelAttribute() }}</div>
                </div>
                <div class="col-md-4">
                    <div class="text-muted">Total</div>
                    <div>{{ $order->getTotalFormattedAttribute() }}</div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap">
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
                                <td class="text-end">Rp{{ number_format($item->subtotal,0,',','.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('pelanggan.orders.index') }}" class="btn btn-secondary">Kembali ke Pesanan</a>
        </div>
    </div>
@endsection
""", encoding='utf-8')
"}
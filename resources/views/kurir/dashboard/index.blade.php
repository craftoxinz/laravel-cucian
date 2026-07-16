@extends('layouts.kurir')

@section('title', 'Dashboard Kurir')
@section('page-title', 'Dashboard Kurir')

@push('styles')
    <!-- Menggunakan ApexCharts untuk grafik aktivitas -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0/dist/apexcharts.min.js"></script>
@endpush

@section('content')
    <!-- 1. Card Ringkasan Statistik -->
    <div class="row row-cards mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-warning text-white avatar">
                                <i class="ti ti-clock-hour-4 fs-2"></i>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">
                                {{ $stats['menunggu_dijemput'] }} Order
                            </div>
                            <div class="text-secondary small">
                                Menunggu Dijemput
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-azure text-white avatar">
                                <i class="ti ti-truck-delivery fs-2"></i>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">
                                {{ $stats['sedang_diproses'] }} Order
                            </div>
                            <div class="text-secondary small">
                                Sedang Kamu Tangani
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-success text-white avatar">
                                <i class="ti ti-circle-check fs-2"></i>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">
                                {{ $stats['selesai_hari_ini'] }} Order
                            </div>
                            <div class="text-secondary small">
                                Selesai Hari Ini
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-primary text-white avatar">
                                <i class="ti ti-package fs-2"></i>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">
                                {{ $stats['total_selesai'] }} Order
                            </div>
                            <div class="text-secondary small">
                                Total Riwayat Selesai
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cards">
        <!-- 2. Chart Aktivitas Pengantaran 7 Hari Terakhir -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Aktivitas Pengantaran (7 Hari Terakhir)</h3>
                    <div id="chart-delivery-activity" style="min-height: 250px;"></div>
                </div>
            </div>
        </div>

        <!-- 3. Quick Table Order Aktif Kurir -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Order Dalam Proses Kamu</h3>
                    <a href="{{ route('kurir.orders.index', ['tab' => 'saya']) }}" class="btn btn-sm btn-link">
                        Lihat Semua
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table text-nowrap">
                        <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Pelanggan</th>
                            <th>Status Delivery</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($activeOrders as $order)
                            <tr>
                                <td class="fw-bold">{{ $order->kode_order }}</td>
                                <td>
                                    <div class="text-heading fw-medium">{{ $order->pelanggan->nama }}</div>
                                    <div class="small text-secondary text-truncate" style="max-width: 130px;">
                                        {{ $order->alamat_jemput ?? '-' }}
                                    </div>
                                </td>
                                <td>
                                        <span class="badge bg-{{ $order->status_jemput_badge }}-lt text-{{ $order->status_jemput_badge }} rounded-pill px-2 py-1">
                                            {{ $order->status_jemput_label }}
                                        </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-secondary">
                                    <i class="ti ti-circle-check fs-2 text-success d-block mb-1"></i>
                                    Tidak ada order aktif yang sedang berjalan.
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

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const options = {
                chart: {
                    type: 'bar',
                    height: 260,
                    toolbar: { show: false },
                },
                series: [{
                    name: 'Order Selesai',
                    data: @json($completedData)
                }],
                colors: ['#0054a6'],
                plotOptions: {
                    bar: {
                        borderRadius: 6,
                        columnWidth: '40%',
                    }
                },
                dataLabels: { enabled: false },
                xaxis: {
                    categories: @json($labels),
                    labels: { style: { colors: '#626976' } }
                },
                yaxis: {
                    labels: { style: { colors: '#626976' } },
                    allowDecimals: false
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                },
                tooltip: { theme: 'light' }
            };

            const chart = new ApexCharts(document.querySelector("#chart-delivery-activity"), options);
            chart.render();
        });
    </script>
@endpush

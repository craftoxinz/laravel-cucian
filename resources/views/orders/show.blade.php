@extends('layouts.app')

@section('title', 'Detail Order')
@section('page-title', 'Detail Order')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Order</a></li>
    <li class="breadcrumb-item active">{{ $order->kode_order }}</li>
@endsection

@section('page-actions')
    <a href="{{ route('orders.nota', $order) }}" target="_blank"
       class="btn btn-outline-secondary d-flex align-items-center gap-1" style="border-radius: 6px;">
        <i class="ti ti-printer fs-2"></i> Cetak Nota
    </a>
@endsection

@section('content')
    <div class="row row-cards">

        <!-- ===== COLUMN KIRI: METADATA & UPDATE STATUS ===== -->
        <div class="col-lg-4">

            <!-- Info Utama Order -->
            <div class="card mb-3">
                <div class="card-status-top bg-primary"></div>
                <div class="card-header">
                    <h3 class="card-title text-heading">Rincian Nota</h3>
                </div>
                <div class="card-body p-0">
                    <!-- List Detail Info -->
                    <div class="p-3 border-bottom">
                        <div class="row align-items-center mb-2">
                            <div class="col-5 text-secondary small">Kode Order</div>
                            <div class="col-7 fw-bold text-heading fs-3">{{ $order->kode_order }}</div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-5 text-secondary small">Nama Pelanggan</div>
                            <div class="col-7 font-weight-medium text-heading">{{ $order->pelanggan->nama }}</div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-5 text-secondary small">No. Telepon</div>
                            <div class="col-7 text-heading">{{ $order->pelanggan->telepon ?? '-' }}</div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-5 text-secondary small">Petugas Kasir</div>
                            <div class="col-7 text-heading"><span
                                    class="badge bg-muted-lt text-secondary">{{ $order->user->name }}</span></div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-5 text-secondary small">Tipe Order</div>
                            <div class="col-7">
                                @if($order->tipe_order === 'delivery')
                                    <span class="badge bg-blue-lt text-blue rounded-pill px-2.5 py-1 fw-medium">
                                        <i class="ti ti-truck-delivery me-1"></i> Delivery
                                    </span>
                                @else
                                    <span
                                        class="badge bg-secondary-lt text-secondary rounded-pill px-2.5 py-1 fw-medium">
                                        <i class="ti ti-building-store me-1"></i> Datang Langsung
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if($order->tipe_order === 'delivery')
                            <div class="row align-items-start mb-2">
                                <div class="col-5 text-secondary small">Alamat Penjemputan</div>
                                <div class="col-7 text-heading small">{{ $order->alamat_jemput ?? '-' }}</div>
                            </div>
                            <div class="row align-items-center mb-2">
                                <div class="col-5 text-secondary small">Kurir</div>
                                <div class="col-7 text-heading">
                                    @if($order->kurir)
                                        <span class="badge bg-muted-lt text-secondary">{{ $order->kurir->name }}</span>
                                    @else
                                        <span class="text-secondary fst-italic">Belum ditugaskan</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row align-items-center mb-2">
                                <div class="col-5 text-secondary small">Status Penjemputan</div>
                                <div class="col-7">
                                    <span class="badge bg-{{ $order->status_jemput_badge }}-lt text-{{ $order->status_jemput_badge }} rounded-pill px-2.5 py-1">
                                      {{ $order->status_jemput_label }}
                                    </span>
                                </div>
                            </div>
                        @endif
                        <div class="row align-items-center mb-2">
                            <div class="col-5 text-secondary small">Tanggal Masuk</div>
                            <div class="col-7 text-heading d-flex align-items-center gap-1">
                                <i class="ti ti-calendar text-muted"></i> {{ $order->tgl_masuk->format('d M Y') }}
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col-5 text-secondary small">Estimasi Selesai</div>
                            <div class="col-7 text-heading d-flex align-items-center gap-1">
                                <i class="ti ti-clock text-muted"></i> {{ $order->estimasi_selesai->format('d M Y') }}
                            </div>
                        </div>
                        @if($order->tgl_diambil)
                            <div class="row align-items-center mb-2">
                                <div class="col-5 text-secondary small">Tanggal Diambil</div>
                                <div class="col-7 text-success font-weight-medium d-flex align-items-center gap-1">
                                    <i class="ti ti-package-export"></i> {{ $order->tgl_diambil->format('d M Y') }}
                                </div>
                            </div>
                        @endif
                        <div class="row align-items-start mb-0">
                            <div class="col-5 text-secondary small">Catatan Tambahan</div>
                            <div class="col-7 text-heading small">{{ $order->catatan ?? '-' }}</div>
                        </div>
                    </div>

                    <!-- Ringkasan Status & Tagihan -->
                    <div class="p-3 bg-muted-lt">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-secondary small">Status Pengerjaan</span>
                            <span
                                class="badge bg-{{ $order->status_badge }}-lt text-{{ $order->status_badge }} rounded-pill px-2.5 py-1 text-capitalize">{{ $order->status_label }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-secondary small">Status Pembayaran</span>
                            @if($order->status_bayar === 'lunas')
                                <span class="badge bg-success-lt text-success rounded-pill px-2.5 py-1">
              <i class="ti ti-circle-check me-1"></i> Lunas ({{ ucfirst($order->metode_bayar) }})
            </span>
                            @else
                                <span class="badge bg-danger-lt text-danger rounded-pill px-2.5 py-1">
              <i class="ti ti-alert-circle me-1"></i> Belum Bayar
            </span>
                            @endif
                        </div>
                        <div class="border-top border-white-10 my-2"></div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="font-weight-medium text-heading">Total Tagihan</span>
                            <span class="fw-bold text-primary fs-3">{{ $order->total_formatted }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Status Alur Laundry -->
            <div class="card mb-3">
                <div class="card-header py-2">
                    <h3 class="card-title text-heading">Perbarui Status Kerja</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.updateStatus', $order) }}" method="POST" id="formUpdateStatus">
                        @csrf @method('PATCH')
                        <div class="mb-3">
                            <select name="status" id="statusSelect" class="form-select">
                                @foreach(['antri'=>'Antri','proses'=>'Diproses','selesai'=>'Selesai','diambil'=>'Sudah Diambil'] as $val => $label)
                                    <option
                                        value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit"
                                class="btn btn-info w-100 d-flex align-items-center justify-content-center gap-1"
                                style="border-radius: 6px;">
                            <i class="ti ti-refresh fs-2"></i> Update Status Kerja
                        </button>
                    </form>
                </div>
            </div>

            <!-- Konfirmasi Kasir (Hanya jika belum lunas) -->
            @if($order->status_bayar === 'belum')
                <div class="card border-success">
                    <div class="card-status-top bg-success"></div>
                    <div class="card-header py-2 bg-success-lt">
                        <h3 class="card-title text-success font-weight-medium">Konfirmasi Pembayaran</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('orders.bayar', $order) }}" method="POST" id="formBayar">
                            @csrf @method('PATCH')
                            <div class="mb-3">
                                <label class="form-label text-secondary small">Metode Pembayaran</label>
                                <div class="d-flex gap-3 mt-1">
                                    <label class="form-check m-0">
                                        <input type="radio" name="metode_bayar" class="form-check-input" value="tunai"
                                               checked style="cursor: pointer;">
                                        <span class="form-check-label text-heading" style="cursor: pointer;">
                  <i class="ti ti-cash me-0.5 text-success"></i> Tunai
                </span>
                                    </label>
                                    <label class="form-check m-0">
                                        <input type="radio" name="metode_bayar" class="form-check-input"
                                               value="transfer" style="cursor: pointer;">
                                        <span class="form-check-label text-heading" style="cursor: pointer;">
                  <i class="ti ti-arrows-exchange me-0.5 text-blue"></i> Transfer / QRIS
                </span>
                                    </label>
                                </div>
                            </div>
                            <button type="submit"
                                    class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-1"
                                    style="border-radius: 6px;">
                                <i class="ti ti-check fs-2"></i> Konfirmasi Lunas & Simpan
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        <!-- ===== COLUMN KANAN: RINCIAN TABEL ITEM LAYANAN ===== -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-heading">Detail Item Cucian</h3>
                </div>

                <div class="table-responsive">
                    <table class="table table-vcenter card-table text-nowrap">
                        <thead>
                        <tr>
                            <th class="w-1 text-center">No</th>
                            <th>Nama Layanan</th>
                            <th>Satuan Kerja</th>
                            <th class="text-end">Jumlah / Vol</th>
                            <th class="text-end">Harga Satuan</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->items as $i => $item)
                            <tr>
                                <td class="text-center text-secondary small">{{ $i + 1 }}</td>
                                <td>
                                    <div class="font-weight-medium text-heading">{{ $item->layanan->nama }}</div>
                                </td>
                                <td class="text-secondary small">{{ $item->layanan->satuan }}</td>
                                <td class="text-end text-heading font-weight-medium">{{ number_format($item->jumlah, 1) }}</td>
                                <td class="text-end text-secondary">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td class="text-end font-weight-medium text-heading">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr class="bg-muted-lt fw-bold text-heading">
                            <td colspan="5" class="text-end py-3">TOTAL YANG HARUS DIBAYAR :</td>
                            <td class="text-end text-primary py-3 fs-3">{{ $order->total_formatted }}</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ===== Konfirmasi Update Status Kerja =====
            const formUpdateStatus = document.getElementById('formUpdateStatus');
            if (formUpdateStatus) {
                formUpdateStatus.addEventListener('submit', function (e) {
                    if (formUpdateStatus.dataset.confirmed === 'true') {
                        return;
                    }
                    e.preventDefault();

                    const statusSelect = document.getElementById('statusSelect');
                    const labelStatus = statusSelect.options[statusSelect.selectedIndex].text;

                    Swal.fire({
                        title: 'Update Status Kerja?',
                        html: `Status order akan diubah menjadi <b>${labelStatus}</b>.`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Update',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#4299e1', // warna info Tabler
                        cancelButtonColor: '#626976',
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            formUpdateStatus.dataset.confirmed = 'true';
                            formUpdateStatus.submit();
                        }
                    });
                });
            }

            // ===== Konfirmasi Pembayaran Lunas =====
            const formBayar = document.getElementById('formBayar');
            if (formBayar) {
                formBayar.addEventListener('submit', function (e) {
                    if (formBayar.dataset.confirmed === 'true') {
                        return;
                    }
                    e.preventDefault();

                    const metode = formBayar.querySelector('input[name="metode_bayar"]:checked');
                    const labelMetode = metode.value === 'tunai' ? 'Tunai' : 'Transfer / QRIS';

                    Swal.fire({
                        title: 'Konfirmasi Pembayaran?',
                        html: `Order akan ditandai <b>Lunas</b> dengan metode <b>${labelMetode}</b>.<br>Pastikan pembayaran sudah benar-benar diterima.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Sudah Lunas',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#2fb344', // warna success Tabler
                        cancelButtonColor: '#626976',
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            formBayar.dataset.confirmed = 'true';
                            formBayar.submit();
                        }
                    });
                });
            }

            // ===== Flash Success (mis. setelah redirect balik ke halaman ini) =====
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

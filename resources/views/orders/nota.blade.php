<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota {{ $order->kode_order }} — LaundryKu</title>
    <style>
        /* Reset & Base Styling khusus untuk printer thermal kasir */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            color: #000;
            width: 80mm;
            padding: 4px;
            background-color: #fff;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
        }

        h2 {
            font-size: 15px;
            margin-bottom: 2px;
            letter-spacing: 1px;
        }

        .total-row {
            font-size: 12px;
            font-weight: bold;
            margin-top: 2px;
        }

        .item-meta {
            font-size: 10px;
            color: #333;
            padding-left: 4px;
        }

        /* Aturan CSS khusus saat mode print aktif */
        @media print {
            body {
                width: 80mm;
                margin: 0;
                padding: 4px;
            }

            /* Menghilangkan header/footer bawaan browser seperti tanggal/url */
            @page {
                margin: 0;
            }
        }
    </style>
</head>
<body>

<!-- Header Bisnis dengan Logo SVG Minimalis -->
<div class="center bold" style="margin-top: 4px; margin-bottom: 6px;">
    <!-- Logo Mesin Cuci LaundryKu (Sesuai dengan branding aplikasi) -->
    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#000"
         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
         style="margin-bottom: 4px; display: inline-block;">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <path d="M5 3m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z"/>
        <path d="M12 14m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/>
        <path d="M8 6h.01"/>
        <path d="M11 6h.01"/>
        <path d="M14 6h.01"/>
        <path d="M8 14c1.333 -.667 2.667 -.667 4 0c1.333 .667 2.667 .667 4 0"/>
    </svg>
    <h2>LAUNDRYKU</h2>
    <div style="font-size: 10px; font-weight: normal; letter-spacing: 0.5px;">Sistem Manajemen Laundry Modern</div>
</div>

<div class="divider"></div>

<!-- Informasi Transaksi -->
<div class="row">
    <span>KODE  : <span class="bold">{{ $order->kode_order }}</span></span>
</div>
<div class="row">
    <span>TGL   : {{ $order->tgl_masuk->format('d/m/Y H:i') }}</span>
</div>
<div class="row">
    <span>KASIR : {{ $order->user->name }}</span>
</div>

<div class="divider"></div>

<!-- Informasi Pelanggan -->
<div class="row">
    <span>PELANGGAN : <span class="bold">{{ $order->pelanggan->nama }}</span></span>
</div>
<div class="row">
    <span>TELP      : {{ $order->pelanggan->telepon ?? '-' }}</span>
</div>
<div class="row">
    <span>EST. SELESAI : <span class="bold">{{ $order->estimasi_selesai->format('d/m/Y') }}</span></span>
</div>

<div class="divider"></div>

<!-- Daftar Item Cucian -->
@foreach($order->items as $item)
    <div style="margin-bottom: 4px;">
        <div class="bold">{{ $item->layanan->nama }}</div>
        <div class="row item-meta">
            <span>{{ number_format($item->jumlah, 1) }} {{ $item->layanan->satuan }} x Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
            <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
        </div>
    </div>
@endforeach

<div class="divider"></div>

<!-- Ringkasan Pembayaran -->
<div class="row total-row">
    <span>TOTAL</span>
    <span>{{ $order->total_formatted }}</span>
</div>
<div class="row">
    <span>Status Bayar</span>
    <span class="bold">
      {{ $order->status_bayar === 'lunas' ? 'LUNAS ('.strtoupper($order->metode_bayar).')' : 'BELUM BAYAR' }}
    </span>
</div>

<!-- Catatan Nota Tambahan -->
@if($order->catatan)
    <div class="divider"></div>
    <div style="font-size: 10px; font-style: italic;">
        Catatan: {{ $order->catatan }}
    </div>
@endif

<div class="divider"></div>

<!-- Footer Nota -->
<div class="center" style="margin-top: 6px;">
    <div>Terima kasih atas kepercayaan Anda!</div>
    <div class="bold" style="font-size: 10px; margin-top: 4px;">**** SIMPAN NOTA INI ****</div>
</div>

<!-- Auto Print Script ketika halaman dimuat -->
<script>
    window.addEventListener('DOMContentLoaded', () => {
        window.print();
        // Opsional: Tutup tab otomatis setelah dialog print ditutup
        window.onafterprint = function () {
            window.close();
        };
    });
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Transaksi — Periode {{ $namaBulan }}</title>
  <style>
    /* Print-Safe CSS styling optimized for DOMPDF/Laravel PDF Engines */
    @page {
      margin: 1.5cm 1.5cm 1.5cm 1.5cm;
    }
    body { 
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
      font-size: 11px; 
      color: #333333;
      line-height: 1.4;
    }
    
    /* Header Styles */
    .header-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 25px;
      border-bottom: 2px solid #0054a6;
      padding-bottom: 15px;
    }
    .brand-title {
      font-size: 20px;
      font-weight: bold;
      color: #0054a6;
      letter-spacing: 0.5px;
    }
    .brand-sub {
      font-size: 11px;
      color: #666666;
      margin-top: 3px;
    }
    .report-title {
      text-align: right;
      font-size: 14px;
      font-weight: bold;
      color: #333333;
    }
    .report-period {
      text-align: right;
      font-size: 11px;
      color: #666666;
      margin-top: 3px;
    }

    /* Summary Grid (Using traditional Table to avoid Flexbox bugs in PDF engine) */
    .summary-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 10px 0;
      margin-bottom: 25px;
      margin-left: -10px;
      margin-right: -10px;
    }
    .summary-card {
      width: 33.33%;
      background: #f8f9fa;
      border: 1px solid #e9ecef;
      border-radius: 6px;
      padding: 12px 15px;
      vertical-align: top;
    }
    .summary-label {
      font-size: 9px;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      color: #6c757d;
      margin-bottom: 5px;
      font-weight: bold;
    }
    .summary-value {
      font-size: 16px;
      font-weight: bold;
      color: #1d273b;
    }
    .summary-value-highlight {
      font-size: 16px;
      font-weight: bold;
      color: #2fb344; /* Success green */
    }

    /* Table Styles */
    .data-table { 
      width: 100%; 
      border-collapse: collapse; 
      margin-top: 15px; 
    }
    .data-table th { 
      background: #0054a6; 
      color: #ffffff; 
      padding: 8px 10px; 
      text-align: left; 
      font-size: 10px;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .data-table td { 
      padding: 8px 10px; 
      border-bottom: 1px solid #e9ecef; 
      font-size: 10px;
      color: #495057;
    }
    .data-table tr:nth-child(even) td { 
      background: #fdfdfd; 
    }
    
    /* Utility Badges */
    .badge {
      display: inline-block;
      padding: 3px 8px;
      font-size: 9px;
      font-weight: bold;
      border-radius: 4px;
      text-align: center;
    }
    .badge-lunas { 
      background: #d1fae5; 
      color: #065f46; 
    }
    .badge-belum { 
      background: #fee2e2; 
      color: #991b1b; 
    }
    .badge-status {
      background: #e9ecef;
      color: #495057;
    }
    
    .text-semibold {
      font-weight: 600;
    }
    .text-center {
      text-align: center;
    }
    .text-right {
      text-align: right;
    }

    /* Footer Metadata */
    .footer-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 40px;
      font-size: 9px;
      color: #868e96;
    }
  </style>
</head>
<body>

  <!-- ===== HEADER SECTION ===== -->
  <table class="header-table">
    <tr>
      <td style="vertical-align: middle;">
        <div class="brand-title">LAUNDRYKU</div>
        <div class="brand-sub">Sistem Manajemen Laundry Modern</div>
      </td>
      <td style="vertical-align: middle; text-align: right;">
        <div class="report-title">LAPORAN BULANAN TRANSAKSI</div>
        <div class="report-period">Periode: <span class="text-semibold">{{ $namaBulan }}</span></div>
      </td>
    </tr>
  </table>

  <!-- ===== SUMMARY CARDS SECTION ===== -->
  <table class="summary-table">
    <tr>
      <!-- Total Order Card -->
      <td class="summary-card">
        <div class="summary-label">Total Transaksi</div>
        <div class="summary-value">{{ $summary['total_order'] }} Order</div>
      </td>
      
      <!-- Total Pendapatan Card -->
      <td class="summary-card">
        <div class="summary-label">Total Pendapatan</div>
        <div class="summary-value-highlight">Rp {{ number_format($summary['total_pendapatan'],0,',','.') }}</div>
      </td>
      
      <!-- Waktu Cetak Card -->
      <td class="summary-card">
        <div class="summary-label">Waktu Cetak</div>
        <div class="summary-value" style="font-size: 13px; padding-top: 3px;">{{ now()->format('d/m/Y H:i') }}</div>
      </td>
    </tr>
  </table>

  <!-- ===== DATA TABLE SECTION ===== -->
  <table class="data-table">
    <thead>
      <tr>
        <th style="width: 15%;">Kode Order</th>
        <th style="width: 20%;">Nama Pelanggan</th>
        <th style="width: 15%;">Kasir</th>
        <th style="width: 15%;">Tanggal Masuk</th>
        <th style="width: 15%; text-align: right; padding-right: 15px;">Total Tagihan</th>
        <th style="width: 10%; text-align: center;">Status</th>
        <th style="width: 10%; text-align: center;">Bayar</th>
      </tr>
    </thead>
    <tbody>
      @forelse($orders as $order)
      <tr>
        <td class="text-semibold" style="color: #0054a6;">{{ $order->kode_order }}</td>
        <td class="text-semibold">{{ $order->pelanggan->nama }}</td>
        <td>{{ $order->user->name }}</td>
        <td>{{ $order->tgl_masuk->format('d/m/Y') }}</td>
        <td class="text-semibold" style="text-align: right; padding-right: 15px;">{{ $order->total_formatted }}</td>
        <td style="text-align: center;">
          <span class="badge badge-status">{{ $order->status_label }}</span>
        </td>
        <td style="text-align: center;">
          @if($order->status_bayar === 'lunas')
          <span class="badge badge-lunas">Lunas</span>
          @else
          <span class="badge badge-belum">Belum</span>
          @endif
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" class="text-center" style="color: #868e96; padding: 30px 0;">
          Tidak ada data transaksi yang tercatat pada periode ini.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <!-- ===== FOOTER SIGN-OFF ===== -->
  <table class="footer-table">
    <tr>
      <td>Dokumen ini dibuat otomatis oleh Sistem Manajemen LaundryKu.</td>
      <td class="text-right">&copy; {{ date('Y') }} LaundryKu. All rights reserved.</td>
    </tr>
  </table>

</body>
</html>
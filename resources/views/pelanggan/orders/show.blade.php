<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Pesanan</title>
</head>
<body>
<h1>Nota {{ $order->kode_order }}</h1>
<p>Tanggal masuk: {{ $order->tgl_masuk?->toDateString() }}</p>
<p>Status: {{ $order->getStatusLabelAttribute() }}</p>
<p>Total: {{ $order->getTotalFormattedAttribute() }}</p>
<h2>Items</h2>
<ul>
    @foreach($order->items as $item)
        <li>{{ $item->layanan->nama }} — {{ $item->jumlah }} {{ $item->layanan->satuan }} — Rp{{ number_format($item->subtotal,0,',','.') }}</li>
    @endforeach
</ul>
<p><a href="{{ route('pelanggan.orders.index') }}">Kembali</a></p>
</body>
</html>
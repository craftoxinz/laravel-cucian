<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pelanggan Dashboard</title>
</head>
<body>
<h1>Halo, {{ auth('pelanggan')->user()->nama }}</h1>
<p>Total pesanan: {{ $stats['total_orders'] }}</p>
<p>Pesanan tertunda: {{ $stats['pending'] }}</p>
<h2>Pesanan Terakhir</h2>
<ul>
    @foreach($orders as $o)
        <li><a href="{{ route('pelanggan.orders.show', $o->id) }}">{{ $o->kode_order }} - {{ $o->getTotalFormattedAttribute() }}</a></li>
    @endforeach
</ul>
<p><a href="{{ route('pelanggan.orders.index') }}">Lihat semua pesanan</a></p>
<form method="post" action="{{ route('pelanggan.logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
</body>
</html>

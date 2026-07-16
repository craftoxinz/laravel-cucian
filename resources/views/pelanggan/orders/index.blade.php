<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pesanan Saya</title>
</head>
<body>
<h1>Pesanan Saya</h1>
<ul>
    @foreach($orders as $order)
        <li>
            <a href="{{ route('pelanggan.orders.show', $order->id) }}">{{ $order->kode_order }}</a>
            - {{ $order->getTotalFormattedAttribute() }} - {{ $order->getStatusLabelAttribute() }}
        </li>
    @endforeach
</ul>
{{ $orders->links() }}
<p><a href="{{ route('pelanggan.dashboard') }}">Kembali ke dashboard</a></p>
</body>
</html>
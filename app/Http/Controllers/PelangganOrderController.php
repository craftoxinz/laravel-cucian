<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class PelangganOrderController extends Controller
{
    public function index()
    {
        $pelanggan = auth('pelanggan')->user();
        $orders = Order::with(['items.layanan'])->where('pelanggan_id', $pelanggan->id)->latest()->paginate(10);
        return view('pelanggan.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $pelanggan = auth('pelanggan')->user();
        if ($order->pelanggan_id !== $pelanggan->id) {
            abort(403);
        }
        $order->load(['items.layanan']);
        return view('pelanggan.orders.show', compact('order'));
    }
}

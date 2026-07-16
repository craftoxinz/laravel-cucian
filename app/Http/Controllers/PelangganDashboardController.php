<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class PelangganDashboardController extends Controller
{
    public function index()
    {
        $pelanggan = auth('pelanggan')->user();

        $stats = [
            'total_orders' => Order::where('pelanggan_id', $pelanggan->id)->count(),
            'pending' => Order::where('pelanggan_id', $pelanggan->id)->whereNotIn('status', ['diambil', 'dibatalkan'])->count(),
        ];

        $orders = Order::where('pelanggan_id', $pelanggan->id)->latest()->take(5)->get();

        return view('pelanggan.dashboard', compact('stats', 'orders'));
    }
}

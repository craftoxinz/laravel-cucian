<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $kurirId = auth()->id();
        $today = now()->toDateString();

        // 1. Ringkasan Statistik
        $stats = [
            // Order delivery umum yang belum ada kurirnya
            'menunggu_dijemput' => Order::where('tipe_order', 'delivery')
                ->whereNull('kurir_id')
                ->where('status_jemput', 'menunggu')
                ->count(),

            // Order aktif milik kurir ini yang belum selesai
            'sedang_diproses' => Order::where('kurir_id', $kurirId)
                ->where('status_jemput', '!=', 'selesai')
                ->count(),

            // Order yang selesai diantar/dijemput oleh kurir ini hari ini
            'selesai_hari_ini' => Order::where('kurir_id', $kurirId)
                ->where('status_jemput', 'selesai')
                ->whereDate('updated_at', $today)
                ->count(),

            // Total semua order yang pernah diselesaikan oleh kurir ini
            'total_selesai' => Order::where('kurir_id', $kurirId)
                ->where('status_jemput', 'selesai')
                ->count(),
        ];

        // 2. Order Aktif / Terbaru milik Kurir
        $activeOrders = Order::with(['pelanggan', 'user'])
            ->where('kurir_id', $kurirId)
            ->where('status_jemput', '!=', 'selesai')
            ->latest()
            ->take(5)
            ->get();

        // 3. Data Chart Aktivitas 7 Hari Terakhir (Selesai vs Diproses)
        $labels = [];
        $completedData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $labels[] = now()->subDays($i)->format('d M');

            $completedData[] = Order::where('kurir_id', $kurirId)
                ->where('status_jemput', 'selesai')
                ->whereDate('updated_at', $date)
                ->count();
        }

        return view('kurir.dashboard.index', compact('stats', 'activeOrders', 'labels', 'completedData'));
    }
}

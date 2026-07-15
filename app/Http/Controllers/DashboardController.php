<?php
namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Pelanggan;
use App\Models\Layanan;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $thisMonth = now()->month;
        $thisYear = now()->year;

        $stats = [
            'order_hari_ini'      => Order::whereDate('tgl_masuk', $today)->count(),
            'order_antri'         => Order::where('status', 'antri')->count(),
            'order_proses'        => Order::where('status', 'proses')->count(),
            'order_selesai'       => Order::where('status', 'selesai')->where('status_bayar', 'belum')->count(),
            'pendapatan_hari_ini' => Order::whereDate('tgl_masuk', $today)->where('status_bayar', 'lunas')->sum('total'),
            'pendapatan_bulan'    => Order::whereMonth('tgl_masuk', $thisMonth)->whereYear('tgl_masuk', $thisYear)->where('status_bayar', 'lunas')->sum('total'),
            'total_pelanggan'     => Pelanggan::count(),
            'total_order_bulan'   => Order::whereMonth('tgl_masuk', $thisMonth)->whereYear('tgl_masuk', $thisYear)->count(),
        ];

        $recentOrders = Order::with(['pelanggan', 'user'])->latest()->take(8)->get();

        $chartData = Order::selectRaw('DATE(tgl_masuk) as tanggal, SUM(total) as total')
            ->where('status_bayar', 'lunas')
            ->whereBetween('tgl_masuk', [now()->subDays(6)->toDateString(), $today])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get()
            ->keyBy('tanggal');

        $labels = [];
        $revenues = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $labels[] = now()->subDays($i)->format('d M');
            $revenues[] = $chartData->get($date)?->total ?? 0;
        }

        return view('dashboard.index', compact('stats', 'recentOrders', 'labels', 'revenues'));
    }
}
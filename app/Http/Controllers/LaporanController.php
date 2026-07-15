<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $orders = Order::with(['pelanggan', 'user'])
            ->whereMonth('tgl_masuk', $bulan)
            ->whereYear('tgl_masuk', $tahun)
            ->latest()
            ->get();

        $summary = [
            'total_order'       => $orders->count(),
            'total_pendapatan'  => $orders->where('status_bayar', 'lunas')->sum('total'),
            'belum_bayar'       => $orders->where('status_bayar', 'belum')->count(),
            'sudah_diambil'     => $orders->where('status', 'diambil')->count(),
        ];

        $tahunList = Order::selectRaw('YEAR(tgl_masuk) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();

        if (empty($tahunList)) {
            $tahunList = [now()->year];
        }

        return view('laporan.index', compact('orders', 'summary', 'bulan', 'tahun', 'tahunList'));
    }

   public function export(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;
        $tahun = $request->tahun ?? now()->year;

        $namaBulan = \Carbon\Carbon::create(null, $bulan)->format('F') . ' ' . $tahun;

        $orders = Order::with(['pelanggan', 'user'])
            ->whereMonth('tgl_masuk', $bulan)
            ->whereYear('tgl_masuk', $tahun)
            ->latest()
            ->get();

        $summary = [
            'total_order'      => $orders->count(),
            'total_pendapatan' => $orders->where('status_bayar', 'lunas')->sum('total'),
            'belum_bayar'      => $orders->where('status_bayar', 'belum')->count(),
            'sudah_diambil'    => $orders->where('status', 'diambil')->count(),
        ];

        $pdf = Pdf::loadView('laporan.pdf', compact('orders', 'summary', 'bulan', 'tahun', 'namaBulan'))
            ->setPaper('a4', 'landscape');

        return $pdf->download("laporan-{$tahun}-{$bulan}.pdf");
    }
}
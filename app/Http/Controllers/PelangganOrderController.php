<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelangganOrderController extends Controller
{
    public function index()
    {
        $pelanggan = auth('pelanggan')->user();
        $query = Order::with(['items.layanan'])
            ->where('pelanggan_id', $pelanggan->id)
            ->latest();

        $pendingOrders = (clone $query)->where('status', 'antri')->get();
        $approvedOrders = (clone $query)->whereNotIn('status', ['antri', 'dibatalkan'])->get();

        return view('pelanggan.orders.index', compact('pendingOrders', 'approvedOrders'));
    }

    public function create()
    {
        $layanan = Layanan::where('is_active', true)->get();
        $pelanggan = auth('pelanggan')->user();
        return view('pelanggan.orders.create', compact('layanan', 'pelanggan'));
    }

    public function store(Request $request)
    {
        $pelanggan = auth('pelanggan')->user();

        $request->validate([
            'estimasi_selesai' => 'nullable|date|after_or_equal:today',
            'catatan' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.layanan_id' => 'required|exists:layanan,id',
            'items.*.jumlah' => 'required|numeric|min:0.1',
            'tipe_order' => 'required|in:datang_langsung,delivery',
            'alamat_jemput' => 'required_if:tipe_order,delivery|nullable|string',
        ]);

        DB::transaction(function () use ($request, $pelanggan) {
            $total = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $layanan = Layanan::findOrFail($item['layanan_id']);
                $subtotal = $layanan->harga * $item['jumlah'];
                $total += $subtotal;
                $itemsData[] = [
                    'layanan_id' => $layanan->id,
                    'jumlah' => $item['jumlah'],
                    'harga' => $layanan->harga,
                    'subtotal' => $subtotal,
                ];
            }

            $order = Order::create([
                'kode_order' => Order::generateKode(),
                'pelanggan_id' => $pelanggan->id,
                'user_id' => null,
                'status' => 'antri',
                'status_bayar' => 'belum',
                'tgl_masuk' => today(),
                'estimasi_selesai' => $request->estimasi_selesai ?: now()->addDays(2)->toDateString(),
                'total' => $total,
                'catatan' => $request->catatan,
                'tipe_order' => $request->tipe_order,
                'alamat_jemput' => $request->tipe_order === 'delivery' ? $request->alamat_jemput : null,
                'status_jemput' => $request->tipe_order === 'delivery' ? 'menunggu' : null,
            ]);

            foreach ($itemsData as $item) {
                $order->items()->create($item);
            }
        });

        return redirect()->route('pelanggan.orders.index')
            ->with('success', 'Order baru Anda berhasil dibuat. Silakan tunggu persetujuan kasir.');
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

    public function cancel(Order $order)
    {
        $pelanggan = auth('pelanggan')->user();
        if ($order->pelanggan_id !== $pelanggan->id) {
            abort(403);
        }

        if ($order->status !== 'antri') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan setelah diproses oleh kasir.');
        }

        $order->update(['status' => 'dibatalkan']);

        return redirect()->route('pelanggan.orders.index')->with('success', 'Pesanan berhasil dibatalkan.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pelanggan;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['pelanggan', 'user', 'kurir'])->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->status_bayar) {
            $query->where('status_bayar', $request->status_bayar);
        }
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_order', 'like', "%{$request->search}%")
                    ->orWhereHas('pelanggan', fn($p) => $p->where('nama', 'like', "%{$request->search}%"));
            });
        }

        if (auth()->user()->isKasir()) {
            $pendingOrders = (clone $query)->where('status', 'antri')->get();
            $approvedOrders = (clone $query)->whereNotIn('status', ['antri', 'dibatalkan'])->get();
            return view('orders.index', compact('pendingOrders', 'approvedOrders'));
        }

        $orders = $query->paginate(10)->withQueryString();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::orderBy('nama')->get();
        $layanan = Layanan::where('is_active', true)->get();
        return view('orders.create', compact('pelanggan', 'layanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'estimasi_selesai' => 'required|date|after_or_equal:today',
            'catatan' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.layanan_id' => 'required|exists:layanan,id',
            'items.*.jumlah' => 'required|numeric|min:0.1',
            'tipe_order' => 'required|in:datang_langsung,delivery',
            'alamat_jemput' => 'required_if:tipe_order,delivery|nullable|string',
        ]);

        DB::transaction(function () use ($request) {
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
                'pelanggan_id' => $request->pelanggan_id,
                'user_id' => auth()->id(),
                'status' => 'antri',
                'status_bayar' => 'belum',
                'tgl_masuk' => today(),
                'estimasi_selesai' => $request->estimasi_selesai,
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

        return redirect()->route('orders.index')->with('success', 'Order berhasil dibuat.');
    }

    public function approve(Order $order)
    {
        abort_unless(auth()->user()->isKasir(), 403, 'Hanya kasir yang dapat menyetujui order.');
        abort_if($order->status !== 'antri', 403, 'Order ini sudah tidak dalam status antri.');

        $order->update([
            'status' => 'proses',
            'user_id' => $order->user_id ?? auth()->id(),
        ]);

        return back()->with('success', "Order {$order->kode_order} berhasil disetujui.");
    }

    public function show(Order $order)
    {
        $order->load(['pelanggan', 'user', 'kurir', 'items.layanan']);
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:antri,proses,selesai,diambil,dibatalkan',
        ]);

        $data = ['status' => $request->status];
        if ($request->status === 'diambil') {
            $data['tgl_diambil'] = today();
        }

        $order->update($data);
        return back()->with('success', 'Status order berhasil diupdate.');
    }

    public function bayar(Request $request, Order $order)
    {
        $request->validate([
            'metode_bayar' => 'required|in:tunai,transfer',
        ]);

        $order->update([
            'status_bayar' => 'lunas',
            'metode_bayar' => $request->metode_bayar,
        ]);

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function nota(Order $order)
    {
        $order->load(['pelanggan', 'user', 'items.layanan']);
        $pdf = Pdf::loadView('orders.nota', compact('order'))->setPaper([0, 0, 226.77, 500], 'portrait');
        return $pdf->stream("nota-{$order->kode_order}.pdf");
    }
}

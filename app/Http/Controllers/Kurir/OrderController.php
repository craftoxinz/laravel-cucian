<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'menunggu');

        $query = Order::with(['pelanggan', 'user'])
            ->where('tipe_order', 'delivery');

        if ($tab === 'saya') {
            // Tampilkan semua riwayat order yang pernah/sedang diambil kurir ini
            $query->where('kurir_id', auth()->id());
        } else {
            $query->whereNull('kurir_id')->where('status_jemput', 'menunggu');
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_order', 'like', "%{$request->search}%")
                    ->orWhereHas('pelanggan', fn($p) => $p->where('nama', 'like', "%{$request->search}%"));
            });
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('kurir.orders.index', compact('orders', 'tab'));
    }

    public function approve(Order $order)
    {
        abort_if(
            $order->tipe_order !== 'delivery' || $order->kurir_id !== null,
            403,
            'Order ini sudah diambil kurir lain atau bukan order delivery.'
        );

        $order->update([
            'kurir_id' => auth()->id(),
            'status_jemput' => 'menuju_lokasi',
        ]);

        return back()->with('success', "Order {$order->kode_order} berhasil diambil. Silakan menuju lokasi penjemputan.");
    }

    public function updateStatusJemput(Request $request, Order $order)
    {
        abort_if($order->kurir_id !== auth()->id(), 403, 'Anda tidak berhak mengubah order ini.');

        $request->validate([
            'status_jemput' => 'required|in:menuju_lokasi,menuju_laundry,selesai_diantar,mengantar_ke_pelanggan,selesai',
        ]);

        $updateData = ['status_jemput' => $request->status_jemput];

        // Jika kurir sudah selesai mengantar kembali ke pelanggan, tandai juga status utama order menjadi selesai
        if ($request->status_jemput === 'selesai') {
            $updateData['status'] = 'selesai';
            $updateData['tgl_diambil'] = now();
        }

        $order->update($updateData);

        return back()->with('success', 'Status pengantaran berhasil diupdate.');
    }
}

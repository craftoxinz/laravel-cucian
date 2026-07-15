<?php
namespace App\Http\Controllers;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggan::withCount('orders');
        if ($request->search) {
            $query->where('nama', 'like', "%{$request->search}%")
                  ->orWhere('telepon', 'like', "%{$request->search}%");
        }
        $pelanggan = $query->latest()->paginate(10)->withQueryString();
        return view('pelanggan.index', compact('pelanggan'));
    }
    public function create()
    {
        return view('pelanggan.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:100',
            'telepon' => 'nullable|string|max:20',
            'alamat'  => 'nullable|string|max:255',
        ]);
        Pelanggan::create($request->only(['nama', 'telepon', 'alamat']));
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }
    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'nama'    => 'required|string|max:100',
            'telepon' => 'nullable|string|max:20',
            'alamat'  => 'nullable|string|max:255',
        ]);
        $pelanggan->update($request->only(['nama', 'telepon', 'alamat']));
        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diupdate.');
    }
    public function destroy(Pelanggan $pelanggan)
    {
        if ($pelanggan->orders()->exists()) {
            return back()->with('error', 'Pelanggan tidak dapat dihapus karena memiliki riwayat order.');
        }
        $pelanggan->delete();
        return back()->with('success', 'Pelanggan berhasil dihapus.');
    }
}
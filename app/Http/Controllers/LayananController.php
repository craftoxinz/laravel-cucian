<?php
namespace App\Http\Controllers;
use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::latest()->paginate(10);
        return view('layanan.index', compact('layanan'));
    }
    public function create()
    {
        return view('layanan.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:100',
            'satuan'    => 'required|in:kg,pcs',
            'harga'     => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);
        Layanan::create($request->only(['nama', 'satuan', 'harga', 'deskripsi']) + ['is_active' => true]);
        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil ditambahkan.');
    }
    public function edit(Layanan $layanan)
    {
        return view('layanan.edit', compact('layanan'));
    }
    public function update(Request $request, Layanan $layanan)
    {
        $request->validate([
            'nama'      => 'required|string|max:100',
            'satuan'    => 'required|in:kg,pcs',
            'harga'     => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        $layanan->update($request->only(['nama', 'satuan', 'harga', 'deskripsi']) + ['is_active' => $request->boolean('is_active')]);
        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil diupdate.');
    }
    public function destroy(Layanan $layanan)
    {
        $layanan->delete();
        return back()->with('success', 'Layanan berhasil dihapus.');
    }
}
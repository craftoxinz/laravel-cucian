<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // Wajib diimport untuk kelola file foto

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id'  => 'required|exists:roles,id',
            'gambar'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Validasi foto profil
        ]);

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role_id'   => $request->role_id,
            'is_active' => true,
        ];

        // Logika simpan gambar
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('users', 'public');
        }

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'password'  => 'nullable|string|min:6|confirmed',
            'role_id'   => 'required|exists:roles,id',
            // 'is_active' dihapus dari validasi karena $request->boolean() sudah menjamin output true/false
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Proteksi: Mencegah user mengubah status aktif atau role dirinya sendiri
        if ($user->id === auth()->id()) {
            $isActive = $user->is_active;
            $roleId = $user->role_id;
        } else {
            // Jika checkbox tidak dicentang, ini akan otomatis bernilai false
            $isActive = $request->boolean('is_active');
            $roleId = $request->role_id;
        }

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'role_id'   => $roleId,
            'is_active' => $isActive,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Logika update gambar (Sudah Bagus!)
        if ($request->hasFile('gambar')) {
            if ($user->gambar) {
                Storage::disk('public')->delete($user->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('users', 'public');
        }

        $user->update($data);

        $message = $user->id === auth()->id()
            ? 'Profil Anda berhasil diperbarui.'
            : 'User berhasil diupdate.';

        return redirect()->route('users.index')->with('success', $message);
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        // Hapus file gambar dari server sebelum data user dihapus
        if ($user->gambar) {
            Storage::disk('public')->delete($user->gambar);
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }
}

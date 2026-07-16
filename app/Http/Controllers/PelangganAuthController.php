<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggan;

class PelangganAuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:pelanggan,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $pelanggan = Pelanggan::create([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_member' => true,
            'is_active' => true,
        ]);

        Auth::guard('pelanggan')->login($pelanggan);
        $request->session()->regenerate();

        return redirect()->route('pelanggan.dashboard');
    }

    public function showLogin()
    {
        // reuse the shared auth.login view
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $pel = Pelanggan::where('email', $request->email)->first();
        if (!$pel || !Hash::check($request->password, $pel->password ?? '')) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
        }

        if (!$pel->is_active) {
            return back()->withErrors(['email' => 'Akun tidak aktif.'])->onlyInput('email');
        }

        Auth::guard('pelanggan')->login($pel, $request->filled('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('pelanggan.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::guard('pelanggan')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}

<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pelanggan;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) return redirect()->route('dashboard');
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // First try to authenticate as a staff user
        $user = \App\Models\User::where('email', $request->email)->first();
        if ($user) {
            if (!Hash::check($request->password, $user->password)) {
                return back()->withErrors(['password' => 'Password salah.'])->onlyInput('email');
            }
            if (!$user->is_active) {
                return back()->withErrors(['email' => 'Akun Anda tidak aktif. Hubungi admin.'])->onlyInput('email');
            }
            Auth::login($user, $request->filled('remember'));
            $request->session()->regenerate();
            if ($user->role?->name === 'kurir') {
                return redirect()->intended(route('kurir.dashboard.index'));
            }
            return redirect()->intended(route('dashboard'));
        }

        // If no staff user found, try Pelanggan (customer) login
        $pel = Pelanggan::where('email', $request->email)->first();
        if ($pel) {
            if (!Hash::check($request->password, $pel->password ?? '')) {
                return back()->withErrors(['password' => 'Password salah.'])->onlyInput('email');
            }
            if (!$pel->is_active) {
                return back()->withErrors(['email' => 'Akun tidak aktif.'])->onlyInput('email');
            }
            Auth::guard('pelanggan')->login($pel, $request->filled('remember'));
            $request->session()->regenerate();
            return redirect()->intended(route('pelanggan.dashboard'));
        }

        return back()->withErrors(['email' => 'Email tidak terdaftar.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Logout from both guards to be safe
        Auth::guard('web')->logout();
        Auth::guard('pelanggan')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}

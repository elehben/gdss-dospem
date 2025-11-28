<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. Tampilkan Form Login
    public function loginForm()
    {
        // Jika sudah login, lempar ke dashboard masing-masing
        if (Auth::check()) {
            if (auth()->user()->isAdmin()) {
                return redirect()->route('dashboard'); // Logic dashboard akan handle tampilan admin
            }
            return redirect()->route('dashboard'); // Logic dashboard akan handle tampilan user
        }

        return view('auth.login');
    }

    // 2. Proses Login
    public function loginProcess(Request $request)
    {
        // Validasi Input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba Login
        if (Auth::attempt($credentials)) {
            // Regenerasi Session ID (Keamanan Fixation)
            $request->session()->regenerate();

            // Cek Role dan Redirect
            // Kita arahkan ke satu route 'dashboard' saja, 
            // karena di DashboardController sudah ada logika pemisah Admin/User.
            return redirect()->intended(route('dashboard'));
            
            // return redirect()->route('dashboard');
        }

        // Gagal Login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // 3. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // 4. Tampilkan Halaman Profil
    public function profile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    // 5. Update Profil
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id_user . ',id_user'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    // 6. Update Password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'min:4', 'confirmed'],
        ]);

        $user = Auth::user();

        // Cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ================= LOGIN =================
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->status_user === 'tidak_aktif') {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun kamu tidak aktif.']);
            }

            $request->session()->regenerate();
            return $this->redirectByRole(Auth::user());
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    // ================= REGISTER =================
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_user' => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6|confirmed',
            'role'      => 'required|in:pembeli,penjual',
        ]);

        $user = User::create([
            'nama_user'   => $request->nama_user,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role'        => $request->role,
            'tgl_daftar'  => now()->toDateString(),
            'foto_profil' => null,
            'status_user' => 'aktif',
        ]);

        Auth::login($user);
        return $this->redirectByRole($user);
    }

    // ================= LOGOUT =================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // ================= HELPER =================
    private function redirectByRole($user)
    {
        return match ($user->role) {
            'pembeli' => redirect()->route('pembeli.dashboard'),
            'penjual' => redirect()->route('penjual.dashboard'),
            default   => redirect('/'),
        };
    }
}
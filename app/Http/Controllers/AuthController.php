<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'username' => ['required', 'string', 'max:64', Rule::unique('users', 'username')],
            'password' => ['required', 'string', 'min:6', 'max:255'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'username' => strtolower($data['username']),
            'email' => strtolower($data['username']).'@pelanggan.marketonik.local',
            'password' => $data['password'],
            'role' => User::ROLE_PEMBELI,
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('ok', 'Selamat datang di Marketonik Luxe.');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'max:64'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        $user = User::where('username', strtolower($data['username']))->first();

        if (! $user) {
            return back()->withErrors(['username' => 'Akun tidak ditemukan. Silakan daftar terlebih dahulu.'])->onlyInput('username');
        }

        if ($user->isAdmin()) {
            return back()->withErrors(['username' => 'Akun admin masuk lewat halaman admin.'])->onlyInput('username');
        }

        if (! Hash::check($data['password'], $user->password)) {
            return back()->withErrors(['password' => 'Password salah.'])->onlyInput('username');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('home'))->with('ok', 'Masuk berhasil.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('gate')->with('info', 'Anda telah keluar.');
    }
}

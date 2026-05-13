<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'username' => ['required', 'string', 'max:64', Rule::unique('users', 'username')],
            'password' => ['required', 'string', 'min:1', 'max:255'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'username' => strtolower($data['username']),
            'email' => strtolower($data['username']).'@pelanggan.marketonik.local',
            'password' => $data['password'],
        ]);

        Auth::login($user);

        return redirect()->route('toko.index')->with('ok', 'Selamat datang di Marketonik Luxe.');
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

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('toko.index'))->with('ok', 'Masuk berhasil.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('gate')->with('info', 'Anda telah keluar.');
    }
}

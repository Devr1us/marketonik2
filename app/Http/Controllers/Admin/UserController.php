<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $q = $request->string('q')->trim();

        $users = User::query()
            ->where('role', User::ROLE_PEMBELI)
            ->when($q->isNotEmpty(), function ($query) use ($q) {
                $query->where(function ($inner) use ($q) {
                    $inner->where('name', 'like', "%{$q}%")
                        ->orWhere('username', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->withCount(['orders', 'cartItems'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'q'));
    }

    public function show(User $user): View
    {
        abort_unless($user->isPembeli(), 404);

        $user->loadCount(['orders', 'cartItems', 'products']);
        $orders = $user->orders()->withCount('items')->latest()->take(10)->get();
        $products = $user->products()->latest()->take(10)->get();

        return view('admin.users.show', compact('user', 'orders', 'products'));
    }

    public function edit(User $user): View
    {
        abort_unless($user->isPembeli(), 404);

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->isPembeli(), 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        if (($data['password'] ?? '') !== '') {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.show', $user)->with('ok', 'Data pembeli berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_unless($user->isPembeli(), 404);

        $user->delete();

        return back()->with('ok', 'Pembeli berhasil dihapus.');
    }
}

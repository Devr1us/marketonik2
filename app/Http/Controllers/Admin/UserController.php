<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function destroy(User $user): RedirectResponse
    {
        abort_unless($user->isPembeli(), 404);

        $user->delete();

        return back()->with('ok', 'Pembeli berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $items = CartItem::query()
            ->where('user_id', $request->user()->id)
            ->with('product.seller')
            ->get();

        $subtotalOriginal = 0.0;
        $subtotalAfter = 0.0;
        foreach ($items as $item) {
            $p = $item->product;
            $subtotalOriginal += (float) $p->price * $item->quantity;
            $subtotalAfter += $p->effectivePrice() * $item->quantity;
        }

        return view('keranjang.index', [
            'items' => $items,
            'subtotalOriginal' => round($subtotalOriginal, 2),
            'subtotalAfter' => round($subtotalAfter, 2),
            'hemat' => round($subtotalOriginal - $subtotalAfter, 2),
        ]);
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->is_active && $product->stock > 0, 404);

        $data = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:'.$product->stock],
        ]);
        $qty = $data['quantity'] ?? 1;

        $row = CartItem::firstOrNew([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
        ]);
        $newQty = ($row->exists ? (int) $row->quantity : 0) + $qty;
        if ($newQty > $product->stock) {
            return back()->withErrors(['qty' => 'Stok tidak mencukupi.']);
        }
        $row->quantity = $newQty;
        $row->save();

        return back()->with('ok', 'Ditambahkan ke keranjang.');
    }

    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        abort_unless($cartItem->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $stock = (int) $cartItem->product->stock;
        if ($data['quantity'] > $stock) {
            return back()->withErrors(['quantity' => 'Melebihi stok.']);
        }

        $cartItem->update(['quantity' => $data['quantity']]);

        return back()->with('ok', 'Keranjang diperbarui.');
    }

    public function destroy(Request $request, CartItem $cartItem): RedirectResponse
    {
        abort_unless($cartItem->user_id === $request->user()->id, 403);
        $cartItem->delete();

        return back()->with('ok', 'Item dihapus.');
    }
}

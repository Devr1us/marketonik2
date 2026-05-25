<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        $items = CartItem::query()
            ->where('user_id', $request->user()->id)
            ->with('product')
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('keranjang.index')->with('info', 'Keranjang kosong.');
        }

        $subtotalOriginal = 0.0;
        $subtotalAfter = 0.0;
        foreach ($items as $item) {
            $p = $item->product;
            $subtotalOriginal += (float) $p->price * $item->quantity;
            $subtotalAfter += $p->effectivePrice() * $item->quantity;
        }

        return view('checkout.index', [
            'items' => $items,
            'subtotalOriginal' => round($subtotalOriginal, 2),
            'subtotalAfter' => round($subtotalAfter, 2),
            'hemat' => round($subtotalOriginal - $subtotalAfter, 2),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'payment_method'   => ['required', 'in:online,offline'],
            'shipping_address' => ['required', 'string', 'max:500'],
            'payment_proof'    => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
        ]);

        $items = CartItem::query()
            ->where('user_id', $request->user()->id)
            ->with('product')
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('keranjang.index')->with('info', 'Keranjang kosong.');
        }

        $subtotalOriginal = 0.0;
        $subtotalAfter = 0.0;
        foreach ($items as $item) {
            $p = $item->product;
            $subtotalOriginal += (float) $p->price * $item->quantity;
            $subtotalAfter += $p->effectivePrice() * $item->quantity;
        }
        $discountAmount = round($subtotalOriginal - $subtotalAfter, 2);
        $total = round($subtotalAfter, 2);

        $paid = $data['payment_method'] === 'online';
        $proofPath = $request->hasFile('payment_proof')
            ? $request->file('payment_proof')->store('payment-proofs', 'public')
            : null;
        $note = $paid
            ? 'Pembayaran online (simulasi) — transaksi selesai.'
            : 'Transfer ke Bank BSI 1234567890 a.n. Marketonik atau pilih COD. Admin akan mengonfirmasi pembayaran setelah bukti diterima.';

        $order = Order::create([
            'user_id'          => $request->user()->id,
            'order_code'       => 'MN-'.strtoupper(Str::random(10)),
            'subtotal'         => round($subtotalOriginal, 2),
            'discount_amount'  => $discountAmount,
            'total'            => $total,
            'payment_method'   => $data['payment_method'],
            'payment_status'   => $paid ? 'lunas' : ($proofPath ? 'menunggu' : 'pending'),
            'payment_note'     => $note,
            'payment_proof_path' => $proofPath,
            'shipping_status'  => 'menunggu',
            'shipping_address' => $data['shipping_address'],
        ]);

        foreach ($items as $item) {
            $p = $item->product;
            $unit = $p->effectivePrice();
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $p->id,
                'product_title' => $p->title,
                'quantity' => $item->quantity,
                'unit_price' => $unit,
                'discount_percent' => (int) $p->discount_percent,
                'line_total' => round($unit * $item->quantity, 2),
            ]);

            $p->decrement('stock', $item->quantity);
        }

        CartItem::where('user_id', $request->user()->id)->delete();

        return redirect()->route('pesanan.struk', $order)->with('ok', 'Pesanan dibuat.');
    }
}

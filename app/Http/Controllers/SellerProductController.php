<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\CreatesProducts;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerProductController extends Controller
{
    use CreatesProducts;

    public function create(): View
    {
        return view('products.create', [
            'layout' => 'layouts.app',
            'storeRoute' => route('jual.store'),
            'backRoute' => route('toko.index'),
            'pageTitle' => 'Jual produk',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateProductData($request);
        $this->persistProduct($request, $data, (int) $request->user()->id);

        return redirect()->route('toko.index')->with('ok', 'Produk berhasil ditambahkan.');
    }
}

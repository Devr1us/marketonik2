<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\CreatesProducts;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    use CreatesProducts;

    public function index(Request $request): View
    {
        $q = $request->string('q')->trim();

        $products = Product::query()
            ->with('seller:id,name,username')
            ->when($q->isNotEmpty(), fn ($query) => $query->where('title', 'like', "%{$q}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'q'));
    }

    public function create(): View
    {
        return view('products.create', [
            'layout' => 'layouts.admin',
            'storeRoute' => route('admin.products.store'),
            'backRoute' => route('admin.products.index'),
            'pageTitle' => 'Tambah produk (Admin)',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateProductData($request);
        $this->persistProduct($request, $data, (int) $request->user()->id);

        return redirect()->route('admin.products.index')->with('ok', 'Produk berhasil ditambahkan.');
    }

    public function toggle(Product $product): RedirectResponse
    {
        $product->update(['is_active' => ! $product->is_active]);

        return back()->with('ok', 'Status produk diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return back()->with('ok', 'Produk dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerProductController extends Controller
{
    public function create(): View
    {
        return view('jual.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string', 'max:5000'],
            'seller_location' => ['required', 'string', 'max:200'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount_percent' => ['required', 'integer', 'min:0', 'max:90'],
            'stock' => ['required', 'integer', 'min:0'],
            'photo' => ['nullable', 'image', 'max:5120', 'mimes:jpeg,jpg,png,webp,gif'],
            'spec_keys' => ['nullable', 'array'],
            'spec_keys.*' => ['nullable', 'string', 'max:80'],
            'spec_values' => ['nullable', 'array'],
            'spec_values.*' => ['nullable', 'string', 'max:255'],
        ]);

        $specs = [];
        $keys = $data['spec_keys'] ?? [];
        $vals = $data['spec_values'] ?? [];
        foreach ($keys as $i => $key) {
            $key = trim((string) $key);
            $val = trim((string) ($vals[$i] ?? ''));
            if ($key !== '' && $val !== '') {
                $specs[$key] = $val;
            }
        }

        if ($specs === []) {
            $specs['Ringkasan'] = 'Spesifikasi akan diperbarui penjual.';
        }

        $slug = Product::uniqueSlug((int) $request->user()->id, $data['title']);

        $imagePath = null;
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('products', 'public');
        }

        Product::create([
            'user_id' => $request->user()->id,
            'title' => $data['title'],
            'slug' => $slug,
            'description' => $data['description'],
            'seller_location' => $data['seller_location'],
            'specifications' => $specs,
            'price' => $data['price'],
            'discount_percent' => $data['discount_percent'],
            'stock' => $data['stock'],
            'image_url' => $imagePath,
            'is_active' => true,
        ]);

        return redirect()->route('toko.index')->with('ok', 'Produk berhasil ditambahkan.');
    }
}

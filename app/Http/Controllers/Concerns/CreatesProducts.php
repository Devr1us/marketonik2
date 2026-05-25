<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait CreatesProducts
{
    protected function validateProductData(Request $request): array
    {
        return $request->validate([
            'title'            => ['required', 'string', 'max:200'],
            'category'         => ['required', 'string', 'max:100'],
            'description'      => ['required', 'string', 'max:5000'],
            'seller_location'  => ['required', 'string', 'max:200'],
            'price'            => ['required', 'numeric', 'min:0'],
            'discount_percent' => ['required', 'integer', 'min:0', 'max:90'],
            'stock'            => ['required', 'integer', 'min:0'],
            'photo'            => ['nullable', 'image', 'max:5120', 'mimes:jpeg,jpg,png,webp,gif'],
            'spec_keys'        => ['nullable', 'array'],
            'spec_keys.*'      => ['nullable', 'string', 'max:80'],
            'spec_values'      => ['nullable', 'array'],
            'spec_values.*'    => ['nullable', 'string', 'max:255'],
        ]);
    }

    protected function buildSpecifications(array $data): array
    {
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

        return $specs;
    }

    protected function persistProduct(Request $request, array $data, int $userId): Product
    {
        $imagePath = null;
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('products', 'public');
        }

        return Product::create([
            'user_id'          => $userId,
            'title'            => $data['title'],
            'category'         => $data['category'] ?? 'Lainnya',
            'slug'             => Product::uniqueSlug($userId, $data['title']),
            'description'      => $data['description'],
            'seller_location'  => $data['seller_location'],
            'specifications'   => $this->buildSpecifications($data),
            'price'            => $data['price'],
            'discount_percent' => $data['discount_percent'],
            'stock'            => $data['stock'],
            'image_url'        => $imagePath,
            'is_active'        => true,
        ]);
    }

    protected function updateProduct(Request $request, Product $product, array $data): Product
    {
        $imagePath = $product->image_url;
        if ($request->boolean('remove_photo')) {
            $this->deleteLocalProductImage($product);
            $imagePath = null;
        }

        if ($request->hasFile('photo')) {
            $this->deleteLocalProductImage($product);
            $imagePath = $request->file('photo')->store('products', 'public');
        }

        $product->update([
            'title'            => $data['title'],
            'category'         => $data['category'],
            'slug'             => Product::uniqueSlug((int) $product->user_id, $data['title'], $product->id),
            'description'      => $data['description'],
            'seller_location'  => $data['seller_location'],
            'specifications'   => $this->buildSpecifications($data),
            'price'            => $data['price'],
            'discount_percent' => $data['discount_percent'],
            'stock'            => $data['stock'],
            'image_url'        => $imagePath,
        ]);

        return $product;
    }

    protected function deleteLocalProductImage(Product $product): void
    {
        $path = $product->image_url;
        if ($path && ! str_starts_with($path, 'http://') && ! str_starts_with($path, 'https://')) {
            Storage::disk('public')->delete($path);
        }
    }
}

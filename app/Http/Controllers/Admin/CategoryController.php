<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $q = $request->string('q')->trim();

        $categories = Category::query()
            ->withCount(['products' => fn ($query) => $query->where('is_active', true)])
            ->when($q->isNotEmpty(), fn ($query) => $query->where('name', 'like', "%{$q}%"))
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('admin.categories.index', compact('categories', 'q'));
    }

    public function create(): View
    {
        return view('admin.categories.form', [
            'category' => new Category(['is_active' => true]),
            'action' => route('admin.kategori.store'),
            'method' => 'POST',
            'title' => 'Tambah Kategori',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateCategory($request);
        $data['slug'] = Category::uniqueSlug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        Category::create($data);

        return redirect()->route('admin.kategori.index')->with('ok', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $kategori): View
    {
        return view('admin.categories.form', [
            'category' => $kategori,
            'action' => route('admin.kategori.update', $kategori),
            'method' => 'PUT',
            'title' => 'Edit Kategori',
        ]);
    }

    public function update(Request $request, Category $kategori): RedirectResponse
    {
        $oldName = $kategori->name;
        $data = $this->validateCategory($request, $kategori->id);
        $data['slug'] = Category::uniqueSlug($data['name'], $kategori->id);
        $data['is_active'] = $request->boolean('is_active');

        $kategori->update($data);
        Product::where('category', $oldName)->update(['category' => $kategori->name]);

        return redirect()->route('admin.kategori.index')->with('ok', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $kategori): RedirectResponse
    {
        if (Product::where('category', $kategori->name)->exists()) {
            return back()->withErrors(['category' => 'Kategori masih dipakai produk, nonaktifkan saja bila tidak ingin ditampilkan.']);
        }

        $kategori->delete();

        return back()->with('ok', 'Kategori berhasil dihapus.');
    }

    private function validateCategory(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categories,name'.($ignoreId ? ','.$ignoreId : '')],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);
    }
}

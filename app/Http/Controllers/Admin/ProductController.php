<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with('category');

        if ($search = $request->string('search')->toString()) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($categoryId = $request->integer('category')) {
            $query->where('category_id', $categoryId);
        }

        if ($sort = $request->input('sort')) {
            $query->when($sort === 'price_desc', fn ($q) => $q->orderByDesc('price'))
                ->when($sort === 'price_asc', fn ($q) => $q->orderBy('price'))
                ->when($sort === 'stock_desc', fn ($q) => $q->orderByDesc('stock'));
        } else {
            $query->latest();
        }

        $products = $query->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'url'],
        ]);

        Product::create($data);

        return redirect()->route('admin.products.index')->with('status', 'Producto creado correctamente.');
    }

    public function edit(int $id): View
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'url'],
        ]);

        $product->update($data);

        return redirect()->route('admin.products.index')->with('status', 'Producto actualizado correctamente.');
    }

    public function destroy(int $id): RedirectResponse
    {
        Product::whereKey($id)->delete();

        return redirect()->route('admin.products.index')->with('status', 'Producto eliminado.');
    }
}

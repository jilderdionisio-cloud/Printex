<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
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
            $query->when($sort === 'price_asc', fn ($q) => $q->orderBy('price'))
                ->when($sort === 'price_desc', fn ($q) => $q->orderByDesc('price'))
                ->when($sort === 'name_asc', fn ($q) => $q->orderBy('name'))
                ->when($sort === 'name_desc', fn ($q) => $q->orderByDesc('name'))
                ->when($sort === 'stock_desc', fn ($q) => $q->orderByDesc('stock'));
        } else {
            $query->latest();
        }

        $products = $query->paginate($request->integer('per_page', 12))->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(int $id): View
    {
        $product = Product::with(['category', 'supplier', 'reviews.user'])->findOrFail($id);
        $relatedProducts = Product::where('id', '!=', $product->id)->latest()->take(4)->get();
        $averageRating = round($product->reviews->avg('rating'), 1);
        $reviews = $product->reviews->sortByDesc('created_at');

        return view('products.show', compact('product', 'relatedProducts', 'averageRating', 'reviews'));
    }
}

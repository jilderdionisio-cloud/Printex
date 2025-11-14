<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = session('cart', []);

        return view('cart.index', [
            'cartItems' => collect($cart)->values(),
            'summary' => $this->summary($cart),
        ]);
    }

    public function add(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $product = Product::with('category')->findOrFail($validated['product_id']);
        $quantity = $validated['quantity'] ?? 1;
        $cart = session('cart', []);

        $cart[$product->id] = [
            'product' => $product,
            'quantity' => ($cart[$product->id]['quantity'] ?? 0) + $quantity,
        ];

        session(['cart' => $cart]);

        return back()->with('status', 'Producto agregado al carrito.');
    }

    public function update(Request $request, int $productId): RedirectResponse
    {
        $quantity = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ])['quantity'];

        $cart = session('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            session(['cart' => $cart]);
        }

        return back()->with('status', 'Cantidad actualizada.');
    }

    public function remove(int $productId): RedirectResponse
    {
        $cart = session('cart', []);
        unset($cart[$productId]);
        session(['cart' => $cart]);

        return back()->with('status', 'Producto eliminado del carrito.');
    }

    public function clear(): RedirectResponse
    {
        session()->forget('cart');

        return back()->with('status', 'Carrito vaciado.');
    }

    private function summary(array $cart): array
    {
        $subtotal = collect($cart)->sum(fn ($item) => $item['product']->price * $item['quantity']);

        return [
            'subtotal' => $subtotal,
            'discount' => 0,
            'total' => $subtotal,
        ];
    }
}

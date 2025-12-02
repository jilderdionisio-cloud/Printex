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
            'cartItems' => $cart,
            'summary' => $this->summary($cart),
        ]);
    }

    public function add(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:product'],
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $type = $validated['type'];
        if ($type !== 'product') {
            return back()->withErrors('Los cursos o videos se adquieren directamente desde su boton "Adquirir video".');
        }

        $quantity = $validated['quantity'] ?? 1;
        $cart = session('cart', []);

        $product = Product::with('category')->findOrFail($validated['product_id']);
        $key = "product-{$product->id}";
        $cart[$key] = [
            'type' => 'product',
            'product' => $product,
            'quantity' => ($cart[$key]['quantity'] ?? 0) + $quantity,
        ];
        $message = 'Producto agregado al carrito.';

        session(['cart' => $cart]);

        return back()->with('status', $message);
    }

    public function update(Request $request, string $itemKey): RedirectResponse
    {
        $quantity = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ])['quantity'];

        $cart = session('cart', []);

        if (isset($cart[$itemKey])) {
            $cart[$itemKey]['quantity'] = $quantity;
            session(['cart' => $cart]);
        }

        return back()->with('status', 'Cantidad actualizada.');
    }

    public function remove(string $itemKey): RedirectResponse
    {
        $cart = session('cart', []);
        unset($cart[$itemKey]);
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
        $subtotal = collect($cart)->sum(function ($item) {
            $price = $item['product']->price ?? 0;
            return $price * ($item['quantity'] ?? 1);
        });

        return [
            'subtotal' => $subtotal,
            'discount' => 0,
            'total' => $subtotal,
        ];
    }
}

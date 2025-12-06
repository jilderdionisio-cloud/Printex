<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function index(): View
    {
        $cart = collect(session('cart', []))
            ->filter(fn ($item) => ($item['type'] ?? 'product') === 'product')
            ->all();

        $summary = $this->summary($cart);

        return view('checkout', [
            'cartItems' => collect($cart)->values(),
            'summary' => $summary,
        ]);
    }

    public function process(Request $request): RedirectResponse
    {
        $cart = collect(session('cart', []))
            ->filter(fn ($item) => ($item['type'] ?? 'product') === 'product')
            ->all();

        if (empty($cart)) {
            return redirect()->route('cart.index')->withErrors('El carrito esta vacio.');
        }

        $validated = $request->validate([
            'payment_method' => ['required', 'string'],
            'shipping_address' => ['required', 'string', 'max:255'],
        ]);

        $userId = $request->user()->id;

        try {
            DB::transaction(function () use ($cart, $validated, $userId) {
                $summary = $this->summary($cart);

                $order = Order::create([
                    'user_id' => $userId,
                    'subtotal' => $summary['subtotal'],
                    'discount' => $summary['discount'],
                    'total' => $summary['total'],
                    'payment_method' => $validated['payment_method'],
                    'status' => 'Pendiente',
                    'shipping_address' => $validated['shipping_address'],
                ]);
                \App\Support\AuditLogger::log('created', $order);

                foreach ($cart as $item) {
                    $quantity = $item['quantity'] ?? 1;
                    $productId = $item['product']->id ?? null;

                    $product = Product::lockForUpdate()->find($productId);
                    if (! $product) {
                        throw ValidationException::withMessages(['cart' => 'Producto no encontrado.']);
                    }
                    if (! is_null($product->stock) && $product->stock < $quantity) {
                        throw ValidationException::withMessages([
                            'cart' => "Stock insuficiente para {$product->name}. Disponible: {$product->stock}.",
                        ]);
                    }

                    $baseData = [
                        'order_id' => $order->id,
                        'name' => $product->name ?? 'Producto',
                        'quantity' => $quantity,
                        'price' => $product->price ?? 0,
                        'item_type' => 'product',
                        'product_id' => $product->id ?? null,
                        'course_id' => null,
                    ];

                    OrderItem::create($baseData);

                    if ($baseData['product_id']) {
                        $product->increment('purchase_count', $quantity);
                        if (! is_null($product->stock)) {
                            $product->decrement('stock', $quantity);
                        }
                    }
                }
            });
        } catch (ValidationException $e) {
            return redirect()->route('cart.index')->withErrors($e->errors());
        }

        session()->forget('cart');

        return redirect()->route('checkout.index')->with('status', 'Pago exitoso. Tu pedido está en camino.');
    }

    private function summary(array $cart): array
    {
        $subtotal = collect($cart)->sum(function ($item) {
            $price = $item['product']->price ?? 0;
            $quantity = $item['quantity'] ?? 1;

            return $price * $quantity;
        });

        return [
            'subtotal' => $subtotal,
            'discount' => 0,
            'total' => $subtotal,
        ];
    }
}

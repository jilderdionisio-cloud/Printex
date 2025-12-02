<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

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

                $baseData = [
                    'order_id' => $order->id,
                    'name' => $item['product']->name ?? 'Producto',
                    'quantity' => $quantity,
                    'price' => $item['product']->price ?? 0,
                    'item_type' => 'product',
                    'product_id' => $item['product']->id ?? null,
                    'course_id' => null,
                ];

                OrderItem::create($baseData);

                if ($baseData['product_id']) {
                    $item['product']->increment('purchase_count', $quantity);
                }
            }
        });

        session()->forget('cart');

        return redirect()->route('orders.index')->with('status', 'Pedido confirmado con exito.');
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

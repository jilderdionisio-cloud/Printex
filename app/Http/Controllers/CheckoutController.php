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
        $cart = session('cart', []);
        $summary = $this->summary($cart);

        return view('checkout', [
            'cartItems' => collect($cart)->values(),
            'summary' => $summary,
            'user' => auth()->user(),
        ]);
    }

    public function process(Request $request): RedirectResponse
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->withErrors('El carrito está vacío.');
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

            foreach ($cart as $item) {
                $product = $item['product'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);
            }
        });

        session()->forget('cart');

        return redirect()->route('orders.index')->with('status', 'Pedido confirmado con éxito.');
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

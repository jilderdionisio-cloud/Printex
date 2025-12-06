<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::with(['items.product', 'items.course', 'user'])
            ->where('user_id', $request->user()->id)
            ->orderBy('id')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Request $request, int $id): View
    {
        $order = Order::with(['items.product', 'items.course', 'user'])
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with('user')->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(int $id): View
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        $data = $request->validate([
            'status' => ['required', 'in:Pendiente,Procesando,Enviado,Entregado,Cancelado'],
            'notes' => ['nullable', 'string'],
        ]);

        $order->update($data);

        return back()->with('status', 'Estado del pedido actualizado.');
    }
}

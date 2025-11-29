<?php
//pedido
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    //Ver todos los pedidos
    public function index(): View
    {
        $orders = Order::with('user')->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }
    //Ver un pedido específico
    public function show(int $id): View
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }
    //Cambiar el estado del pedido
    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        $data = $request->validate([
            'status' => ['required', 'in:Pendiente,Procesando,Enviado,Entregado,Cancelado'],
            'notes' => ['nullable', 'string'],
        ]);

        $order->status = $data['status'];
        $order->notes = $data['notes'] ?? null;
        $order->save();

        return back()->with('status', 'Estado del pedido actualizado.');
    }
}

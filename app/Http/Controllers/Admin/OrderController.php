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
        $statuses = ['Pendiente', 'Procesando', 'Enviado', 'Entregado', 'Cancelado', 'Pagado'];

        $orders = Order::with('user')
            ->when(request('status') && in_array(request('status'), $statuses), function ($q) {
                $q->where('status', request('status'));
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.orders.index', compact('orders', 'statuses'));
    }
    //Ver un pedido especÃ­fico
    public function show(int $id): View
    {
        $order = Order::with(['user', 'items.product', 'items.course'])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }
    //Cambiar el estado del pedido
    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        $data = $request->validate([
            'status' => ['required', 'in:Pendiente,Procesando,Enviado,Entregado,Cancelado,Pagado'],
            'notes' => ['nullable', 'string'],
        ]);

        $order->status = $data['status'];
        $order->notes = $data['notes'] ?? null;
        $order->save();
        \App\Support\AuditLogger::log('status_updated', $order);

        return back()->with('status', 'Estado del pedido actualizado.');
    }
}

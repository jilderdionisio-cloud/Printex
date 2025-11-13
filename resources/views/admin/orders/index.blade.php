@extends('layouts.admin')

@section('title', 'Pedidos | Admin')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Pedidos</h1>
            <p class="text-muted mb-0">Controla el estado de cada compra.</p>
        </div>
        <div class="d-flex gap-2">
            <select class="form-select form-select-sm" name="status">
                <option value="">Todos los estados</option>
                @foreach (['Pendiente','Procesando','Enviado','Entregado','Cancelado'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                @endforeach
            </select>
            <button class="btn btn-outline-secondary btn-sm">Filtrar</button>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Método de pago</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->user->name ?? 'Cliente' }}</td>
                                <td>{{ $order->created_at?->format('d/m/Y H:i') }}</td>
                                <td>{{ ucfirst($order->payment_method) }}</td>
                                <td>S/ {{ number_format($order->total, 2) }}</td>
                                <td>
                                    <span class="badge @class([
                                        'text-bg-warning' => $order->status === 'Pendiente',
                                        'text-bg-primary' => $order->status === 'Procesando',
                                        'text-bg-info' => $order->status === 'Enviado',
                                        'text-bg-success' => $order->status === 'Entregado',
                                        'text-bg-danger' => $order->status === 'Cancelado',
                                        'text-bg-secondary' => !in_array($order->status, ['Pendiente','Procesando','Enviado','Entregado','Cancelado']),
                                    ])">
                                        {{ $order->status ?? 'Sin estado' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-secondary">
                                        Ver detalle
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No hay pedidos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($orders, 'links'))
                <div class="mt-3">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

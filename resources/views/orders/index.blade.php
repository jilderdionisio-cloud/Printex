@extends('layouts.app')

@section('title', 'Mis pedidos | Printex')

@section('content')
    <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">
            <div>
                <p class="text-uppercase text-muted small mb-1">Historial</p>
                <h2 class="fw-bold mb-0">Mis pedidos</h2>
            </div>
            <span class="badge text-bg-primary" style="background-color:#1e40af !important;">
                {{ method_exists($orders, 'total') ? $orders->total() : $orders->count() }} pedidos
            </span>
        </div>
    </div>

    <div class="bg-white rounded-4 shadow-sm p-4">
        @if ($orders->isEmpty())
            <div class="text-center py-5">
                <h4 class="fw-bold mb-2">Aún no realizas pedidos</h4>
                <p class="text-muted mb-4">Explora el catálogo y realiza tu primera compra con Printex.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary" style="background-color:#1e40af;">
                    Ver productos
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th>ID</th>
                            <th>Productos</th>
                            <th>Fecha</th>
                            <th>Metodo de pago</th>
                            <th class="text-center">Estado</th>
                            <th class="text-end">Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td class="small">
                                    @forelse ($order->items as $item)
                                        @php
                                            $itemName = $item->name
                                                ?? $item->product->name
                                                ?? $item->course->name
                                                ?? 'Item';
                                        @endphp
                                        <div>{{ $itemName }}</div>
                                    @empty
                                        <div class="text-muted">Sin productos</div>
                                    @endforelse
                                </td>
                                <td>{{ $order->created_at?->format('d/m/Y') }}</td>
                                <td>{{ ucfirst($order->payment_method ?? 'N/D') }}</td>
                                <td class="text-center">
                                    <span class="badge text-dark
                                        @class([
                                            'text-bg-warning' => $order->status === 'Pendiente',
                                            'text-bg-success' => $order->status === 'Entregado',
                                            'text-bg-primary' => $order->status === 'Procesando',
                                            'text-bg-danger' => $order->status === 'Cancelado',
                                            'text-bg-secondary' => !in_array($order->status, ['Pendiente','Procesando','Entregado','Cancelado']),
                                        ])">
                                        {{ $order->status ?? 'Sin estado' }}
                                    </span>
                                </td>
                                <td class="text-end fw-semibold">S/ {{ number_format($order->total, 2) }}</td>
                                <td class="text-end">
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary">
                                        Ver detalle
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if (method_exists($orders, 'links'))
                <div class="mt-3">
                    {{ $orders->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection

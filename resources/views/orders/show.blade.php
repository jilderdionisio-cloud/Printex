@extends('layouts.app')

@section('title', 'Pedido #' . ($order->id ?? 'N/D') . ' | Printex')

@section('content')
    <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
        <div class="d-flex justify-content-between flex-wrap gap-3">
            <div>
                <p class="text-uppercase text-muted small mb-1">Detalle de pedido</p>
                <h2 class="fw-bold mb-0">Pedido #{{ $order->id }}</h2>
                <p class="text-muted mb-0">Realizado el {{ $order->created_at?->format('d/m/Y H:i') }}</p>
            </div>
            <div class="text-end">
                <span class="badge
                    @class([
                        'text-bg-warning' => $order->status === 'Pendiente',
                        'text-bg-success' => $order->status === 'Entregado',
                        'text-bg-primary' => $order->status === 'Procesando',
                        'text-bg-danger' => $order->status === 'Cancelado',
                        'text-bg-secondary' => !in_array($order->status, ['Pendiente','Procesando','Entregado','Cancelado']),
                    ])">
                    {{ $order->status ?? 'Sin estado' }}
                </span>
                <p class="mt-2 fw-semibold mb-0 text-primary" style="color:#1e40af !important;">
                    Total: S/ {{ number_format($order->total, 2) }}
                </p>
            </div>
        </div>
    </div>

    @php
        $status = strtolower($order->status ?? '');
        $eta = ($order->created_at ?? now())->copy()->addDays(3);
        $steps = [
            [
                'title' => 'Pedido confirmado',
                'desc' => 'Pago exitoso, estamos preparando todo.',
                'done' => true,
            ],
            [
                'title' => 'Producto empacado',
                'desc' => 'Tu producto está siendo empacado.',
                'done' => in_array($status, ['procesando', 'enviado', 'entregado']),
            ],
            [
                'title' => 'En camino',
                'desc' => 'Salida a reparto. Entrega estimada antes del ' . $eta->format('d/m'),
                'done' => in_array($status, ['enviado', 'entregado']),
            ],
            [
                'title' => 'Entregado',
                'desc' => 'Pedido entregado al cliente.',
                'done' => $status === 'entregado',
            ],
        ];
    @endphp

    <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
        <h5 class="fw-bold mb-3">Progreso del pedido</h5>
        <div class="position-relative" style="padding-left: 12px;">
            <div class="position-absolute top-0 bottom-0 start-1 bg-light" style="width:2px; left: 6px;"></div>
            @foreach ($steps as $step)
                <div class="d-flex align-items-start mb-3">
                    <div class="me-3 mt-1">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle {{ $step['done'] ? 'bg-success text-white' : 'bg-light text-muted' }}" style="width: 26px; height: 26px;">
                            @if ($step['done'])
                                <i class="bi bi-check-lg"></i>
                            @else
                                <i class="bi bi-circle"></i>
                            @endif
                        </span>
                    </div>
                    <div>
                        <p class="fw-semibold mb-1">{{ $step['title'] }}</p>
                        <p class="text-muted mb-0 small">{{ $step['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                <h5 class="fw-bold mb-3">Información del pedido</h5>
                <ul class="list-unstyled text-muted">
                    <li class="mb-2"><strong>Método de pago:</strong> {{ ucfirst($order->payment_method ?? 'No definido') }}</li>
                    <li class="mb-2"><strong>Estado:</strong> {{ $order->status ?? 'No definido' }}</li>
                    <li class="mb-2"><strong>Cliente:</strong> {{ $order->user->name ?? 'Cliente' }}</li>
                    <li class="mb-2"><strong>Correo:</strong> {{ $order->user->email ?? 'N/D' }}</li>
                    <li class="mb-2"><strong>Teléfono:</strong> {{ $order->user->phone ?? 'N/D' }}</li>
                    <li class="mb-0"><strong>Dirección:</strong> {{ $order->shipping_address ?? 'Pendiente' }}</li>
                </ul>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                <h5 class="fw-bold mb-3">Resumen de pago</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <strong>S/ {{ number_format($order->subtotal ?? $order->total, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Descuento</span>
                    <strong class="text-success">- S/ {{ number_format($order->discount ?? 0, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between mt-3 pt-3 border-top">
                    <span class="fw-semibold">Total pagado</span>
                    <span class="fs-4 fw-bold text-primary" style="color:#1e40af !important;">
                        S/ {{ number_format($order->total, 2) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-4 shadow-sm p-4 mt-4">
        <h5 class="fw-bold mb-3">Productos</h5>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="text-muted small text-uppercase">
                    <tr>
                        <th>Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-end">Precio unitario</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        @php
                            $itemName = $item->product->name ?? $item->course->name ?? $item->name;
                            $itemType = $item->item_type ?? ($item->course_id ? 'course' : 'product');
                        @endphp
                        <tr>
                            <td>
                                {{ $itemName }}
                                <small class="text-muted d-block">{{ $itemType === 'course' ? 'Curso' : 'Producto' }}</small>
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">S/ {{ number_format($item->price, 2) }}</td>
                            <td class="text-end">S/ {{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Volver</a>
        <button class="btn btn-primary" style="background-color:#1e40af;">
            Descargar comprobante
        </button>
    </div>
@endsection

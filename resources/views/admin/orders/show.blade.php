@extends('layouts.admin')

@section('title', 'Pedido #' . ($order->id ?? 'N/D') . ' | Admin')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Pedido #{{ $order->id }}</h1>
            <p class="text-muted mb-0">Realizado el {{ $order->created_at?->format('d/m/Y H:i') }}</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Volver</a>
    </div>

    @php
        $statusLower = strtolower($order->status ?? '');
        $eta = ($order->created_at ?? now())->copy()->addDays(3);
        $steps = [
            [
                'title' => 'Pedido confirmado',
                'desc' => 'Pago exitoso, preparando el pedido.',
                'done' => true,
            ],
            [
                'title' => 'Producto empacado',
                'desc' => 'El producto está siendo empacado.',
                'done' => in_array($statusLower, ['procesando', 'enviado', 'entregado']),
            ],
            [
                'title' => 'En camino',
                'desc' => 'Salida a reparto. Entrega estimada antes del ' . $eta->format('d/m'),
                'done' => in_array($statusLower, ['enviado', 'entregado']),
            ],
            [
                'title' => 'Entregado',
                'desc' => 'Pedido entregado al cliente.',
                'done' => $statusLower === 'entregado',
            ],
        ];
    @endphp

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
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
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Información del pedido</h5>
                    <p><strong>Cliente:</strong> {{ $order->user->name ?? 'Cliente' }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email ?? 'N/D' }}</p>
                    <p><strong>Método de pago:</strong> {{ ucfirst($order->payment_method ?? 'N/D') }}</p>
                    <p><strong>Dirección:</strong> {{ $order->shipping_address ?? 'N/D' }}</p>
                    <p><strong>Teléfono:</strong> {{ $order->user->phone ?? 'N/D' }}</p>
                    <p class="mb-0"><strong>Total:</strong> S/ {{ number_format($order->total, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Actualizar estado</h5>
                    <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Estado</label>
                            <select name="status" class="form-select">
                                @foreach (['Pendiente','Procesando','Enviado','Entregado','Cancelado'] as $status)
                                    <option value="{{ $status }}" @selected($order->status === $status)>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notas internas</label>
                            <textarea name="notes" rows="3" class="form-control">{{ old('notes', $order->notes) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="background-color:#1e40af;">
                            Guardar cambios
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Productos del pedido</h5>
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
    </div>
@endsection

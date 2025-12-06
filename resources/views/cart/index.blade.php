@extends('layouts.app')

@section('title', 'Carrito | Printex')

@section('content')
    @php
        $cartCollection = collect($cartItems ?? []);
    @endphp
    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <p class="text-uppercase text-muted small mb-1">Tu selección</p>
                        <h2 class="fw-bold mb-0">Carrito de compras</h2>
                    </div>
                    <span class="badge text-bg-primary" style="background-color:#1e40af !important;">
                        {{ $cartCollection->count() }} items
                    </span>
                </div>

                @if ($cartCollection->isEmpty())
                    <div class="text-center py-5">
                        <h4 class="fw-bold mb-2">Tu carrito está vacío</h4>
                        <p class="text-muted mb-4">Agrega productos del catálogo y regresa para completar tu compra.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary" style="background-color:#1e40af;">
                            Ir al catálogo
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr class="text-muted small text-uppercase">
                                    <th scope="col">Producto</th>
                                    <th scope="col" class="text-center">Precio</th>
                                    <th scope="col" class="text-center">Cantidad</th>
                                    <th scope="col" class="text-end">Subtotal</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartCollection as $itemKey => $item)
                                    @php
                                        $isCourse = ($item['type'] ?? 'product') === 'course';
                                        $model = $isCourse ? ($item['course'] ?? null) : ($item['product'] ?? null);
                                        $name = $model->name ?? ($isCourse ? 'Curso' : 'Producto');
                                        $price = $model->price ?? 0;
                                        $quantity = $isCourse ? 1 : ($item['quantity'] ?? 1);
                                        $image = null;
                                        if ($isCourse && !empty($model?->image)) {
                                            $image = asset('storage/' . $model->image);
                                        } elseif (! $isCourse && !empty($model?->image_url)) {
                                            $image = $model->image_url;
                                        }
                                        $categoryLabel = $isCourse ? 'Curso' : ($model->category->name ?? $model->category ?? 'General');
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="rounded bg-light" style="width:64px;height:64px;">
                                                    @if (!empty($image))
                                                        <img src="{{ $image }}" alt="{{ $name }}"
                                                             class="rounded object-fit-cover" style="width:64px;height:64px;">
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 class="mb-1">{{ $name }}</h6>
                                                    <small class="text-muted">
                                                        Categoría: {{ $categoryLabel }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-semibold">S/ {{ number_format($price, 2) }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if ($isCourse)
                                                <span class="fw-semibold">1</span>
                                            @else
                                                <form method="POST" action="{{ route('cart.update', $itemKey) }}" class="d-inline-flex align-items-center gap-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="number" name="quantity" min="1" max="{{ $model->stock ?? 99 }}" step="1"
                                                           value="{{ $quantity }}" class="form-control form-control-sm text-center"
                                                           style="width:80px;">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">Actualizar</button>
                                                </form>
                                            @endif
                                        </td>
                                        <td class="text-end fw-semibold">
                                            S/ {{ number_format($price * $quantity, 2) }}
                                        </td>
                                        <td class="text-end">
                                            <form method="POST" action="{{ route('cart.remove', $itemKey) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-link text-danger">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <h4 class="fw-bold mb-4">Resumen</h4>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <strong>S/ {{ number_format($summary['subtotal'] ?? 0, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Descuentos</span>
                    <strong class="text-success">- S/ {{ number_format($summary['discount'] ?? 0, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between py-3 border-top">
                    <span class="fw-semibold">Total</span>
                    <span class="fs-4 fw-bold text-primary" style="color:#1e40af !important;">
                        S/ {{ number_format($summary['total'] ?? $summary['subtotal'] ?? 0, 2) }}
                    </span>
                </div>

                @if ($cartCollection->isEmpty())
                    <button class="btn btn-primary w-100" style="background-color:#1e40af;" disabled>
                        Añade un producto para continuar
                    </button>
                @else
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100" style="background-color:#1e40af;">
                        Proceder al pago
                    </a>
                @endif

                <div class="mt-3 text-center text-muted small">
                    * Tus productos se reservan por 15 minutos.
                </div>
            </div>

            <div class="bg-light rounded-4 p-4 mt-3">
                <h6 class="text-uppercase text-muted small">Métodos aceptados</h6>
                <div class="d-flex gap-3">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="Visa" height="24">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png" alt="Mastercard" height="24">
                    <span class="badge text-bg-warning text-dark" style="background-color:#f59e0b !important;">Yape</span>
                    <span class="badge text-bg-warning text-dark" style="background-color:#f59e0b !important;">Plin</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input[name="quantity"]').forEach(input => {
        const minVal = parseInt(input.getAttribute('min')) || 1;
        const maxAttr = parseInt(input.getAttribute('max'));
        const hasMax = !Number.isNaN(maxAttr);
        const clamp = () => {
            let val = parseInt(input.value, 10);
            if (Number.isNaN(val) || val < minVal) val = minVal;
            if (hasMax && val > maxAttr) val = maxAttr;
            input.value = val;
        };
        input.addEventListener('input', clamp);
        input.addEventListener('change', clamp);
    });
});
</script>
@endpush

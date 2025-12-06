@extends('layouts.app')

@section('title', 'Checkout | Printex')

@section('content')
    <form method="POST" action="{{ route('checkout.process') }}">
        @csrf
        <div class="row g-4">
            <div class="col-12 col-lg-7">
                <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <p class="text-uppercase text-muted small mb-1">Paso final</p>
                            <h2 class="fw-bold mb-0">Resumen del pedido</h2>
                        </div>
                        <a href="{{ route('cart.index') }}" class="btn btn-sm btn-outline-secondary">
                            Editar carrito
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="text-muted small text-uppercase">
                            <tr>
                                <th>Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Precio</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($cartItems ?? [] as $item)
                                @php
                                    $isCourse = ($item['type'] ?? 'product') === 'course';
                                    $model = $isCourse ? ($item['course'] ?? null) : ($item['product'] ?? null);
                                    $name = $model->name ?? ($isCourse ? 'Curso' : 'Producto');
                                    $price = $model->price ?? 0;
                                    $quantity = $isCourse ? 1 : ($item['quantity'] ?? 1);
                                @endphp
                                <tr>
                                    <td>{{ $name }}</td>
                                    <td class="text-center">{{ $quantity }}</td>
                                    <td class="text-end">S/ {{ number_format($price * $quantity, 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="2" class="text-end fw-semibold">Subtotal</td>
                                <td class="text-end">S/ {{ number_format($summary['subtotal'] ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-end fw-semibold">Descuentos</td>
                                <td class="text-end text-success">- S/ {{ number_format($summary['discount'] ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-end fs-5 fw-bold">Total</td>
                                <td class="text-end fs-5 fw-bold text-primary" style="color:#1e40af !important;">
                                    S/ {{ number_format($summary['total'] ?? $summary['subtotal'] ?? 0, 2) }}
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-4 shadow-sm p-4">
                    <h4 class="fw-bold mb-3">Información de envío</h4>
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" class="form-control" name="shipping_name" value="{{ old('shipping_name', $user->name ?? '') }}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Teléfono</label>
                            <input type="tel"
                                   class="form-control"
                                   name="shipping_phone"
                                   minlength="9"
                                   maxlength="9"
                                   pattern="\d{9}"
                                   inputmode="numeric"
                                   value="{{ old('shipping_phone', $user->phone ?? '') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Dirección completa *</label>
                            <textarea name="shipping_address" rows="2" class="form-control @error('shipping_address') is-invalid @enderror" required>{{ old('shipping_address', $user->address ?? '') }}</textarea>
                            @error('shipping_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Ciudad</label>
                            <input type="text" class="form-control" name="shipping_city" value="{{ old('shipping_city') }}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Referencia</label>
                            <input type="text" class="form-control" name="shipping_reference" value="{{ old('shipping_reference') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-5">
                <div class="bg-white rounded-4 shadow-sm p-4">
                    <h4 class="fw-bold mb-3">Método de pago</h4>

                    <div class="accordion" id="paymentAccordion">
                        @foreach ([
                            ['key' => 'Yape', 'label' => 'Yape', 'description' => 'Paga con tu número de Yape.'],
                            ['key' => 'Plin', 'label' => 'Plin', 'description' => 'Paga con tu número de Plin.'],
                            ['key' => 'Visa', 'label' => 'Visa', 'description' => 'Completa los datos de tu tarjeta Visa.'],
                            ['key' => 'Mastercard', 'label' => 'Mastercard', 'description' => 'Completa los datos de tu tarjeta Mastercard.'],
                            ['key' => 'Efectivo', 'label' => 'Pago en efectivo', 'description' => 'Paga en tienda o contra entrega en 48 horas.'],
                        ] as $index => $method)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $method['key'] }}">
                                    <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $method['key'] }}"
                                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                            aria-controls="collapse{{ $method['key'] }}">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                   value="{{ $method['key'] }}" id="radio{{ $method['key'] }}"
                                                   data-payment-radio
                                                   {{ old('payment_method', $index === 0 ? $method['key'] : null) === $method['key'] ? 'checked' : '' }}>
                                            <label class="form-check-label ms-2" for="radio{{ $method['key'] }}">
                                                {{ $method['label'] }}
                                            </label>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse{{ $method['key'] }}"
                                     class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                     aria-labelledby="heading{{ $method['key'] }}"
                                     data-bs-parent="#paymentAccordion">
                                    <div class="accordion-body">
                                        <p class="text-muted small mb-0">{{ $method['description'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('payment_method')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror

                    <div class="mt-3" id="paymentExtra">
                        <label class="form-label" id="paymentExtraLabel">Referencia del pago</label>
                        <input type="text" name="payment_reference" id="paymentExtraInput"
                               class="form-control"
                               inputmode="numeric"
                               placeholder="Completa según el método seleccionado">
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-lg mt-4" style="background-color:#1e40af;">
                        Confirmar pedido
                    </button>
                    <p class="text-muted small text-center mt-2">
                        Al confirmar, aceptas nuestros términos y condiciones.
                    </p>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const radios = document.querySelectorAll('[data-payment-radio]');
    const label = document.getElementById('paymentExtraLabel');
    const input = document.getElementById('paymentExtraInput');

    function updateField(method) {
        input.required = false;
        input.value = '';
        input.removeAttribute('minlength');
        input.removeAttribute('maxlength');
        input.removeAttribute('pattern');
        input.setAttribute('inputmode', 'numeric');
        if (method === 'Yape' || method === 'Plin') {
            label.textContent = `Número de ${method}`;
            input.placeholder = 'Número de celular asociado';
            input.required = true;
            input.setAttribute('minlength', '9');
            input.setAttribute('maxlength', '9');
            input.setAttribute('pattern', '^[0-9]{9}$');
        } else if (method === 'Visa' || method === 'Mastercard') {
            label.textContent = 'Número de tarjeta';
            input.placeholder = '**** **** **** 1234';
            input.required = true;
            input.setAttribute('minlength', '16');
            input.setAttribute('maxlength', '16');
            input.setAttribute('pattern', '^[0-9]{16}$');
        } else {
            label.textContent = 'Referencia del pago';
            input.placeholder = 'Referencia o código (opcional)';
            input.setAttribute('inputmode', 'text');
        }
    }

    radios.forEach(radio => {
        radio.addEventListener('change', (e) => {
            updateField(e.target.value);
        });
        if (radio.checked) {
            updateField(radio.value);
        }
    });
});
</script>
@endpush

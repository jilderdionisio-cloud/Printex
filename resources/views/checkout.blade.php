@extends('layouts.app')

@section('title', 'Checkout | Printex')

@section('content')
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
                                <tr>
                                    <td>{{ $item['product']->name }}</td>
                                    <td class="text-center">{{ $item['quantity'] }}</td>
                                    <td class="text-end">S/ {{ number_format($item['product']->price * $item['quantity'], 2) }}</td>
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
                <form class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label">Nombre completo</label>
                        <input type="text" class="form-control" name="shipping_name" value="{{ $user->name ?? '' }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" name="shipping_phone" value="{{ $user->phone ?? '' }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Dirección</label>
                        <input type="text" class="form-control" name="shipping_address">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Ciudad</label>
                        <input type="text" class="form-control" name="shipping_city">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Referencia</label>
                        <input type="text" class="form-control" name="shipping_reference">
                    </div>
                </form>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <h4 class="fw-bold mb-3">Método de pago</h4>

                <div class="accordion" id="paymentAccordion">
                    {{-- Yape --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingYape">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseYape"
                                    aria-expanded="true" aria-controls="collapseYape">
                                Yape
                            </button>
                        </h2>
                        <div id="collapseYape" class="accordion-collapse collapse show" aria-labelledby="headingYape"
                             data-bs-parent="#paymentAccordion">
                            <div class="accordion-body">
                                <p class="text-muted small">Escanea el QR y coloca la referencia del pago.</p>
                                <div class="ratio ratio-1x1 bg-light rounded-3 mb-3 d-flex justify-content-center align-items-center text-muted">
                                    QR Yape
                                </div>
                                <label class="form-label">Referencia de pago</label>
                                <input type="text" class="form-control" name="yape_reference">
                            </div>
                        </div>
                    </div>

                    {{-- Plin --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingPlin">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePlin"
                                    aria-expanded="false" aria-controls="collapsePlin">
                                Plin
                            </button>
                        </h2>
                        <div id="collapsePlin" class="accordion-collapse collapse" aria-labelledby="headingPlin"
                             data-bs-parent="#paymentAccordion">
                            <div class="accordion-body">
                                <p class="text-muted small">Escanea el código Plin y completa la referencia.</p>
                                <div class="ratio ratio-1x1 bg-light rounded-3 mb-3 d-flex justify-content-center align-items-center text-muted">
                                    QR Plin
                                </div>
                                <label class="form-label">Referencia de pago</label>
                                <input type="text" class="form-control" name="plin_reference">
                            </div>
                        </div>
                    </div>

                    {{-- Visa --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingVisa">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseVisa"
                                    aria-expanded="false" aria-controls="collapseVisa">
                                Visa
                            </button>
                        </h2>
                        <div id="collapseVisa" class="accordion-collapse collapse" aria-labelledby="headingVisa"
                             data-bs-parent="#paymentAccordion">
                            <div class="accordion-body">
                                <form class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Número de tarjeta</label>
                                        <input type="text" class="form-control" placeholder="XXXX XXXX XXXX XXXX">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Expiración</label>
                                        <input type="text" class="form-control" placeholder="MM/AA">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">CVV</label>
                                        <input type="text" class="form-control" placeholder="123">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Titular</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Mastercard --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingMastercard">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMastercard"
                                    aria-expanded="false" aria-controls="collapseMastercard">
                                Mastercard
                            </button>
                        </h2>
                        <div id="collapseMastercard" class="accordion-collapse collapse" aria-labelledby="headingMastercard"
                             data-bs-parent="#paymentAccordion">
                            <div class="accordion-body">
                                <form class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Número de tarjeta</label>
                                        <input type="text" class="form-control" placeholder="XXXX XXXX XXXX XXXX">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Expiración</label>
                                        <input type="text" class="form-control" placeholder="MM/AA">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">CVV</label>
                                        <input type="text" class="form-control" placeholder="123">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Titular</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Efectivo --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingCash">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCash"
                                    aria-expanded="false" aria-controls="collapseCash">
                                Pago en efectivo
                            </button>
                        </h2>
                        <div id="collapseCash" class="accordion-collapse collapse" aria-labelledby="headingCash"
                             data-bs-parent="#paymentAccordion">
                            <div class="accordion-body">
                                <p class="text-muted mb-3">
                                    Realiza el pago en nuestras tiendas Printex o contra entrega. Te enviaremos la dirección
                                    y horario una vez confirmes el pedido.
                                </p>
                                <ul class="text-muted small mb-0">
                                    <li>Tiempo máximo para pago: 48 horas.</li>
                                    <li>Presenta tu ID de pedido al momento del pago.</li>
                                    <li>Los pedidos no pagados se cancelan automáticamente.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('checkout.process') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 btn-lg" style="background-color:#1e40af;"
                            @if (empty($cartItems)) disabled @endif>
                        Confirmar pedido
                    </button>
                    <p class="text-muted small text-center mt-2">
                        Al confirmar, aceptas nuestros términos y condiciones.
                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection

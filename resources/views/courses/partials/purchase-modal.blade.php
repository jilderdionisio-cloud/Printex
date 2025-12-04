@php
    $modalId = $modalId ?? 'purchase-course-' . $course->id;
@endphp

<button type="button"
        class="{{ $buttonClass ?? 'btn btn-primary w-100' }}"
        data-bs-toggle="modal"
        data-bs-target="#{{ $modalId }}">
    {{ $buttonLabel ?? 'Adquirir video' }}
</button>

@push('modals')
    <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true"
         data-bs-backdrop="static" data-bs-keyboard="false" data-modal-key="{{ $modalId }}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0 rounded-4">
                <form method="POST" action="{{ route('courses.purchase', $course->id) }}">
                    @csrf
                    <div class="modal-header border-0 pb-0">
                        <div>
                            <span class="badge text-bg-primary mb-1" style="background-color:#1e40af !important;">Compra rápida</span>
                            <h5 class="modal-title fw-bold">Adquirir video</h5>
                            <p class="text-muted small mb-0">Completa el pago para habilitar tu acceso al curso en "Mis cursos".</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <div class="p-3 bg-light rounded-3 mb-3 d-flex justify-content-between align-items-center">
                            <div>
                                <p class="fw-semibold mb-0">{{ $course->name }}</p>
                                <small class="text-muted">Acceso inmediato</small>
                            </div>
                            <div class="text-end">
                                <p class="fw-bold text-primary mb-0">S/ {{ number_format($course->price, 2) }}</p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Método de pago</label>
                            <select name="payment_method" class="form-select" required data-payment-method>
                                <option value="">Selecciona</option>
                                <option value="tarjeta">Tarjeta (Visa/Mastercard)</option>
                                <option value="yape-plin">Yape / Plin</option>
                                <option value="transferencia">Transferencia</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" data-payment-label>Referencia del pago</label>
                            <input type="text"
                                   name="payment_reference"
                                   class="form-control"
                                   data-payment-input
                                   placeholder="Código de operación o últimos 4 de la tarjeta">
                        </div>

                        <div class="alert alert-info d-flex align-items-center gap-2 py-2 rounded-3">
                            <i class="bi bi-info-circle-fill"></i>
                            <span class="small mb-0">No se usa el carrito. Este pago es solo para el curso seleccionado.</span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Pagar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush

@once
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-payment-method]').forEach(select => {
                const form = select.closest('form');
                const label = form.querySelector('[data-payment-label]');
                const input = form.querySelector('[data-payment-input]');

                const update = (val) => {
                    if (val === 'yape-plin') {
                        label.textContent = 'Número de Yape/Plin';
                        input.placeholder = 'Número de celular asociado';
                    } else if (val === 'tarjeta') {
                        label.textContent = 'Número de tarjeta';
                        input.placeholder = '**** **** **** 1234';
                    } else if (val === 'transferencia') {
                        label.textContent = 'Referencia de transferencia';
                        input.placeholder = 'Código o número de operación';
                    } else {
                        label.textContent = 'Referencia del pago';
                        input.placeholder = 'Código de operación o últimos 4 de la tarjeta';
                    }
                };

                update(select.value);
                select.addEventListener('change', (e) => update(e.target.value));
            });
        });
    </script>
@endpush
@endonce

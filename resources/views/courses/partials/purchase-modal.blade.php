@php
    $modalId = $modalId ?? 'purchase-course-' . $course->id;
@endphp

<button type="button"
        class="{{ $buttonClass ?? 'btn btn-primary w-100' }}"
        data-bs-toggle="modal"
        data-bs-target="#{{ $modalId }}">
    {{ $buttonLabel ?? 'Adquirir video' }}
</button>

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('courses.purchase', $course->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Adquirir video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small mb-3">
                        Completa el pago para habilitar tu acceso al curso en "Mis cursos".
                    </p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold">{{ $course->name }}</span>
                        <span class="fw-bold text-primary">S/ {{ number_format($course->price, 2) }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Método de pago</label>
                        <select name="payment_method" class="form-select" required data-payment-method>
                            <option value="">Selecciona</option>
                            <option value="tarjeta">Tarjeta</option>
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
                    <div class="alert alert-info d-flex align-items-center gap-2 py-2">
                        <span class="fw-bold">Importante:</span>
                        <span class="small mb-0">No se usa el carrito. Este pago es solo para el curso seleccionado.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        Pagar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-payment-method]').forEach(select => {
        select.addEventListener('change', (e) => {
            const form = e.target.closest('form');
            const label = form.querySelector('[data-payment-label]');
            const input = form.querySelector('[data-payment-input]');
            const val = e.target.value;
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
                input.placeholder = '';
            }
        });
    });
});
</script>
@endpush

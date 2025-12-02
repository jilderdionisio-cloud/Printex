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
                        Para descargar el video debes completar el pago. Recibirás acceso inmediato tras confirmar.
                    </p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold">{{ $course->name }}</span>
                        <span class="fw-bold text-primary">S/ {{ number_format($course->price, 2) }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Método de pago</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="">Selecciona</option>
                            <option value="tarjeta">Tarjeta</option>
                            <option value="yape-plin">Yape / Plin</option>
                            <option value="transferencia">Transferencia</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Referencia del pago</label>
                        <input type="text"
                               name="payment_reference"
                               class="form-control"
                               placeholder="Código de operación o últimos 4 de la tarjeta">
                    </div>
                    <div class="alert alert-info d-flex align-items-center gap-2 py-2">
                        <span class="fw-bold">Importante:</span>
                        <span class="small mb-0">No se usa el carrito. Este pago es solo para el video seleccionado.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        Pagar y descargar video
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

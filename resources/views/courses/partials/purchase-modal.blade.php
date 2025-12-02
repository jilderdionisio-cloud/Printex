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
    <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" data-modal-key="{{ $modalId }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-4">
            <form method="POST" action="{{ route('courses.purchase', $course->id) }}">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <div>
                        <span class="badge text-bg-primary mb-1" style="background-color:#1e40af !important;">Compra rapida</span>
                        <h5 class="modal-title fw-bold">Adquirir video</h5>
                        <p class="text-muted small mb-0">Completa el pago y accede de inmediato a tu contenido.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body pt-3">
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
                        <label class="form-label fw-semibold">Metodo de pago</label>
                        <select name="payment_method" class="form-select js-payment-method" required data-modal-key="{{ $modalId }}">
                            <option value="">Selecciona</option>
                            <option value="tarjeta">Tarjeta (Visa/Mastercard)</option>
                            <option value="yape-plin">Yape / Plin</option>
                            <option value="transferencia">Transferencia</option>
                        </select>
                    </div>

                    <div class="mb-3 payment-card-fields" data-modal-key="{{ $modalId }}" style="display:none;">
                        <label class="form-label fw-semibold">Datos de tarjeta</label>
                        <div class="row g-2">
                            <div class="col-12">
                                <input type="text" name="card_number" class="form-control" placeholder="Numero de tarjeta" maxlength="19">
                            </div>
                            <div class="col-6">
                                <input type="text" name="card_exp" class="form-control" placeholder="MM/AA" maxlength="5">
                            </div>
                            <div class="col-6">
                                <input type="text" name="card_cvv" class="form-control" placeholder="CVV" maxlength="4">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 payment-yape-fields" data-modal-key="{{ $modalId }}" style="display:none;">
                        <label class="form-label fw-semibold">Referencia Yape / Plin</label>
                        <input type="text" name="payment_reference" class="form-control" placeholder="Codigo de operacion o numero de celular">
                    </div>

                    <div class="mb-3 payment-transfer-fields" data-modal-key="{{ $modalId }}" style="display:none;">
                        <label class="form-label fw-semibold">Referencia Transferencia</label>
                        <input type="text" name="payment_reference_transfer" class="form-control" placeholder="Numero de operacion o voucher">
                    </div>

                    <div class="alert alert-info d-flex align-items-center gap-2 py-2 rounded-3">
                        <i class="bi bi-info-circle-fill"></i>
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
@endpush

@once
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function toggleFieldsFor(select) {
                if (!select) return;
                const key = select.getAttribute('data-modal-key');
                const cardFields = document.querySelector('.payment-card-fields[data-modal-key="' + key + '"]');
                const yapeFields = document.querySelector('.payment-yape-fields[data-modal-key="' + key + '"]');
                const transferFields = document.querySelector('.payment-transfer-fields[data-modal-key="' + key + '"]');
                const method = select.value;
                if (cardFields) cardFields.style.display = method === 'tarjeta' ? 'block' : 'none';
                if (yapeFields) yapeFields.style.display = method === 'yape-plin' ? 'block' : 'none';
                if (transferFields) transferFields.style.display = method === 'transferencia' ? 'block' : 'none';
            }

            document.querySelectorAll('.js-payment-method').forEach(function (select) {
                toggleFieldsFor(select);
                select.addEventListener('change', function () {
                    toggleFieldsFor(select);
                });
            });
        });
    </script>
@endpush
@endonce

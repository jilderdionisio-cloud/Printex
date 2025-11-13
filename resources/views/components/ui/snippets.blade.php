{{-- Modal de confirmación --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de eliminar este registro? Esta acción no se puede deshacer.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger">Eliminar</button>
            </div>
        </div>
    </div>
</div>

{{-- Toasts --}}
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:1100;">
    <div id="toastSuccess" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                🎉 Pedido realizado con éxito.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    <div id="toastEnrollment" class="toast align-items-center text-bg-primary border-0 mt-2" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                ✅ Inscripción registrada correctamente.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

{{-- Empty state --}}
<div class="text-center py-5 text-muted">
    <div class="mb-3">
        <i class="bi bi-box-seam display-6 text-primary" style="color:#1e40af !important;"></i>
    </div>
    <h4 class="fw-bold">No hay elementos disponibles</h4>
    <p class="mb-3">Cuando agregues productos o cursos, aparecerán en esta sección.</p>
    <a href="#" class="btn btn-primary" style="background-color:#1e40af;">Agregar elemento</a>
</div>

{{-- Spinner --}}
<div class="d-flex justify-content-center my-5">
    <div class="spinner-border text-primary" role="status" style="color:#1e40af !important;">
        <span class="visually-hidden">Cargando...</span>
    </div>
</div>

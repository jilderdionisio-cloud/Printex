@if (session('status'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
        <div id="statusToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body fw-semibold">
                    {{ session('status') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var toastEl = document.getElementById('statusToast');
                if (!toastEl || !window.bootstrap) return;

                var toast = new bootstrap.Toast(toastEl, {delay: 3800, autohide: true});
                toast.show();
            });
        </script>
    @endpush
@endif

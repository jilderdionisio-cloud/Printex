<div x-data="{ open: false }" class="chatbot-wrapper">
    <button type="button"
            class="btn btn-primary rounded-circle shadow-lg position-fixed"
            style="bottom: 24px; right: 24px; width: 64px; height: 64px; background-color:#1e40af;"
            aria-label="Abrir PrintBot"
            @click="open = !open">
        <i class="bi bi-robot fs-4"></i>
    </button>

    <div class="position-fixed" style="bottom: 100px; right: 24px; width: 320px;" x-cloak x-show="open"
         x-transition.origin.bottom.right>
        <div class="card shadow-lg border-0">
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color:#1e40af; color:#fff;">
                <div>
                    <h6 class="mb-0 fw-bold">PrintBot</h6>
                    <small>Asistente virtual</small>
                </div>
                <button type="button" class="btn btn-sm btn-light" @click="open = false">&times;</button>
            </div>
            <div class="card-body p-0 d-flex flex-column" style="height: 360px;">
                <div class="flex-grow-1 overflow-auto p-3" style="background-color:#f9fafb;" data-chatbot-messages>
                    <div class="text-center text-muted small">Cargando conversación...</div>
                </div>
                <form class="border-top p-2 d-flex gap-2" data-chatbot-form>
                    <input type="text" class="form-control" placeholder="Escribe tu mensaje..." data-chatbot-input>
                    <button class="btn btn-primary" type="submit">
                        Enviar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

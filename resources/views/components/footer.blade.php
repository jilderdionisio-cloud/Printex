<footer class="mt-auto">
    {{-- CTA superior --}}
    <div style="background:#0f2b7b;" class="text-center text-white py-5">
        <div class="container">
            <h4 class="fw-bold mb-2">¿Listo para Empezar?</h4>
            <p class="mb-4">Únete a cientos de emprendedores que confían en PRINTEX para su negocio de estampado</p>
            <a href="{{ route('about') }}" class="btn btn-warning fw-semibold px-4">Contáctanos Ahora</a>
        </div>
    </div>

    {{-- Barra social --}}
    <div style="background:#f59e0b;" class="text-white py-2">
        <div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
            <span class="fw-semibold">Síguenos en nuestras redes sociales y mantente actualizado</span>
            <div class="d-flex gap-3">
                <a class="text-white" href="https://facebook.com" target="_blank" rel="noopener">
                    <i class="bi bi-facebook fs-5"></i>
                </a>
                <a class="text-white" href="https://instagram.com" target="_blank" rel="noopener">
                    <i class="bi bi-instagram fs-5"></i>
                </a>
                <a class="text-white" href="https://twitter.com" target="_blank" rel="noopener">
                    <i class="bi bi-twitter fs-5"></i>
                </a>
                <a class="text-white" href="https://youtube.com" target="_blank" rel="noopener">
                    <i class="bi bi-youtube fs-5"></i>
                </a>
                <a class="text-white" href="https://wa.me/51999999999" target="_blank" rel="noopener">
                    <i class="bi bi-whatsapp fs-5"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Información --}}
    <div style="background:#0b1224;" class="text-white py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <h6 class="text-uppercase fw-semibold mb-3">Printex</h6>
                    <p class="mb-0">Tu aliado en estampado profesional. Ofrecemos los mejores insumos, maquinaria y reproducción para tu negocio de serigrafía y sublimación.</p>
                </div>
                <div class="col-12 col-md-4">
                    <h6 class="text-uppercase fw-semibold mb-3">Contactos</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-1"><i class="bi bi-telephone-fill me-2"></i>+51 999 888 777</li>
                        <li class="mb-1"><i class="bi bi-envelope-fill me-2"></i>ventas@printex.com</li>
                        <li class="mb-1"><i class="bi bi-envelope-fill me-2"></i>soporte@printex.com</li>
                        <li class="mb-0"><i class="bi bi-geo-alt-fill me-2"></i>Av. Lima 123, Lima - Perú</li>
                    </ul>
                </div>
                <div class="col-12 col-md-4">
                    <h6 class="text-uppercase fw-semibold mb-3">Horario de Atención</h6>
                    <p class="mb-1">Lunes a Viernes: 9:00 AM - 6:00 PM</p>
                    <p class="mb-1">Sábados: 9:00 AM - 1:00 PM</p>
                    <p class="mb-0">Domingos: Cerrado</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Copyright --}}
    <div style="background:#0b1224; border-top:1px solid rgba(255,255,255,0.08);" class="text-center text-white-50 py-3">
        <small>© PRINTEX {{ now()->year }}. Todos los derechos reservados.</small>
    </div>
</footer>

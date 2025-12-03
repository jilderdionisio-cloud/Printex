<footer class="mt-auto">
    {{-- CTA superior --}}
    <div style="background:linear-gradient(135deg, rgba(30,64,175,0.92), rgba(12,19,42,0.95));" class="text-center text-white py-5 border-top border-bottom border-light-subtle">
        <div class="container">
            <div class="badge bg-warning text-dark mb-3 px-3 py-2 fw-semibold">Estudio creativo de estampado</div>
            <h4 class="fw-bold mb-2">¿Listo para Empezar?</h4>
            <p class="mb-4">Únete a cientos de emprendedores que confían en PRINTEX para su negocio de diseño y sublimación.</p>
            <a href="{{ route('about') }}" class="btn btn-printex fw-semibold px-4">Contáctanos ahora</a>
        </div>
    </div>

    {{-- Barra social --}}
    <div style="background:linear-gradient(135deg, #f97316, #f59e0b);" class="text-white py-2">
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
    <div style="background:#0b1224;" class="text-white py-5 border-top border-light-subtle">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <h6 class="text-uppercase fw-semibold mb-3">Printex</h6>
                    <p class="mb-0 text-white-50">Tu aliado creativo en estampado profesional. Insumos, maquinaria y cursos para marcas que buscan destacar.</p>
                </div>
                <div class="col-12 col-md-4">
                    <h6 class="text-uppercase fw-semibold mb-3">Contactos</h6>
                    <ul class="list-unstyled mb-0 text-white-50">
                        <li class="mb-1"><i class="bi bi-telephone-fill me-2"></i>+51 999 888 777</li>
                        <li class="mb-1"><i class="bi bi-envelope-fill me-2"></i>ventas@printex.com</li>
                        <li class="mb-1"><i class="bi bi-envelope-fill me-2"></i>soporte@printex.com</li>
                        <li class="mb-0"><i class="bi bi-geo-alt-fill me-2"></i>Av. Lima 123, Lima - Perú</li>
                    </ul>
                </div>
                <div class="col-12 col-md-4">
                    <h6 class="text-uppercase fw-semibold mb-3">Horario de Atención</h6>
                    <p class="mb-1 text-white-50">Lunes a Viernes: 9:00 AM - 6:00 PM</p>
                    <p class="mb-1 text-white-50">Sábados: 9:00 AM - 1:00 PM</p>
                    <p class="mb-0 text-white-50">Domingos: Cerrado</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Copyright --}}
    <div style="background:#0b1224; border-top:1px solid rgba(255,255,255,0.08);" class="text-center text-white-50 py-3">
        <small>© PRINTEX {{ now()->year }}. Todos los derechos reservados.</small>
    </div>
</footer>

@extends('layouts.guest')

@section('title', 'Sobre PRINTEX')

@section('content')
    <div class="bg-white rounded-4 shadow-sm p-5 mb-5">
        <p class="text-uppercase text-muted small mb-2">Conócenos</p>
        <h1 class="fw-bold mb-3">Sobre PRINTEX</h1>
        <p class="lead text-muted mb-0">
            PRINTEX es una plataforma peruana especializada en suministrar insumos, maquinaria y formación
            profesional para el mundo de la sublimación, serigrafía y estampado textil. Nacimos para acompañar a
            emprendedores, talleres y empresas en cada etapa de su crecimiento, brindando soluciones integrales que
            combinan tecnología, capacitación y soporte cercano.
        </p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-12 col-lg-6">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                <h3 class="fw-bold mb-3 text-primary" style="color:#1e40af !important;">Misión</h3>
                <p class="text-muted">
                    Democratizar el acceso a insumos, equipos y conocimiento de estampado, ofreciendo una experiencia
                    de compra confiable, asesoría personalizada y programas formativos que impulsen negocios creativos
                    en toda Latinoamérica.
                </p>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                <h3 class="fw-bold mb-3 text-primary" style="color:#1e40af !important;">Visión</h3>
                <p class="text-muted">
                    Ser la comunidad de referencia para el sector de impresión y personalización, integrando tecnología,
                    educación y servicios que permitan a cada emprendedor escalar su proyecto con impacto sostenible.
                </p>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-12 col-lg-4">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100 text-center">
                <span class="badge rounded-pill text-bg-warning mb-3" style="background-color:#f59e0b !important;">Innovación</span>
                <h5 class="fw-bold mb-2">Tecnología accesible</h5>
                <p class="text-muted mb-0">
                    Curamos equipos y herramientas modernas para que puedas producir con calidad profesional desde el primer día.
                </p>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100 text-center">
                <span class="badge rounded-pill text-bg-warning mb-3" style="background-color:#f59e0b !important;">Confianza</span>
                <h5 class="fw-bold mb-2">Acompañamiento experto</h5>
                <p class="text-muted mb-0">
                    Nuestro equipo comparte buenas prácticas, soporte técnico y PrintBot para resolver dudas en minutos.
                </p>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100 text-center">
                <span class="badge rounded-pill text-bg-warning mb-3" style="background-color:#f59e0b !important;">Comunidad</span>
                <h5 class="fw-bold mb-2">Formación constante</h5>
                <p class="text-muted mb-0">
                    Conecta con otros emprendedores, participa en cursos y recibe certificaciones que impulsen tu marca.
                </p>
            </div>
        </div>
    </div>

    <div class="row g-4 align-items-center mb-5">
        <div class="col-12 col-lg-6">
            <img src="https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=1000&q=80"
                 class="rounded-4 shadow-sm w-100 object-fit-cover" alt="Equipo Printex">
        </div>
        <div class="col-12 col-lg-6">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                <h3 class="fw-bold mb-3">Nuestros valores</h3>
                <ul class="list-unstyled text-muted mb-0">
                    <li class="mb-3">
                        <strong class="text-primary" style="color:#1e40af !important;">Empatía:</strong>
                        Entendemos los retos del emprendedor y ajustamos soluciones reales a su contexto.
                    </li>
                    <li class="mb-3">
                        <strong class="text-primary" style="color:#1e40af !important;">Calidad:</strong>
                        Seleccionamos proveedores confiables y probamos cada equipo antes de ofrecerlo.
                    </li>
                    <li class="mb-3">
                        <strong class="text-primary" style="color:#1e40af !important;">Transparencia:</strong>
                        Comunicación clara sobre precios, tiempos de entrega y soporte posventa.
                    </li>
                    <li>
                        <strong class="text-primary" style="color:#1e40af !important;">Aprendizaje:</strong>
                        Actualizamos contenidos constantemente para mantenerte a la vanguardia.
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

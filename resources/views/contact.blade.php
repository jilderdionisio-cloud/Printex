@extends('layouts.guest')

@section('title', 'Contacto | Printex')

@section('content')
    <section class="py-5" style="background: radial-gradient(circle at 20% 20%, #f7f3ff 0, #f7f3ff 25%, transparent 26%), radial-gradient(circle at 80% 0, #e6f5ff 0, #e6f5ff 25%, transparent 26%);">
        <div class="container">
            <div class="row g-4 align-items-stretch">
                <div class="col-lg-6">
                    <div class="bg-white rounded-4 shadow-sm p-4 p-lg-5 h-100">
                        <span class="badge bg-warning text-dark mb-3 text-uppercase">Soporte directo</span>
                        <h1 class="fw-bold mb-3">Contáctanos</h1>
                        <p class="text-muted mb-4 fs-6">Escríbenos para coordinar pedidos, cursos o soporte. Respondemos rápido y con trato personalizado.</p>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle bg-warning bg-opacity-25 text-warning d-inline-flex align-items-center justify-content-center me-3" style="width: 42px; height: 42px;">📍</div>
                                <div>
                                    <div class="fw-semibold">Dirección</div>
                                    <div class="text-muted">Av. Industrial 123, Lima</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center me-3" style="width: 42px; height: 42px;">📞</div>
                                <div>
                                    <div class="fw-semibold">Teléfono</div>
                                    <div class="text-muted">+51 999 999 999</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center me-3" style="width: 42px; height: 42px;">✉️</div>
                                <div>
                                    <div class="fw-semibold">Email</div>
                                    <div class="text-muted">soporte@printex.com</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bg-primary text-white rounded-4 h-100 position-relative overflow-hidden" style="min-height: 340px;">
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: radial-gradient(circle at 30% 20%, rgba(255,255,255,0.15), transparent 35%), radial-gradient(circle at 80% 0%, rgba(255,255,255,0.12), transparent 30%);"></div>
                        <div class="position-relative p-4 p-lg-5 d-flex flex-column justify-content-between h-100">
                            <div class="d-flex flex-column gap-3">
                                <div>
                                    <p class="badge bg-white text-primary text-uppercase mb-3">Disponibilidad</p>
                                    <h3 class="fw-bold mb-2">Te escuchamos</h3>
                                    <p class="mb-0 opacity-75">Cuéntanos qué necesitas y un asesor te contactará con una propuesta clara y rápida.</p>
                                </div>
                                <div class="bg-white bg-opacity-10 rounded-3 p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="me-2" style="font-size: 1.3rem;">⚡</span>
                                        <div class="fw-semibold">Respuesta en menos de 2 horas hábiles</div>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="me-2" style="font-size: 1.3rem;">🤝</span>
                                        <div class="fw-semibold">Asesor personal que sigue tu pedido</div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2" style="font-size: 1.3rem;">🛠️</span>
                                        <div class="fw-semibold">Equipo técnico listo para prototipos</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

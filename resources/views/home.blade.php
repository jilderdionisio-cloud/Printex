@extends('layouts.guest')

@section('title', 'Inicio | Printex')

@section('content')
    {{-- Hero Carousel --}}
    <div id="printexHero" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#printexHero" data-bs-slide-to="0" class="active" aria-current="true"
                    aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#printexHero" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#printexHero" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner rounded-4 shadow">
            <div class="carousel-item active" data-bs-interval="5000">
                <img src="https://images.unsplash.com/photo-1517430816045-df4b7de11d1d?auto=format&fit=crop&w=1600&q=80"
                     class="d-block w-100" alt="Printex promocion 1">
                <div class="carousel-caption d-none d-md-block text-start">
                    <h2 class="fw-bold">Insumos premium para sublimación</h2>
                    <p>Todo lo que necesitas para impulsar tu negocio creativo.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg" style="background-color:#1e40af;">
                        Ver catálogo
                    </a>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="5000">
                <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=1600&q=80"
                     class="d-block w-100" alt="Printex promocion 2">
                <div class="carousel-caption d-none d-md-block text-start">
                    <h2 class="fw-bold">Cursos certificados</h2>
                    <p>Aprende sublimación, serigrafía y estampado con expertos.</p>
                    <a href="{{ route('courses.index') }}" class="btn btn-warning btn-lg text-dark" style="background-color:#f59e0b;">
                        Ver cursos
                    </a>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="5000">
                <img src="https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=1600&q=80"
                     class="d-block w-100" alt="Printex promocion 3">
                <div class="carousel-caption d-none d-md-block text-start">
                    <h2 class="fw-bold">Equipos de última generación</h2>
                    <p>Maquinaria confiable con soporte técnico garantizado.</p>
                    <a href="{{ url('/about') }}" class="btn btn-outline-light btn-lg">
                        Conócenos
                    </a>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#printexHero" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#printexHero" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>

    {{-- Productos Destacados --}}
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <p class="text-uppercase text-muted small mb-1">Top ventas</p>
                <h3 class="fw-bold">Productos destacados</h3>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary" style="color:#1e40af; border-color:#1e40af;">
                Ver todos
            </a>
        </div>
        <div class="row g-4">
            @foreach ([
                ['name' => 'Tinta Sublimática EPSON 1L', 'price' => 'S/ 89.90', 'category' => 'Tintas'],
                ['name' => 'Plancha Transfer 38x38cm', 'price' => 'S/ 1,850.00', 'category' => 'Maquinaria'],
                ['name' => 'Papel Transfer A4 (100 hojas)', 'price' => 'S/ 45.00', 'category' => 'Papeles'],
                ['name' => 'Vinilo Textil Blanco Rollo 50cm', 'price' => 'S/ 65.00', 'category' => 'Vinilo'],
                ['name' => 'Prensa Térmica 5 en 1', 'price' => 'S/ 2,350.00', 'category' => 'Maquinaria'],
                ['name' => 'Marco Serigráfico 40x50cm', 'price' => 'S/ 120.00', 'category' => 'Serigrafía'],
            ] as $product)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="ratio ratio-16x9 bg-light rounded-top" style="background-color:#e5e7eb;">
                            <div class="d-flex justify-content-center align-items-center text-muted">
                                Imagen producto
                            </div>
                        </div>
                        <div class="card-body">
                            <span class="badge rounded-pill text-bg-light text-primary mb-2" style="color:#1e40af !important;">
                                {{ $product['category'] }}
                            </span>
                            <h5 class="card-title">{{ $product['name'] }}</h5>
                            <p class="card-text fw-semibold text-primary" style="color:#1e40af !important;">
                                {{ $product['price'] }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-sm btn-primary" style="background-color:#1e40af;">Añadir al carrito</button>
                                <a href="{{ route('products.index') }}" class="text-decoration-none text-muted small">Ver detalle</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Cursos Destacados --}}
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <p class="text-uppercase text-muted small mb-1">Aprende con expertos</p>
                <h3 class="fw-bold">Cursos destacados</h3>
            </div>
            <a href="{{ route('courses.index') }}" class="btn btn-sm btn-outline-warning" style="border-color:#f59e0b; color:#f59e0b;">
                Ver todos
            </a>
        </div>
        <div class="row g-4">
            @foreach ([
                ['name' => 'Curso Básico de Sublimación', 'price' => 'S/ 350.00', 'duration' => '4 semanas', 'modality' => 'Presencial'],
                ['name' => 'Curso Avanzado de Serigrafía', 'price' => 'S/ 450.00', 'duration' => '6 semanas', 'modality' => 'Presencial'],
                ['name' => 'Curso Transfer y Estampado Textil', 'price' => 'S/ 400.00', 'duration' => '5 semanas', 'modality' => 'Híbrido'],
            ] as $course)
                <div class="col-12 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <span class="badge text-bg-warning text-dark mb-2" style="background-color:#f59e0b !important;">{{ $course['modality'] }}</span>
                            <h5 class="card-title">{{ $course['name'] }}</h5>
                            <p class="text-muted mb-1"><strong>Duración:</strong> {{ $course['duration'] }}</p>
                            <p class="text-primary fw-bold" style="color:#1e40af !important;">{{ $course['price'] }}</p>
                            <button class="btn btn-outline-primary btn-sm" style="border-color:#1e40af; color:#1e40af;">
                                Ver detalles
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Categorías --}}
    <section class="mb-5">
        <div class="text-center mb-4">
            <p class="text-uppercase text-muted small mb-1">Explora por categoría</p>
            <h3 class="fw-bold">Categorías principales</h3>
        </div>
        <div class="row g-4">
            @foreach (['Tintas', 'Maquinaria', 'Papeles', 'Vinilos', 'Serigrafía', 'Kits'] as $category)
                <div class="col-12 col-md-4 col-lg-2">
                    <div class="card h-100 border-0 shadow-sm text-center py-4 category-card"
                         style="border-top:4px solid #1e40af; transition: transform .2s;">
                        <h6 class="fw-semibold mb-0">{{ $category }}</h6>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Beneficios / Testimonios --}}
    <section class="mb-5">
        <div class="row g-4 align-items-center">
            <div class="col-12 col-lg-6">
                <div class="p-4 rounded-4 shadow-sm bg-white h-100">
                    <p class="text-uppercase text-muted small mb-2">Beneficios</p>
                    <h3 class="fw-bold mb-4">¿Por qué elegir Printex?</h3>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3">
                            <span class="badge bg-primary me-2">1</span>
                            Stock garantizado y soporte técnico especializado.
                        </li>
                        <li class="mb-3">
                            <span class="badge bg-primary me-2">2</span>
                            Cursos certificados con instructores expertos.
                        </li>
                        <li class="mb-3">
                            <span class="badge bg-primary me-2">3</span>
                            Envíos a todo el país y métodos de pago flexibles.
                        </li>
                        <li class="mb-0">
                            <span class="badge bg-primary me-2">4</span>
                            Comunidad activa y asesoría personalizada.
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="row g-4">
                    @foreach ([
                        ['name' => 'María P.', 'role' => 'Emprendedora textil', 'quote' => 'Printex me ayudó a profesionalizar mi taller con equipos confiables.'],
                        ['name' => 'Carlos R.', 'role' => 'Estudiante curso serigrafía', 'quote' => 'Los cursos son prácticos y los instructores comparten mucha experiencia real.'],
                        ['name' => 'Estampados Luna', 'role' => 'Empresa', 'quote' => 'El catálogo es completo y siempre encuentro promociones interesantes.'],
                    ] as $testimonial)
                        <div class="col-12">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <p class="mb-3 fst-italic text-muted">“{{ $testimonial['quote'] }}”</p>
                                    <h6 class="fw-bold mb-0">{{ $testimonial['name'] }}</h6>
                                    <small class="text-muted">{{ $testimonial['role'] }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

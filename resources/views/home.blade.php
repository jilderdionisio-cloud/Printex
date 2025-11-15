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
                <img src="https://cdnx.jumpseller.com/yetiplantillas/image/35365233/Mariana.jpg?1684364515"
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
                <img src="https://audaces.com/wp-content/uploads/2024/03/que-es-sublimacion-min-scaled.webp"
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
                <img src="https://dyethrive.com/wp-content/uploads/2023/11/sublimation-print-on-aluminum-at-home.jpg"
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
            @forelse ($products as $product)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="ratio ratio-16x9 bg-light rounded-top" style="background-color:#e5e7eb;">
                            @if ($product->image)
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="rounded-top object-fit-cover">
                            @else
                                <div class="d-flex justify-content-center align-items-center text-muted">
                                    Imagen producto
                                </div>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <span class="badge rounded-pill text-bg-light text-primary mb-2" style="color:#1e40af !important;">
                                {{ $product->category->name ?? 'General' }}
                            </span>
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text fw-semibold text-primary" style="color:#1e40af !important;">
                                S/ {{ number_format($product->price, 2) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <form method="POST" action="{{ route('cart.add') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button class="btn btn-sm btn-primary" style="background-color:#1e40af;">
                                        Añadir al carrito
                                    </button>
                                </form>
                                <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-muted small">
                                    Ver detalle
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Pronto publicaremos productos destacados.</p>
            @endforelse
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
            @forelse ($courses as $course)
                <div class="col-12 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <span class="badge text-bg-warning text-dark mb-2" style="background-color:#f59e0b !important;">
                                {{ $course->modality }}
                            </span>
                            <h5 class="card-title">{{ $course->name }}</h5>
                            <p class="text-muted mb-1"><strong>Duración:</strong> {{ $course->duration }}</p>
                            <p class="text-primary fw-bold" style="color:#1e40af !important;">S/ {{ number_format($course->price, 2) }}</p>
                            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-outline-primary btn-sm"
                               style="border-color:#1e40af; color:#1e40af;">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Pronto publicaremos nuevos cursos.</p>
            @endforelse
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

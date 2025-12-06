@extends('layouts.guest')

@section('title', 'Inicio | Printex')

@push('styles')
<style>
    /* Slider estilo prototipo */
    .hero-wrapper {
        position: relative;
        left: 50%;
        right: 50%;
        width: 100vw;
        margin-left: -50vw;
        margin-right: -50vw;
    }
    .hero-carousel { width: 100%; }
    .hero-slide {
        position: relative;
        min-height: 620px;
        background-size: cover;
        background-position: center;
        overflow: hidden;
        border-radius: 20px;
    }
    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(115deg, rgba(15, 23, 42, 0.78), rgba(30, 64, 175, 0.92));
    }
    .hero-content {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding: 1rem 3rem 1.5rem;
        padding-left: 6.5rem; /* corre ~3 cm hacia la derecha */
    }
    .hero-inner {
        max-width: 820px;
        text-align: left;
        position: relative;
        z-index: 2;
    }
    .hero-title {
        font-size: clamp(2.4rem, 3vw + 1rem, 3.8rem);
        font-weight: 900;
        letter-spacing: 0.01em;
        color: #fff;
    }
    .hero-subtitle {
        font-size: clamp(1.05rem, 1vw + 0.9rem, 1.45rem);
        font-weight: 700;
        color: #fbbf24;
    }
    .hero-btn {
        border-radius: 10px;
        padding: 0.9rem 1.7rem;
        font-weight: 800;
        letter-spacing: 0.02em;
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.18);
    }
    .hero-btn-primary {
        background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
        color: #0f172a;
        border: none;
    }
    .hero-btn-primary:hover { background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: #0f172a; }
    .hero-btn-secondary {
        background: #fff;
        color: #0f172a;
        border: 1px solid rgba(255, 255, 255, 0.6);
    }
    .hero-control {
        width: auto;
        height: auto;
        top: 50%;
        transform: translateY(-50%);
        padding: 0;
        opacity: 1;
    }
    .hero-control-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(10, 17, 40, 0.78);
        color: #fff;
        font-size: 1.35rem;
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.25);
    }
    .hero-control:hover .hero-control-icon { background: rgba(10, 17, 40, 0.9); }
    .hero-indicators { margin-bottom: 1.8rem; }
    .hero-indicators [data-bs-target] {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.7);
        border: none;
        margin: 0 6px;
    }
    .hero-indicators .active { background-color: #f59e0b; }
    .hero-bottom-band {
        position: relative;
        left: 50%;
        right: 50%;
        width: 100vw;
        margin-left: -50vw;
        margin-right: -50vw;
        background: #0f2b7b;
        color: #e2e8f0;
        padding: 2.5rem 1.25rem;
        text-align: center;
        margin-top: 0;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }
    .hero-bottom-band h2 {
        font-size: clamp(1.6rem, 2vw + 1rem, 2.2rem);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .hero-bottom-band p {
        margin: 0;
        color: #cbd5e1;
    }
    @media (max-width: 768px) {
        .hero-content { padding: 1.5rem 1.25rem 2.5rem; align-items: flex-end; justify-content: flex-start; }
        .hero-slide { min-height: 520px; }
    }

    /* Secciones inferiores */
    .feature-card {
        display: flex;
        gap: 0.9rem;
        align-items: center;
        padding: 1rem 1.1rem;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        box-shadow: 0 12px 28px rgba(0,0,0,0.08);
    }
    .feature-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: #f3f4f6;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #1e40af;
        box-shadow: 0 6px 16px rgba(0,0,0,0.08);
    }
    .feature-title { font-weight: 700; color: #0f172a; }
    .feature-card small { color: #6b7280; }

    .feature-bg-blue { background: #e0f2fe; }
    .feature-bg-yellow { background: #fef3c7; }
    .feature-bg-red { background: #fee2e2; }
    .feature-bg-indigo { background: #e0e7ff; }

    .section-title { font-weight: 800; color: #0f172a; }
    .section-subtitle { color: #6b7280; margin: 0; }

    .product-card, .course-card {
        border: 1px solid #e5e7eb;
        background: #ffffff;
        border-radius: 16px;
        overflow: visible;
        box-shadow: 0 14px 34px rgba(0,0,0,0.1);
    }
    .product-img, .course-thumb { position: relative; overflow: hidden; }
    .product-body, .course-body { padding: 1rem 1.1rem 1.2rem; }
    .price { font-size: 1.1rem; color: #f59e0b !important; }
    .product-card h5,
    .course-card h5 { color: #0f172a; }
    .product-card .text-muted,
    .course-card .text-muted { color: #6b7280 !important; }

    .pill-chip {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        padding: 0.65rem 1.6rem;
        border-radius: 12px;
        font-weight: 700;
        color: #0f172a;
        box-shadow: 0 10px 24px rgba(0,0,0,0.04);
    }

    .benefits-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 1.4rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 14px 34px rgba(0,0,0,0.08);
        color: #0f172a;
    }
    .bullet {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: #0f2b7b;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
    }
    .testimonial-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 1.1rem 1.25rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 10px 24px rgba(0,0,0,0.08);
    }
</style>
@endpush

@section('content')
    {{-- Hero Carousel --}}
    <section class="hero-wrapper">
        <div id="printexHero" class="carousel slide hero-carousel" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-indicators hero-indicators">
                <button type="button" data-bs-target="#printexHero" data-bs-slide-to="0" class="active" aria-current="true"
                        aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#printexHero" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#printexHero" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            <div class="carousel-inner">
                @foreach ([
                    [
                        'image' => 'https://cdnx.jumpseller.com/yetiplantillas/image/35365233/Mariana.jpg?1684364515',
                        'title' => 'Tintas de Alta Calidad',
                        'subtitle' => 'Colores vibrantes y duraderos para todos tus proyectos',
                    ],
                    [
                        'image' => 'https://audaces.com/wp-content/uploads/2024/03/que-es-sublimacion-min-scaled.webp',
                        'title' => 'Equipos de Ultima Generacion',
                        'subtitle' => 'Maquinaria confiable con soporte tecnico garantizado',
                    ],
                    [
                        'image' => 'https://dyethrive.com/wp-content/uploads/2023/11/sublimation-print-on-aluminum-at-home.jpg',
                        'title' => 'Cursos Especializados',
                        'subtitle' => 'Aprende con los mejores profesionales del rubro',
                    ],
                ] as $index => $slide)
                    @php $slideImage = $slide['image'] ?? ''; @endphp
                    <div class="carousel-item @if ($index === 0) active @endif" data-bs-interval="3000">
                        <div class="hero-slide rounded-4 shadow-lg" style="background-image: url('{{ $slideImage }}');">
                            <div class="hero-overlay rounded-4"></div>
                            <div class="hero-content text-white">
                                <div class="hero-inner">
                                    <h1 class="hero-title mb-3">{{ $slide['title'] }}</h1>
                                    <p class="hero-subtitle mb-4">{{ $slide['subtitle'] }}</p>
                                    <div class="d-flex flex-wrap gap-3">
                                        <a href="{{ route('products.index') }}" class="btn hero-btn hero-btn-primary">Ver Productos</a>
                                        <a href="{{ route('courses.index') }}" class="btn hero-btn hero-btn-secondary">Ver Cursos</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev hero-control" type="button" data-bs-target="#printexHero" data-bs-slide="prev">
                <span class="hero-control-icon" aria-hidden="true">&#8249;</span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next hero-control" type="button" data-bs-target="#printexHero" data-bs-slide="next">
                <span class="hero-control-icon" aria-hidden="true">&#8250;</span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </section>
    <div class="hero-bottom-band">
        <h2>Todo lo que necesitas para crear y estampar</h2>
        <p>Compra, aprende y crece con PRINTEX</p>
    </div>

    {{-- Highlights / Productos / Cursos / Beneficios --}}
    <section class="py-5" style="background:#f3f4f6; border-top:1px solid #e5e7eb;">
        <div class="container">
            {{-- Highlights --}}
            <div class="row g-3 mb-5">
                @foreach ([
                    ['icon' => 'bi-send', 'title' => 'Envio rapido', 'text' => 'Entrega en 24-48 horas', 'bg' => 'feature-bg-blue'],
                    ['icon' => 'bi-patch-check-fill', 'title' => 'Calidad garantizada', 'text' => 'Productos certificados', 'bg' => 'feature-bg-yellow'],
                    ['icon' => 'bi-headset', 'title' => 'Atencion experta', 'text' => 'Soporte especializado', 'bg' => 'feature-bg-red'],
                    ['icon' => 'bi-shield-lock', 'title' => 'Compra segura', 'text' => 'Pagos protegidos', 'bg' => 'feature-bg-indigo'],
                ] as $feature)
                    <div class="col-12 col-md-3">
                        <div class="feature-card {{ $feature['bg'] ?? '' }}">
                            <div class="feature-icon"><i class="bi {{ $feature['icon'] }}"></i></div>
                            <div>
                                <p class="feature-title mb-1">{{ $feature['title'] }}</p>
                                <small class="text-muted">{{ $feature['text'] }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Productos Destacados --}}
            <div class="section-header text-center mb-4">
                <span class="badge bg-primary-subtle text-primary-emphasis px-3 py-2 rounded-pill">Lo mejor de Printex</span>
                <h3 class="section-title mt-3">Productos Destacados</h3>
                <p class="section-subtitle">Los insumos mas vendidos para potenciar tu negocio de estampado.</p>
            </div>

            <div class="row g-4 mb-3">
                @forelse ($products as $product)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="product-card h-100">
                            <div class="product-img ratio ratio-4x3">
                                @if ($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="object-fit-cover rounded-top">
                                @else
                                    <div class="d-flex align-items-center justify-content-center text-muted">Imagen producto</div>
                                @endif
                            </div>
                            <div class="product-body">
                                <h5 class="fw-bold mb-2">{{ $product->name }}</h5>
                                <p class="text-muted small mb-3">{{ \Illuminate\Support\Str::limit($product->description ?? 'Descubre mas detalles de este producto.', 80) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price text-primary fw-bold">S/ {{ number_format($product->price, 2) }}</span>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-sm">Ver</a>
                                        @auth
                                            <form method="POST" action="{{ route('cart.add') }}">
                                                @csrf
                                                <input type="hidden" name="type" value="product">
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <button class="btn btn-primary btn-sm">Agregar</button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Inicia sesion</a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light text-center mb-0">Pronto publicaremos productos destacados.</div>
                    </div>
                @endforelse
            </div>
            <div class="text-center mb-5">
                <a href="{{ route('products.index') }}" class="btn btn-primary px-4">Ver todos los productos</a>
            </div>

            {{-- Cursos Recomendados --}}
            <div class="section-header text-center mb-4">
                <h3 class="section-title">Cursos Recomendados</h3>
                <p class="section-subtitle">Aprende de los expertos y lleva tu negocio al siguiente nivel.</p>
            </div>
            <div class="row g-4 mb-3">
                @forelse ($courses as $course)
                    <div class="col-12 col-lg-4">
                        <div class="course-card h-100">
                            <div class="ratio ratio-16x9 rounded-top course-thumb bg-light">
                                @php
                                    $imagePath = $course->image ?? null;
                                @endphp
                                @if (!empty($imagePath))
                                    @if (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://']))
                                        <img src="{{ $imagePath }}" alt="{{ $course->name }}" class="object-fit-cover rounded-top" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $course->name }}" class="object-fit-cover rounded-top" style="width: 100%; height: 100%; object-fit: cover;">
                                    @endif
                                @else
                                    <div class="d-flex align-items-center justify-content-center text-muted">Imagen curso</div>
                                @endif
                            </div>
                            <div class="course-body">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge bg-warning text-dark">{{ $course->modality ?? 'Online' }}</span>
                                    <small class="text-muted">{{ ($course->duration_hours ?? 'N/D') . ' h' }}</small>
                                </div>
                                <h5 class="fw-bold mb-2">{{ $course->name }}</h5>
                                <p class="text-muted small mb-3">{{ \Illuminate\Support\Str::limit($course->description ?? 'Aprende con instructores expertos.', 80) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price text-primary fw-bold">S/ {{ number_format($course->price, 2) }}</span>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-outline-primary btn-sm">Ver mas</a>
                                        @auth
                                            @include('courses.partials.purchase-modal', [
                                                'course' => $course,
                                                'buttonClass' => 'btn btn-primary btn-sm',
                                                'buttonLabel' => 'Adquirir video',
                                                'modalId' => 'home-course-' . $course->id,
                                            ])
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm" style="background-color:#1e40af;">Inicia sesion</a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light text-center mb-0">Pronto publicaremos nuevos cursos.</div>
                    </div>
                @endforelse
            </div>
            <div class="text-center mb-5">
                <a href="{{ route('courses.index') }}" class="btn btn-primary px-4">Ver todos los cursos</a>
            </div>

        </div>
    </section>
@endsection

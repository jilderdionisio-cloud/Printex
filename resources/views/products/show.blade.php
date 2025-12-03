@extends('layouts.app')

@section('title', ($product->name ?? 'Producto') . ' | Printex')

@section('content')
    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                <div class="ratio ratio-4x3 mb-3 rounded-4 bg-light">
                    @if (!empty($product->image_url))
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="rounded-4 object-fit-cover">
                    @else
                        <div class="d-flex justify-content-center align-items-center text-muted fw-semibold">
                            Imagen no disponible
                        </div>
                    @endif
                </div>
                <div class="d-flex gap-2">
                    <div class="ratio ratio-1x1 bg-light rounded flex-fill"></div>
                    <div class="ratio ratio-1x1 bg-light rounded flex-fill"></div>
                    <div class="ratio ratio-1x1 bg-light rounded flex-fill"></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge rounded-pill text-bg-light text-primary" style="color:#1e40af !important;">
                        {{ $product->category->name ?? $product->category ?? 'General' }}
                    </span>
                    <small class="text-muted">ID: {{ $product->id }}</small>
                </div>
                <h1 class="fw-bold mb-3">{{ $product->name }}</h1>
                <div class="d-flex align-items-center gap-3 mb-2">
                    <p class="fs-4 fw-bold text-primary mb-0" style="color:#1e40af !important;">
                        S/ {{ number_format($product->price, 2) }}
                    </p>
                    <div class="d-flex align-items-center gap-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="bi {{ $i <= round($averageRating) ? 'bi-star-fill text-warning' : 'bi-star text-muted' }}"></i>
                        @endfor
                        <small class="text-muted ms-1">
                            {{ $averageRating }} / 5 ({{ $reviews->count() }} reseñas)
                        </small>
                    </div>
                </div>
                <p class="text-muted mb-4">
                    {!! nl2br(e($product->description ?? 'Descripción no disponible por el momento.')) !!}
                </p>
                <ul class="list-unstyled mb-4">
                    <li class="mb-2">
                        <strong>Stock disponible:</strong>
                        <span class="{{ ($product->stock ?? 0) > 0 ? 'text-success' : 'text-danger' }}">
                            {{ $product->stock ?? 0 }} unidades
                        </span>
                    </li>
                    <li class="mb-2"><strong>Categoría:</strong> {{ $product->category->name ?? $product->category ?? 'General' }}</li>
                    <li class="mb-2"><strong>Proveedor:</strong> {{ $product->supplier->name ?? 'N/D' }}</li>
                    <li class="mb-2"><strong>SKU:</strong> {{ $product->sku ?? 'PRX-' . str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</li>
                    <li class="mb-0"><strong>Actualizado:</strong> {{ $product->updated_at?->diffForHumans() ?? 'N/D' }}</li>
                </ul>

                @auth
                    <form method="POST" action="{{ route('cart.add') }}" class="mt-auto">
                        @csrf
                        <input type="hidden" name="type" value="product">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-md-4">
                                <label class="form-label text-muted small text-uppercase">Cantidad</label>
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock ?? 1 }}"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-md-row gap-3">
                            <button type="submit" class="btn btn-lg btn-primary flex-fill" style="background-color:#1e40af;">
                                Añadir al carrito
                            </button>
                            <button type="button" class="btn btn-lg btn-outline-secondary flex-fill">
                                Agregar a favoritos
                            </button>
                        </div>
                    </form>
                @else
                    <div class="mt-auto">
                        <a href="{{ route('login') }}" class="btn btn-lg btn-primary w-100" style="background-color:#1e40af;">
                            Inicia sesión para comprar
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    {{-- Reseñas --}}
    <section class="mt-5">
        <div class="bg-white rounded-4 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <p class="text-uppercase text-muted small mb-1">Opiniones</p>
                    <h3 class="fw-bold mb-0">Comentarios y calificación</h3>
                </div>
                <span class="badge text-bg-light text-primary" style="color:#1e40af !important;">
                    {{ $reviews->count() }} reseñas
                </span>
            </div>

            @auth
                <div class="row g-4">
                    <div class="col-12 col-lg-6">
                        <div class="p-3 border rounded-3 bg-light">
                            <div class="d-flex align-items-center mb-2">
                                <h2 class="mb-0 me-2">{{ $averageRating }}</h2>
                                <div class="d-flex align-items-center gap-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi {{ $i <= round($averageRating) ? 'bi-star-fill text-warning' : 'bi-star text-muted' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-muted mb-0">Basado en {{ $reviews->count() }} reseñas.</p>
                        </div>

                        <form action="{{ route('products.reviews.store', $product->id) }}" method="POST" class="mt-3">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Calificación</label>
                                <div class="d-flex align-items-center gap-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <label class="form-check-label d-flex align-items-center gap-1">
                                            <input type="radio" name="rating" value="{{ $i }}" class="form-check-input" {{ old('rating', 5) == $i ? 'checked' : '' }}>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <span class="small">{{ $i }}</span>
                                        </label>
                                    @endfor
                                </div>
                                @error('rating')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Comentario</label>
                                <textarea name="comment" rows="3" class="form-control @error('comment') is-invalid @enderror" placeholder="Cuéntanos tu experiencia">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary" style="background-color:#1e40af;">
                                Enviar reseña
                            </button>
                        </form>
                    </div>

                    <div class="col-12 col-lg-6">
                        @forelse ($reviews as $review)
                            <div class="border-bottom pb-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>{{ $review->user->name ?? 'Cliente' }}</strong>
                                    <small class="text-muted">{{ $review->created_at?->diffForHumans() }}</small>
                                </div>
                                <div class="d-flex align-items-center gap-1 mb-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi {{ $i <= $review->rating ? 'bi-star-fill text-warning' : 'bi-star text-muted' }}"></i>
                                    @endfor
                                </div>
                                <p class="mb-0 text-muted">{{ $review->comment }}</p>
                            </div>
                        @empty
                            <p class="text-muted mb-0">Aún no hay reseñas. Sé el primero en opinar.</p>
                        @endforelse
                    </div>
                </div>
            @else
                <div class="alert alert-info mt-3 mb-0">
                    <a href="{{ route('login') }}">Inicia sesión</a> para ver y dejar reseñas.
                </div>
            @endauth
        </div>
    </section>

    {{-- Productos relacionados --}}
    <section class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <p class="text-uppercase text-muted small mb-1">Recomendados</p>
                <h3 class="fw-bold mb-0">Productos relacionados</h3>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary" style="color:#1e40af; border-color:#1e40af;">
                Ver catálogo
            </a>
        </div>

        <div class="row g-4">
            @forelse ($relatedProducts ?? [] as $related)
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="ratio ratio-4x3 bg-light rounded-top">
                            @if (!empty($related->image))
                                <img src="{{ $related->image }}" alt="{{ $related->name }}" class="rounded-top object-fit-cover">
                            @else
                                <div class="d-flex justify-content-center align-items-center text-muted">
                                    Imagen no disponible
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <span class="badge rounded-pill text-bg-light text-primary" style="color:#1e40af !important;">
                                {{ $related->category->name ?? $related->category ?? 'General' }}
                            </span>
                            <h6 class="mt-2 mb-1">{{ $related->name }}</h6>
                            <p class="text-primary fw-bold mb-3" style="color:#1e40af !important;">
                                S/ {{ number_format($related->price, 2) }}
                            </p>
                            <a href="{{ route('products.show', $related->id) }}" class="btn btn-sm btn-outline-secondary w-100">
                                Ver producto
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                @foreach (range(1, 4) as $placeholder)
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="ratio ratio-4x3 bg-light rounded-top d-flex justify-content-center align-items-center text-muted">
                                Producto similar
                            </div>
                            <div class="card-body">
                                <span class="badge rounded-pill text-bg-light text-primary" style="color:#1e40af !important;">
                                    Próximamente
                                </span>
                                <h6 class="mt-2 mb-1">Producto relacionado {{ $placeholder }}</h6>
                                <p class="text-primary fw-bold mb-3" style="color:#1e40af !important;">S/ 0.00</p>
                                <button class="btn btn-sm btn-outline-secondary w-100" disabled>
                                    Próximamente
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </section>
@endsection

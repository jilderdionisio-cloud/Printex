@extends('layouts.app')

@section('title', ($product->name ?? 'Producto') . ' | Printex')

@section('content')
    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                <div class="ratio ratio-4x3 mb-3 rounded-4 bg-light">
                    @if (!empty($product->image))
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="rounded-4 object-fit-cover">
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
                <p class="fs-4 fw-bold text-primary" style="color:#1e40af !important;">
                    S/ {{ number_format($product->price, 2) }}
                </p>
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
                    <li class="mb-2"><strong>SKU:</strong> {{ $product->sku ?? 'PRX-' . str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</li>
                    <li class="mb-0"><strong>Actualizado:</strong> {{ $product->updated_at?->diffForHumans() ?? 'N/D' }}</li>
                </ul>

                <form method="POST" action="{{ route('cart.add') }}" class="mt-auto">
                    @csrf
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
            </div>
        </div>
    </div>

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

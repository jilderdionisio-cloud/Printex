@extends('layouts.app')

@section('title', 'Productos | Printex')

@section('content')
    <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
        <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-end justify-content-between gap-3 mb-4">
            <div>
                <p class="text-uppercase text-muted small mb-1">Catálogo</p>
                <h2 class="fw-bold mb-0">Encuentra todo para tu negocio</h2>
            </div>
            <p class="text-muted mb-0">Total productos: <strong>{{ $products->total() ?? $products->count() }}</strong></p>
        </div>

        <form method="GET" class="row g-3">
            <div class="col-12 col-md-6 col-lg-4">
                <label class="form-label text-muted small text-uppercase">Buscar</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#6b7280" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85zm-5.242.656a5 5 0 1 1 0-10 5 5 0 0 1 0 10"/>
                        </svg>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Nombre del producto"
                           value="{{ request('search') }}">
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <label class="form-label text-muted small text-uppercase">Categoría</label>
                <select name="category" class="form-select">
                    <option value="">Todas las categorías</option>
                    @foreach ($categories ?? [] as $category)
                        <option value="{{ $category->id ?? $category }}"
                                @selected(request('category') == ($category->id ?? $category))>
                            {{ $category->name ?? $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <label class="form-label text-muted small text-uppercase">Ordenar por</label>
                <select name="sort" class="form-select">
                    <option value="">Predeterminado</option>
                    <option value="price_asc" @selected(request('sort') === 'price_asc')>Precio (menor a mayor)</option>
                    <option value="price_desc" @selected(request('sort') === 'price_desc')>Precio (mayor a menor)</option>
                    <option value="name_asc" @selected(request('sort') === 'name_asc')>Nombre (A-Z)</option>
                    <option value="name_desc" @selected(request('sort') === 'name_desc')>Nombre (Z-A)</option>
                    <option value="stock_desc" @selected(request('sort') === 'stock_desc')>Stock (mayor a menor)</option>
                </select>
            </div>

            <div class="col-12 col-md-6 col-lg-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100" style="background-color:#1e40af;">
                    Aplicar filtros
                </button>
            </div>
        </form>
    </div>

    @if (($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->isEmpty()) || ($products instanceof \Illuminate\Support\Collection && $products->isEmpty()))
        <div class="text-center py-5">
            <h4 class="fw-bold mb-2">No encontramos resultados</h4>
            <p class="text-muted mb-4">Prueba variando los filtros o busca otro producto.</p>
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary" style="color:#1e40af; border-color:#1e40af;">
                Quitar filtros
            </a>
        </div>
    @else
        <div class="row g-4">
            @foreach ($products as $product)
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="ratio ratio-4x3 bg-light rounded-top" style="background-color:#e5e7eb;">
                            @if (!empty($product->image))
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="rounded-top object-fit-cover">
                            @else
                                <div class="d-flex justify-content-center align-items-center text-muted">
                                    Imagen no disponible
                                </div>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge rounded-pill text-bg-light text-primary" style="color:#1e40af !important;">
                                    {{ $product->category->name ?? $product->category ?? 'General' }}
                                </span>
                                <small class="text-muted">Stock: {{ $product->stock }}</small>
                            </div>
                            <h5 class="card-title mb-2">{{ $product->name }}</h5>
                            <p class="text-primary fw-bold mb-4" style="color:#1e40af !important;">
                                S/ {{ number_format($product->price, 2) }}
                            </p>
                            <div class="mt-auto d-flex gap-2">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-secondary flex-fill">
                                    Ver detalle
                                </a>
                                <form method="POST" action="{{ route('cart.add', $product->id) }}" class="flex-fill">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary w-100" style="background-color:#1e40af;">
                                        Añadir al carrito
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if (method_exists($products, 'links'))
            <div class="mt-4">
                {{ $products->withQueryString()->links() }}
            </div>
        @endif
    @endif
@endsection

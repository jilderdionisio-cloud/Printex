@extends('layouts.admin')

@section('title', 'Productos | Admin')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Productos</h1>
            <p class="text-muted mb-0">Gestiona el catálogo de Printex.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary" style="background-color:#1e40af;">
            <i class="bi bi-plus-circle me-1"></i> Nuevo producto
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-3 mb-3">
                <div class="col-12 col-md-4">
                    <input type="text" class="form-control" placeholder="Buscar por nombre…" name="search" value="{{ request('search') }}">
                </div>
                <div class="col-12 col-md-3">
                    <select class="form-select" name="category">
                        <option value="">Todas las categorías</option>
                        @foreach ($categories ?? [] as $category)
                            <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <select class="form-select" name="sort">
                        <option value="">Ordenar</option>
                        <option value="price_desc">Precio (mayor a menor)</option>
                        <option value="price_asc">Precio (menor a mayor)</option>
                        <option value="stock_desc">Stock (mayor a menor)</option>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <button class="btn btn-outline-secondary w-100" type="submit">Filtrar</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Proveedor</th>
                            <th class="text-end">Precio</th>
                            <th class="text-center">Stock</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? 'Sin categoría' }}</td>
                                <td>{{ $product->supplier->name ?? 'Sin proveedor' }}</td>
                                <td class="text-end">S/ {{ number_format($product->price, 2) }}</td>
                                <td class="text-center">{{ $product->stock }}</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-secondary">Editar</a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                              onsubmit="return confirm('¿Eliminar producto?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No hay productos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($products, 'links'))
                <div class="mt-3">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('title', 'Productos | Admin')

@section('content')
    <style>
        .admin-card {
            border: none;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.12);
            border-radius: 20px;
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
            border: 1px solid #e2e8f0;
        }
        .admin-table thead th {
            background: linear-gradient(90deg, #dbeafe 0%, #c7d2fe 100%);
            color: #0f172a;
            border: none;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .admin-table tbody tr {
            border-bottom: 1px solid #e2e8f0;
        }
        .admin-table tbody tr:hover {
            background: #eef2ff;
        }
        .btn-soft-primary {
            background: #dbeafe;
            color: #1e40af;
            border: none;
            box-shadow: 0 6px 12px rgba(30, 64, 175, 0.15);
        }
        .btn-soft-primary:hover {
            background: #bfdbfe;
            color: #1e3a8a;
        }
        .btn-soft-danger {
            background: #ffe4e6;
            color: #be123c;
            border: none;
            box-shadow: 0 6px 12px rgba(190, 18, 60, 0.12);
        }
        .btn-soft-danger:hover {
            background: #fecdd3;
            color: #9f1239;
        }
        .badge-neutral {
            background: #e2e8f0;
            color: #0f172a;
            border-radius: 10px;
            padding: 6px 12px;
            font-weight: 600;
        }
        .filters-bar {
            background: #fff;
            border-radius: 14px;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.8);
            padding: 10px 12px;
            border: 1px solid #e2e8f0;
        }
    </style>
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Productos</h1>
            <p class="text-muted mb-0">Gestiona el catálogo de Printex.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary" style="background-color:#1e40af;">
            <i class="bi bi-plus-circle me-1"></i> Nuevo producto
        </a>
    </div>

    <div class="card admin-card">
        <div class="card-body">
            <form method="GET" class="row g-3 mb-3 filters-bar">
                <div class="col-12 col-md-4">
                    <input type="text" class="form-control" placeholder="Buscar por nombre…” name="search" value="{{ request('search') }}">
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
                <table class="table align-middle admin-table">
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
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-soft-primary">Editar</a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                              onsubmit="return confirm('¿Eliminar producto?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger">Eliminar</button>
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

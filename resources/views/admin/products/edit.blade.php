@extends('layouts.admin')

@section('title', 'Editar producto | Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Editar producto</h1>
            <p class="text-muted mb-0">{{ $product->name }}</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Volver</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <p class="mb-2 fw-semibold">Revisa los campos:</p>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.products.update', $product) }}" class="row g-4" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-12 col-lg-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="form-label">Proveedor</label>
                    <select name="supplier_id" class="form-select" required @disabled($suppliers->isEmpty())>
                        @if ($suppliers->isEmpty())
                            <option value="">No hay proveedores disponibles</option>
                        @endif
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}"
                                    @selected(old('supplier_id', $product->supplier_id) == $supplier->id)>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($suppliers->isEmpty())
                        <small class="text-danger">Agrega proveedores antes de editar productos.</small>
                    @endif
                </div>
                <div class="col-12 col-lg-6">
                    <label class="form-label">Categoría</label>
                    <select name="category_id" class="form-select" required @disabled($categories->isEmpty())>
                        @if ($categories->isEmpty())
                            <option value="">No hay categorías disponibles</option>
                        @endif
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                    @selected(old('category_id', $product->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($categories->isEmpty())
                        <small class="text-danger">Agrega categorías antes de editar productos.</small>
                    @endif
                </div>
                <div class="col-12">
                    <label class="form-label">Descripción</label>
                    <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Precio (S/)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Imagen</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Deja vacío para mantener la imagen actual. Máx 2MB.</small>
                    @if ($product->image_url)
                        <div class="mt-2">
                            <small class="text-muted d-block">Imagen actual:</small>
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height:120px;">
                        </div>
                    @endif
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" style="background-color:#1e40af;">
                        Actualizar producto
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

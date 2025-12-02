@extends('layouts.admin')

@section('title', 'Nuevo producto | Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Nuevo producto</h1>
            <p class="text-muted mb-0">Completa la información para publicar en el catálogo.</p>
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
            <form method="POST" action="{{ route('admin.products.store') }}" class="row g-4" enctype="multipart/form-data">
                @csrf
                <div class="col-12 col-lg-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="form-label">Proveedor</label>
                    <select name="supplier_id" class="form-select" required @disabled($suppliers->isEmpty())>
                        <option value="">{{ $suppliers->isEmpty() ? 'No hay proveedores disponibles' : 'Seleccione' }}</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    @if ($suppliers->isEmpty())
                        <small class="text-danger">Primero crea un proveedor para poder registrar productos.</small>
                    @endif
                </div>
                <div class="col-12 col-lg-6">
                    <label class="form-label">Categoría</label>
                    <select name="category_id" id="categorySelect" class="form-select" required @disabled($categories->isEmpty())>
                        <option value="">{{ $categories->isEmpty() ? 'No hay categorías disponibles' : 'Seleccione' }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                        <option value="new" @selected(old('category_id') === 'new')>+ Nueva categoría</option>
                    </select>
                    @if ($categories->isEmpty())
                        <small class="text-danger">Primero crea una categoría para poder registrar productos.</small>
                    @endif
                    <div id="newCategoryFields" class="mt-3" style="display: none;">
                        <label class="form-label">Nombre de nueva categoría</label>
                        <input type="text" name="category_name_new" class="form-control mb-2" value="{{ old('category_name_new') }}">
                        <label class="form-label">Descripción (opcional)</label>
                        <input type="text" name="category_description_new" class="form-control" value="{{ old('category_description_new') }}">
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Descripción</label>
                    <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Precio (S/)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock') }}" required>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Imagen</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Formatos permitidos: JPG, PNG, WebP. Máx 2MB.</small>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" style="background-color:#1e40af;">
                        Guardar producto
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const select = document.getElementById('categorySelect');
                const newFields = document.getElementById('newCategoryFields');

                function toggleNewCategory() {
                    const isNew = select.value === 'new';
                    newFields.style.display = isNew ? 'block' : 'none';
                }

                if (select && newFields) {
                    toggleNewCategory();
                    select.addEventListener('change', toggleNewCategory);
                }
            });
        </script>
    @endpush
@endsection

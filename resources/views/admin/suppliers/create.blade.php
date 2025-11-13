@extends('layouts.admin')

@section('title', 'Nuevo proveedor | Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Nuevo proveedor</h1>
            <p class="text-muted mb-0">Registra proveedores para enlazar productos.</p>
        </div>
        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary">Volver</a>
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
            <form method="POST" action="{{ route('admin.suppliers.store') }}" class="row g-4">
                @csrf
                <div class="col-12 col-lg-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="form-label">RUC</label>
                    <input type="text" name="ruc" class="form-control" value="{{ old('ruc') }}" required>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="form-label">Contacto</label>
                    <input type="text" name="contact" class="form-control" value="{{ old('contact') }}">
                </div>
                <div class="col-12 col-lg-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
                <div class="col-12 col-lg-6">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Productos que suministra</label>
                    <textarea name="products" rows="3" class="form-control">{{ old('products') }}</textarea>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" style="background-color:#1e40af;">
                        Guardar proveedor
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

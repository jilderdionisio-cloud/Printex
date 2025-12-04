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
                    <input type="text" name="ruc" class="form-control" value="{{ old('ruc') }}" required
                           pattern="\d{11}" maxlength="11" inputmode="numeric" placeholder="Solo 11 dígitos">
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
                    <div class="row g-2">
                        @foreach ($supplies as $item)
                            <div class="col-6 col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="products[]"
                                           value="{{ $item }}" id="sup-{{ \Illuminate\Support\Str::slug($item) }}"
                                           @if (collect(old('products', []))->contains($item)) checked @endif>
                                    <label class="form-check-label" for="sup-{{ \Illuminate\Support\Str::slug($item) }}">
                                        {{ $item }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
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

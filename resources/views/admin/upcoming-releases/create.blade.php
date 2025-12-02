@extends('layouts.admin')

@section('title', 'Nuevo lanzamiento | Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Nuevo lanzamiento</h1>
            <p class="text-muted mb-0">Registra un próximo producto o curso.</p>
        </div>
        <a href="{{ route('admin.upcoming-releases.index') }}" class="btn btn-outline-secondary">Volver</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.upcoming-releases.store') }}" class="row g-4">
                @csrf
                <div class="col-12 col-md-4">
                    <label class="form-label">Tipo</label>
                    <select name="type" class="form-select" required>
                        <option value="producto" @selected(old('type') === 'producto')>Producto</option>
                        <option value="curso" @selected(old('type') === 'curso')>Curso</option>
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Fecha estimada</label>
                    <input type="date" name="release_date" class="form-control" value="{{ old('release_date') }}">
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select" required>
                        @foreach (['próximo','pospuesto','lanzado'] as $status)
                            <option value="{{ $status }}" @selected(old('status') === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Título</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Descripción</label>
                    <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label">Producto relacionado (opcional)</label>
                    <select name="product_id" class="form-select">
                        <option value="">Ninguno</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label">Curso relacionado (opcional)</label>
                    <select name="course_id" class="form-select">
                        <option value="">Ninguno</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" style="background-color:#1e40af;">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection

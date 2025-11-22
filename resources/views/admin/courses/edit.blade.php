@extends('layouts.admin')

@section('title', 'Editar curso | Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Editar curso</h1>
            <p class="text-muted mb-0">{{ $course->name }}</p>
        </div>
        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">Volver</a>
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
            <form method="POST" action="{{ route('admin.courses.update', $course) }}" class="row g-4">
                @csrf
                @method('PUT')
                <div class="col-12 col-lg-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $course->name) }}" required>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="form-label">Instructor</label>
                    <input type="text" name="instructor" class="form-control" value="{{ old('instructor', $course->instructor) }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Descripción</label>
                    <textarea name="description" rows="4" class="form-control">{{ old('description', $course->description) }}</textarea>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Precio (S/)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $course->price) }}" required>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Duración</label>
                    <input type="text" name="duration" class="form-control" value="{{ old('duration', $course->duration) }}" required>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Modalidad</label>
                    <select name="modality" class="form-select" required>
                        @foreach (['Presencial','Virtual','Híbrido'] as $modality)
                            <option value="{{ $modality }}" @selected(old('modality', $course->modality) === $modality)>
                                {{ $modality }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Cupos</label>
                    <input type="number" name="slots" class="form-control" value="{{ old('slots', $course->slots) }}" required>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">URL de imagen</label>
                    <input type="url" name="image" class="form-control" value="{{ old('image', $course->image) }}">
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" style="background-color:#1e40af;">
                        Actualizar curso
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

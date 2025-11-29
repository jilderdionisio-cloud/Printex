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
            <form method="POST" action="{{ route('admin.courses.update', $course) }}" class="row g-4" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-12 col-lg-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $course->name) }}" required>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="form-label">Instructor</label>
                    <select name="instructor" class="form-select" required @disabled($instructors->isEmpty())>
                        @if ($instructors->isEmpty())
                            <option value="">No hay instructores disponibles</option>
                        @else
                            <option value="" @selected(old('instructor', $course->instructor) === null) hidden>Seleccione</option>
                            @foreach ($instructors as $instructor)
                                <option value="{{ $instructor->name }}" @selected(old('instructor', $course->instructor) === $instructor->name)>
                                    {{ $instructor->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @if ($instructors->isEmpty())
                        <small class="text-danger">Crea usuarios con rol "instructor" para habilitar este campo.</small>
                    @endif
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
                    <label class="form-label">Imagen</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Deja vacío para mantener la imagen actual. Máx 2MB.</small>
                    @if ($course->image_url)
                        <div class="mt-2">
                            <small class="text-muted d-block">Imagen actual:</small>
                            <img src="{{ $course->image_url }}" alt="{{ $course->name }}" class="img-fluid rounded" style="max-height:120px;">
                        </div>
                    @endif
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

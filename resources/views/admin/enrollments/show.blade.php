@extends('layouts.admin')

@section('title', 'Inscripción #' . $enrollment->id)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Inscripción #{{ $enrollment->id }}</h1>
            <p class="text-muted mb-0">Registrada el {{ $enrollment->created_at?->format('d/m/Y H:i') }}</p>
        </div>
        <a href="{{ route('admin.enrollments.index') }}" class="btn btn-outline-secondary">Volver</a>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Datos del alumno</h5>
                    <ul class="list-unstyled text-muted mb-0">
                        <li><strong>Nombre:</strong> {{ $enrollment->student_name ?? $enrollment->user->name }}</li>
                        <li><strong>Email:</strong> {{ $enrollment->student_email ?? $enrollment->user->email }}</li>
                        <li><strong>Teléfono:</strong> {{ $enrollment->student_phone ?? $enrollment->user->phone }}</li>
                        <li><strong>Dirección:</strong> {{ $enrollment->student_address ?? 'No registrada' }}</li>
                        <li><strong>Estado:</strong> {{ $enrollment->status }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Curso</h5>
                    <p class="mb-1"><strong>Nombre:</strong> {{ $enrollment->course->name }}</p>
                    <p class="mb-1"><strong>Modalidad:</strong> {{ $enrollment->course->modality }}</p>
                    <p class="mb-1"><strong>Duración:</strong> {{ $enrollment->course->duration }}</p>
                    <p class="mb-0"><strong>Instructor:</strong> {{ $enrollment->course->instructor }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mt-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Actualizar estado</h5>
            <form method="POST" action="{{ route('admin.enrollments.updateStatus', $enrollment->id) }}">
                @csrf
                @method('PUT')
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label">Estado</label>
                        <select name="status" class="form-select">
                            @foreach (['Activo', 'Pendiente', 'Completado', 'Cancelado'] as $status)
                                <option value="{{ $status }}" @selected($enrollment->status === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <button type="submit" class="btn btn-primary" style="background-color:#1e40af;">
                            Guardar cambios
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
